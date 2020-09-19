<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\UsuarioRepositoryIntercace;
use App\Repositories\Contracts\UsuarioExtratoRepositoryIntercace;
use App\Repositories\Contracts\ServiceAutorizadorRepositoryIntercace;
use App\Repositories\Contracts\ServiceNotificacaoRepositoryIntercace;
use App\Repositories\Contracts\UsuarioTransferenciaRepositoryIntercace;

class UsuarioTransferenciaController extends BaseController
{

	private $repro;

	public function __construct(UsuarioTransferenciaRepositoryIntercace $repro)
	{
		$this->repro = $repro;
	}

	public function listar(int $intId = null)
	{
		return $this->setResponse($this->repro->listar($intId));
	}

	public function efetuarTransferencia(UsuarioRepositoryIntercace $objUsuarioRepositoryIntercace, UsuarioExtratoRepositoryIntercace $objUsuarioExtratoRepositoryIntercace, ServiceAutorizadorRepositoryIntercace $objServiceAutorizadoInterface, ServiceNotificacaoRepositoryIntercace $objServiceNotificacaoInterface)
	{
		return $this->setResponse(
			$this->repro->efetuarTransferencia(
				$this->getRequest()->all(),
				$objUsuarioRepositoryIntercace,
				$objUsuarioExtratoRepositoryIntercace,
				$objServiceAutorizadoInterface,
				$objServiceNotificacaoInterface
			)
		);
	}
}
