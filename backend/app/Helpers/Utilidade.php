<?php

namespace App\Helpers;

use \Carbon\Carbon;

use function GuzzleHttp\json_encode;

class Utilidade
{

    public static function toJson($data, $status = 200)
    {

        $header = array(
            'Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
            'Version' => config('app.version'),
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => '*',
            'Access-Control-Allow-Headers' => '*'
        );

        if ($status != 200) {
            $data = [
                'error' => $data
            ];
        }

        return response()
            ->json($data, $status, $header, JSON_UNESCAPED_UNICODE, true)
            ->setData($data);
    }

    public static function toDate($value = null, $format_in = 'd/m/Y', $format_out = 'Y-m-d H:i:s')
    {

        try {

            $format_in = ($format_in ? $format_in : 'd/m/Y');
            $format_out = ($format_out ? $format_out : 'Y-m-d H:i:s');

            if (!$value) {
                $value = Carbon::now();
                $format_in = 'Y-m-d H:m:s';
                return date($format_out);
            }
            if (!empty($value)) {
                $date = Carbon::createFromFormat($format_in, $value);
                return $date->format($format_out);
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function dateAdd($add, $date = null, $type = 'M', $uteis = false)
    {

        if ($date == null) {
            $date = Carbon::now();
        } else {
            $date = Carbon::parse($date);
        }

        $retorno = $date;

        switch ($type) {

            case 'M':
                $retorno = $date->addMonths($add);
                break;

            case 'D':
                $retorno = $date->addDays($add);
                $add = self::totalFeriado(Carbon::now(), $retorno);

                if ($add > 0 && $uteis) {
                    $retorno = $retorno->addDays($add);
                }
                break;

            case 'Y':
                $retorno = $date->addYears($add);
                break;

            case 'm':
                $retorno = $date->addMinutes($add);
                break;

            case 's':
                $retorno = $date->addSeconds($add);
                break;

            case 'h':
                $retorno = $date->addHours($add);
                break;
        }

        if ($uteis) {

            $dia = $retorno->day;
            $mes = $retorno->month;
            $ano = $retorno->year;

            $arrDiasUteis = self::diasUteis($mes, $ano);


            if (!in_array($dia, $arrDiasUteis)) {

                foreach ($arrDiasUteis as $item) {
                    if ($item > $dia) {

                        $timestamp = mktime(0, 0, 0, $mes, $item, $ano);
                        $data = date("Y-m-d H:i:s", $timestamp);

                        return $data;
                    }
                }

                $ano = ($mes == 12 ? ($ano + 1) : $ano);
                $mes = ($mes == 12 ? 1 : ($mes + 1));

                $arrDiasUteis = self::diasUteis($mes, $ano);

                $dia = $arrDiasUteis[0];

                $timestamp = mktime(0, 0, 0, $mes, $dia, $ano);
                $data = date("Y-m-d H:i:s", $timestamp);

                return $data;
            }
        }
        return $retorno->toDateTimeString();
    }

    public static function dateDiff($dt_maior = null, $dt_menor = null, $str_interval = 'd', $relative = true)
    {

        $dt_menor = (!$dt_menor ? date("Y-m-d H:i:s") : $dt_menor);
        $dt_maior = (!$dt_maior ? date("Y-m-d H:i:s") : $dt_maior);

        if (is_string($dt_menor)) $dt_menor = date_create($dt_menor);
        if (is_string($dt_maior)) $dt_maior = date_create($dt_maior);

        $diff = date_diff($dt_menor, $dt_maior, !$relative);

        switch ($str_interval) {
            case "y":
                $total = $diff->y + $diff->m / 12 + $diff->d / 365.25;
                break;
            case "m":
                $total = (($diff->y * 12) + $diff->m + ($diff->d / 30) + ($diff->h / 24));
                break;
            case "d":
                $total = $diff->y * 365.25 + $diff->m * 30 + $diff->d + $diff->h / 24 + $diff->i / 60;
                break;
            case "h":
                $total = ($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h + $diff->i / 60;
                break;
            case "i":
                $total = (($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i + $diff->s / 60;
                break;
            case "s":
                $total = ((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i) * 60 + $diff->s;
                break;
        }

        if ($diff->invert && $total >= 1) {
            return -1 * $total;
        }

        return $total;
    }

    public static function isCpf($cpf)
    {
        $cpf = self::onlyNumber($cpf);

        if (strlen($cpf) != 11) return false;

        $sum = 0;
        $cpf = str_split($cpf);
        $cpftrueverifier = array();
        $cpfnumbers = array_splice($cpf, 0, 9);
        $cpfdefault = array(10, 9, 8, 7, 6, 5, 4, 3, 2);

        for ($i = 0; $i <= 8; $i++) {
            $sum += $cpfnumbers[$i] * $cpfdefault[$i];
        }

        $sumresult = $sum % 11;

        if ($sumresult < 2) {
            $cpftrueverifier[0] = 0;
        } else {
            $cpftrueverifier[0] = 11 - $sumresult;
        }

        $sum = 0;
        $cpfdefault = array(11, 10, 9, 8, 7, 6, 5, 4, 3, 2);
        $cpfnumbers[9] = $cpftrueverifier[0];

        for ($i = 0; $i <= 9; $i++) {
            $sum += $cpfnumbers[$i] * $cpfdefault[$i];
        }

        $sumresult = $sum % 11;

        if ($sumresult < 2) {
            $cpftrueverifier[1] = 0;
        } else {
            $cpftrueverifier[1] = 11 - $sumresult;
        }

        $returner = false;

        if ($cpf == $cpftrueverifier) {
            $returner = true;
        }

        $cpfver = array_merge($cpfnumbers, $cpf);

        if (count(array_unique($cpfver)) == 1 || $cpfver == array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0)) {
            $returner = false;
        }

        if ($returner)
            return true;

        return false;
    }

    public static function isCnpj($cnpj)
    {

        $cnpj = self::onlyNumber($cnpj);

        // Valida tamanho
        if (strlen($cnpj) != 14) {
            return false;
        }

        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj{
                $i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($cnpj{
            12} != ($resto < 2 ? 0 : 11 - $resto))
            return false;

        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj{
                $i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        $returner = $cnpj{
            13} == ($resto < 2 ? 0 : 11 - $resto);

        if ($returner)
            return true;

        return false;
    }

    public static function isEmail($email)
    {

        if (filter_var($email, FILTER_VALIDATE_EMAIL))
            return true;

        return false;
    }

    public static function isFloat($value)
    {
        return filter_var($value, FILTER_VALIDATE_FLOAT);
    }

    public static function isDate($value)
    {
        $date = explode('-', $value);

        if (count($date) != 3) return false;

        return checkdate($date[1], $date[2], $date[0]);
    }

    public static function textLimit($text, $max)
    {

        if (strlen($text) > $max) {
            return substr($text, 0, $max);
        }

        return $text;
    }

    public static function generatePassword($length, $onlyNumber = false, $lowercase = false)
    {

        $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';

        if ($onlyNumber) {
            $password =  substr(str_shuffle(self::onlyNumber($data)), 0, $length);
        } else {
            $password = substr(str_shuffle($data), 0, $length);
        }

        if ($lowercase) {
            $password = self::lowerCase($password);
        }

        return $password;
    }

    public static function getDadosCNPJ($cnpj)
    {

        $dadosEmpresa = [];

        try {

            $cnpj = preg_replace("/[^0-9]/", "", $cnpj);

            return Cache::remember('getDadosCnpj.' . $cnpj, config('cache.minutes'), function () use ($cnpj) {

                if ($result = Http::withHeaders([
                    'Authorization' => (config('app.url_cnpj_token') ? 'Bearer ' . config('app.url_cnpj_token') : null)
                ])->get(config('app.url_cnpj') . '/' . $cnpj)) {

                    $status = $result->getStatusCode();

                    if ($status == 200) {
                        $result = $result->getBody()->getContents();
                        $result = !empty($result) ? json_decode($result, true) : '';

                        $dadosEmpresa = $result;
                    }
                }

                return $dadosEmpresa;
            });
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
            return [];
        }
    }

    public static function upperCase($value)
    {
        return strtr(strtoupper($value), "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");
    }

    public static function lowerCase($value)
    {
        return strtr(strtolower($value), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß", "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
    }

    public static function onlyNumber($value)
    {

        if (!$value) return '';

        $value = preg_replace("/[^0-9]/", "", $value);

        if (!$value)
            return null;

        return $value;
    }

    public static function onlyMoney($value)
    {

        if (!$value) return '';

        $value = preg_replace("/[^0-9,.]/", "", $value);
        return $value;
    }

    public static function removeSpecialChar($texto)
    {

        $texto = preg_replace(
            array(
                "/(á|à|ã|â|ä)/",
                "/(Á|À|Ã|Â|Ä)/",
                "/(é|è|ê|ë)/",
                "/(É|È|Ê|Ë)/",
                "/(í|ì|î|ï)/",
                "/(Í|Ì|Î|Ï)/",
                "/(ó|ò|õ|ô|ö)/",
                "/(Ó|Ò|Õ|Ô|Ö)/",
                "/(ú|ù|û|ü)/",
                "/(Ú|Ù|Û|Ü)/",
                "/(ñ)/",
                "/(Ñ)/",
            ),
            explode(" ", "a A e E i I o O u U n N"),
            $texto
        );

        $texto = preg_replace("/ç/", "c", $texto);
        $texto = preg_replace("/Ç/", "C", $texto);
        $texto = preg_replace('/[^A-Za-z0-9 ]/', '', $texto);

        return trim($texto);
    }

    public static function moneyToInteger($value)
    {

        $value = self::onlyMoney($value);

        return floatval(trim(str_replace(",", ".", str_replace(".", "", $value)))) * 100;
    }

    public static function moneyToFloat($value)
    {

        //if(!$value)return null;
        return floatval(trim(str_replace(",", ".", str_replace(".", "", $value))));
    }

    public static function floatToMoney($value)
    {

        try {
            return number_format($value, 2, ',', '.');
        } catch (\Exception $e) {
            throw new \Exception("[floatToMoney] Value `" . $value . "` " . $e->getMessage());
        }
    }

    public static function integerToMoney($value)
    {
        try {
            return number_format(floatval(round($value / 100, 2)), 2, ',', '.');
        } catch (\Exception $e) {
            throw new \Exception("[integerToMoney] Value `" . $value . "` " . $e->getMessage());
        }
    }

    public static function integerToFloat($value)
    {

        try {
            return floatval(round($value / 100, 2));
        } catch (\Exception $e) {
            throw new \Exception("[integerToFloat] Value `" . $value . "` " . $e->getMessage());
        }
    }

    public static function diasUteis($mes, $ano)
    {

        $uteis = 0;
        $arrUteis = [];
        $arrFeriado = self::getFeriados($ano);
        // Obtém o número de dias no mês
        // (http://php.net/manual/en/function.cal-days-in-month.php)
        $dias_no_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);

        for ($dia = 1; $dia <= $dias_no_mes; $dia++) {

            // Aqui você pode verifica se tem feriado
            // ----------------------------------------
            // Obtém o timestamp
            // (http://php.net/manual/pt_BR/function.mktime.php)
            $timestamp = mktime(0, 0, 0, $mes, $dia, $ano);
            $semana    = date("N", $timestamp);

            if ($semana < 6 && isset($arrFeriado[$mes]) && !in_array($dia, $arrFeriado[$mes])) {
                $uteis++;
                array_push($arrUteis, $dia);
            }
        }

        return $arrUteis;
    }
}
