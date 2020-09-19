<?php

namespace App\Providers;

use App\Repositories\AuthRepository;
use App\Repositories\TipoRepository;
use App\Repositories\UsuarioRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\UsuarioExtratoRepository;
use App\Repositories\ServiceAutorizadorRepository;
use App\Repositories\ServiceNotificacaoRepository;
use App\Repositories\UsuarioTransferenciaRepository;
use App\Repositories\Contracts\AuthRepositoryIntercace;
use App\Repositories\Contracts\TipoRepositoryIntercace;
use App\Repositories\Contracts\UsuarioRepositoryIntercace;
use App\Repositories\Contracts\UsuarioExtratoRepositoryIntercace;
use App\Repositories\Contracts\ServiceAutorizadorRepositoryIntercace;
use App\Repositories\Contracts\ServiceNotificacaoRepositoryIntercace;
use App\Repositories\Contracts\UsuarioTransferenciaRepositoryIntercace;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UsuarioRepositoryIntercace::class, UsuarioRepository::class);
        $this->app->bind(UsuarioExtratoRepositoryIntercace::class, UsuarioExtratoRepository::class);
        $this->app->bind(UsuarioTransferenciaRepositoryIntercace::class, UsuarioTransferenciaRepository::class);
        $this->app->bind(AuthRepositoryIntercace::class, AuthRepository::class);
        $this->app->bind(TipoRepositoryIntercace::class, TipoRepository::class);
        $this->app->bind(ServiceAutorizadorRepositoryIntercace::class, ServiceAutorizadorRepository::class);
        $this->app->bind(ServiceNotificacaoRepositoryIntercace::class, ServiceNotificacaoRepository::class);
    }
}
