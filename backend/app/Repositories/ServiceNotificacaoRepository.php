<?php

namespace App\Repositories;

use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Http;
use App\Repositories\Contracts\ServiceNotificacaoRepositoryIntercace;

class ServiceNotificacaoRepository implements ServiceNotificacaoRepositoryIntercace
{

    public function notificar()
    {
        if ($result = Http::get(config('service.url_notificar_transferencia'))) {

            $status = $result->getStatusCode();

            if ($status == 200) {
                $result = $result->getBody()->getContents();
                $result = !empty($result) ? json_decode($result, true) : '';

                if (isset($result['message']) && $result['message'] == 'Enviado') {
                    return true;
                }
            }

            return 'Falha ao notificar o beneficiário.';
        }
    }
}
