<?php

namespace App\Repositories\Contracts;

use App\Repositories\AuthRepository;

interface AuthRepositoryIntercace
{

    public function loginAsync(array $arrayData):array;

    public function logoutAsync():string;

    public static function setUsuarioRepositoryLogado(AuthRepository $objUsuarioRepository);

    public static function getUsuarioRepositoryLogado():AuthRepository;
}
