<?php

namespace App\Http\Controllers;

use App\Repositories\AuthRepository;
use App\Repositories\Contracts\UsuarioRepositoryIntercace;
use App\Repositories\Contracts\UsuarioExtratoRepositoryIntercace;

class UsuarioExtratoController extends BaseController
{

    private $repro;

    public function __construct(UsuarioExtratoRepositoryIntercace $repro)
    {
        $this->repro = $repro;
    }

    public function listar(int $intId = null)
    {
        return $this->setResponse($this->repro->listar($intId));
    }

    public function cadastrarExtrato(UsuarioRepositoryIntercace $objUsuarioRepositoryIntercace)
    {
        return $this->setResponse(
            $this->repro->cadastrarExtrato(
                $this->getRequest()->all(),
                AuthRepository::getUsuarioRepositoryLogado()->intId,
                14,
                $objUsuarioRepositoryIntercace
            )
        );
    }
}
