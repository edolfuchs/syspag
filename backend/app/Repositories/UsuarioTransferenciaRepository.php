<?php

namespace App\Repositories;

use App\Traits\FilterTrait;
use App\Traits\ValidateTrait;
use App\Helpers\Utilidade;
use App\Rules\FloatValidation;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;
use App\Models\UsuarioTransferencia;
use App\Repositories\AuthRepository;
use App\Repositories\Contracts\UsuarioRepositoryIntercace;
use App\Repositories\Contracts\UsuarioExtratoRepositoryIntercace;
use App\Repositories\Contracts\ServiceAutorizadorRepositoryIntercace;
use App\Repositories\Contracts\ServiceNotificacaoRepositoryIntercace;
use App\Repositories\Contracts\UsuarioTransferenciaRepositoryIntercace;

class UsuarioTransferenciaRepository extends UsuarioTransferencia implements UsuarioTransferenciaRepositoryIntercace
{
    use FilterTrait, ValidateTrait;

    public function listar(int $intId = null)
    {

        $objUsuarioRepositoryLogado = AuthRepository::getUsuarioRepositoryLogado();

        $builder = $this->with(
            'objTipoStatusTransferencia',
            'objTipoStatusNotificacao',
            'objUsuarioPagador',
            'objUsuarioBeneficiario'
        )
            ->where('intIdUsuarioPagador', $objUsuarioRepositoryLogado->intId);

        if ($intId) {
            return $builder->where('intId', $intId)->first();
        }

        return $builder
            ->orderBy($this->getOrderBy(), $this->getOrderType())
            ->paginate($this->getTotalPage());
    }

    public function efetuarTransferencia(array $arrayData, UsuarioRepositoryIntercace $objUsuarioRepositoryIntercace, UsuarioExtratoRepositoryIntercace $objUsuarioExtratoRepositoryIntercace, ServiceAutorizadorRepositoryIntercace $objServiceAutorizadoInterface, ServiceNotificacaoRepositoryIntercace $objServiceNotificacaoInterface):int
    {
        $arrayData = $this->validate(
            $arrayData,
            array(
                'intIdUsuarioBeneficiario' => 'required|numeric|min:1',
                'floatValor' => ['required', new FloatValidation()],
            )
        );

        $objUsuarioRepositoryLogado = AuthRepository::getUsuarioRepositoryLogado();

        DB::beginTransaction();

        try {

            if ($objUsuarioRepositoryLogado->objTipoUsuario->intId == 3) {
                throw new CustomException("Você não possui permissão para realizar transferências");
            }

            if (!$objUsuarioBeneficiario = $objUsuarioRepositoryIntercace->listar($arrayData['intIdUsuarioBeneficiario'])) {
                throw new CustomException("Beneficiário inválido ou não permito para transferência.", 400, ['intIdUsuarioBeneficiario' => 'Beneficiário inválido ou não permito para transferência.']);
            }

            if (floatval($arrayData['floatValor']) <= 0) {
                throw new CustomException("Valor incorreto. Por favor informe um valor decimal maior que 0.00", 400, ['floatValor' => 'Valor incorreto. Por favor informe um valor decimal maior que 0.00']);
            }

            //VALIDAR SE O PAGADOR POSSUI SALDO PARA TRANSFERIR
            if (floatval($arrayData['floatValor']) > $objUsuarioExtratoRepositoryIntercace->listarSaldoPorUsuario($objUsuarioRepositoryLogado->intId)) {
                throw new CustomException("Você não possui saldo suficiente para essa transação", 400, ['floatValor' => 'Você não possui saldo suficiente para essa transação']);
            }

            //REGISTRAR TRANSAÇÃO
            $objUsuarioTransferencia = $this->firstOrNew(['intId' => 0]);
            $objUsuarioTransferencia->intIdUsuarioPagador = $objUsuarioRepositoryLogado->intId;
            $objUsuarioTransferencia->intIdUsuarioBeneficiario = $objUsuarioBeneficiario->intId;
            $objUsuarioTransferencia->intIdTipoStatusTransferencia = 5;
            $objUsuarioTransferencia->intIdTipoStatusNotificacao = 10;
            $objUsuarioTransferencia->strDataNotificacao = Utilidade::toDate();
            $objUsuarioTransferencia->strObservacao = 'Usuário Notificado em '.Utilidade::toDate();
            $objUsuarioTransferencia->floatValor = $arrayData['floatValor'];
            $objUsuarioTransferencia->save();

            //REGISTRAR EXTRATO DE DÉBITO PARA QUEM TRANSFERIU
            $objUsuarioExtratoRepositoryIntercace->cadastrarExtrato(
                array_merge(
                    $arrayData,
                    [
                        'strObservacao' => 'Débito de transferência',
                        'intIdUsuarioLancamento' => $objUsuarioBeneficiario->intId
                    ]
                ),
                $objUsuarioTransferencia->intIdUsuarioPagador,
                13,
                $objUsuarioRepositoryIntercace
            );

            //REGISTRAR EXTRATO DE CRÉDITO DE QUEM TRANSFERIU PARA QUEM RECEBEU
            $objUsuarioExtratoRepositoryIntercace->cadastrarExtrato(
                array_merge(
                    $arrayData,
                    [
                        'strObservacao' => 'Crédito recebido via transferência',
                        'intIdUsuarioLancamento' => $objUsuarioTransferencia->intIdUsuarioPagador
                    ]
                ),
                $objUsuarioTransferencia->intIdUsuarioBeneficiario,
                14,
                $objUsuarioRepositoryIntercace
            );

            //VALIDAR A TRANSFERENCIA VIA SERVIÇO EXTERNO
            $strAutorizarTransferencia = $objServiceAutorizadoInterface->autorizar();
            if ($strAutorizarTransferencia !== true) {
                throw new \Exception("Transferência não autorizada. " . $strAutorizarTransferencia);
            }

            //NOTIFICAR O BENEFICIÁRIO VIA SERVIÇO EXTERNO
            $strNotificarTransferencia = $objServiceNotificacaoInterface->notificar();

            if ($strNotificarTransferencia !== true) {
                $objUsuarioTransferencia->intIdTipoStatusNotificacao = 11;
                $objUsuarioTransferencia->strObservacao = "Notificação da transferência não enviado. " . $strNotificarTransferencia;
                $objUsuarioTransferencia->strDataNotificacao = null;
                $objUsuarioTransferencia->save();
            }

            DB::commit();

            return $objUsuarioTransferencia->intId;
        } catch (CustomException $th) {
            DB::rollBack();
            throw new CustomException($th->getMessage(), $th->getStatus(), $th->getOptions());
        } catch (\Exception $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }
}
