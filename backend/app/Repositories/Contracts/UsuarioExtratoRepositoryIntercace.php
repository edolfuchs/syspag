<?php

namespace App\Repositories\Contracts;

interface UsuarioExtratoRepositoryIntercace extends AsyncInterface
{

    public function listarSaldoPorUsuario(int $intIdUsuario):float;

    public function cadastrarExtrato(array $arrayData, int $intIdUsuario, int $intIdTipoLancamento, UsuarioRepositoryIntercace $objUsuarioRepositoryInterface):int;
}
