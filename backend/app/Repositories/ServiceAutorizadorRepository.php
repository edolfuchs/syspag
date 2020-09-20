<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use App\Repositories\Contracts\ServiceAutorizadorRepositoryIntercace;

class ServiceAutorizadorRepository implements ServiceAutorizadorRepositoryIntercace
{

    public function autorizar():bool
    {
        if ($result = Http::get(config('service.url_autorizar_transferencia'))) {

            $status = $result->getStatusCode();

            if ($status == 200) {
                $result = $result->getBody()->getContents();
                $result = !empty($result) ? json_decode($result, true) : '';

                if (isset($result['message']) && $result['message'] == 'Autorizado') {
                    return true;
                }
            }

            throw new \Exception("Falha ao autorizar a transferência");
        }
    }
}
