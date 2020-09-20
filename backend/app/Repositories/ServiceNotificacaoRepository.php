<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use App\Repositories\Contracts\ServiceNotificacaoRepositoryIntercace;

class ServiceNotificacaoRepository implements ServiceNotificacaoRepositoryIntercace
{

    public function notificar():bool
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

            throw new \Exception("Falha ao autorizar ao notificar o beneficiário");
        }
    }
}
