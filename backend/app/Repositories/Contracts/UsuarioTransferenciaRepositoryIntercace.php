<?php

namespace App\Repositories\Contracts;

interface UsuarioTransferenciaRepositoryIntercace extends AsyncInterface
{

    public function efetuarTransferencia(array $arrayData, UsuarioRepositoryIntercace $objUsuarioRepositoryInterface, UsuarioExtratoRepositoryIntercace $objUsuarioExtratoRepositoryIntercace, ServiceAutorizadorRepositoryIntercace $objServiceAutorizadoInterface, ServiceNotificacaoRepositoryIntercace $objServiceNotificacaoInterface);
}
