<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\AuthRepositoryIntercace;
use App\Repositories\Contracts\UsuarioExtratoRepositoryIntercace;

class AuthController extends BaseController
{

    private $repro;

    public function __construct(AuthRepositoryIntercace $repro)
    {
        $this->repro = $repro;
    }

    public function me()
    {
        return $this->setResponse($this->repro->getUsuarioRepositoryLogado());
    }

    public function login()
    {
        return $this->setResponse($this->repro->loginAsync($this->getRequest()->all()));
    }

    public function logout()
    {
        return $this->setResponse($this->repro->logoutAsync());
    }
}
