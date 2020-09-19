<?php

namespace App\Http\Middleware;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Exceptions\CustomException;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use App\Repositories\Contracts\AuthRepositoryIntercace;

class ValidateJwt extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected $domain;

    public function __construct()
    {
    }

    public function handle($request, \Closure $next)
    {

        if (!$objUsuarioRepository = Auth::user()) {
            throw new CustomException('Sua sessão expirou.', 401);
        }

        AuthRepository::setUsuarioRepositoryLogado($objUsuarioRepository);

        return $next($request);
    }
}
