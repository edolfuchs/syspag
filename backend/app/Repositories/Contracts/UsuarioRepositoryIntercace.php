<?php

namespace App\Repositories\Contracts;

interface UsuarioRepositoryIntercace extends AsyncInterface
{
    public function cadastrarUsuario(array $arrayData):int;
}
