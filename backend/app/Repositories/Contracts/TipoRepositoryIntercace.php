<?php

namespace App\Repositories\Contracts;

interface TipoRepositoryIntercace extends AsyncInterface
{
    public function cadastrarTipo(array $arrayData);
}
