<?php

namespace App\Http\Controllers;

use App\Repositories\AuthRepository;
use App\Repositories\Contracts\UsuarioRepositoryIntercace;
use App\Repositories\Contracts\UsuarioExtratoRepositoryIntercace;

class UsuarioController extends BaseController
{

    private $repro;

    public function __construct(UsuarioRepositoryIntercace $repro)
    {
        $this->repro = $repro;
    }

    public function listar(int $intId = null)
    {
        return $this->setResponse($this->repro->listar($intId));
    }

    public function listarSaldoPorUsuario(UsuarioExtratoRepositoryIntercace $objUsuarioExtratoRepositoryIntercace)
    {
        return $this->setResponse(
            $objUsuarioExtratoRepositoryIntercace->listarSaldoPorUsuario(AuthRepository::getUsuarioRepositoryLogado()->intId)
        );
    }

    public function cadastrarUsuario()
    {
        return $this->setResponse($this->repro->cadastrarUsuario($this->getRequest()->all()));
    }
}
