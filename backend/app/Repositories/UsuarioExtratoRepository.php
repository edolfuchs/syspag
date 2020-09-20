<?php

namespace App\Repositories;

use App\Traits\FilterTrait;
use App\Traits\ValidateTrait;

use App\Models\UsuarioExtrato;
use App\Rules\FloatValidation;
use App\Exceptions\CustomException;
use App\Repositories\AuthRepository;
use App\Repositories\Contracts\UsuarioRepositoryIntercace;
use App\Repositories\Contracts\UsuarioExtratoRepositoryIntercace;

class UsuarioExtratoRepository extends UsuarioExtrato implements UsuarioExtratoRepositoryIntercace
{
    use FilterTrait, ValidateTrait;

    public function listar(int $intId = null)
    {

        $objUsuarioRepositoryLogado = AuthRepository::getUsuarioRepositoryLogado();

        return $this
            ->with(
                'objTipoLancamento',
                'objUsuario',
                'objUsuarioLancamento'
            )
            ->where('intIdUsuario', $objUsuarioRepositoryLogado->intId)
            ->orderBy($this->getOrderBy(), $this->getOrderType())
            ->paginate($this->getTotalPage());
    }

    public function listarSaldoPorUsuario(int $intIdUsuario):float
    {
        $floatSaldoDebito = $this
            ->where('intIdUsuario', $intIdUsuario)
            ->where('intIdTipoLancamento', 13)
            ->sum('floatValor');

        $floatSaldoCredito = $this
            ->where('intIdUsuario', $intIdUsuario)
            ->where('intIdTipoLancamento', 14)
            ->sum('floatValor');

        return floatval($floatSaldoCredito - $floatSaldoDebito);
    }


    public function cadastrarExtrato(array $arrayData, int $intIdUsuario, int $intIdTipoLancamento, UsuarioRepositoryIntercace $objUsuarioRepositoryIntercace):int
    {

        $arrayData = $this->validate(
            $arrayData,
            array(
                'floatValor' => ['required', new FloatValidation()],
            )
        );

        try {

            if (!$objIdUsuario = $objUsuarioRepositoryIntercace->listar($intIdUsuario)) {
                throw new \Exception("Usuário não encontrado");
            }

            $intIdUsuarioLancamento = null;
            if (isset($arrayData['intIdUsuarioLancamento'])) {
                if ($objIdUsuarioLancamento = $objUsuarioRepositoryIntercace->listar($arrayData['intIdUsuarioLancamento'])) {
                    $intIdUsuarioLancamento = $objIdUsuarioLancamento->intId;
                }
            }

            $objUsuarioExtrato = $this->firstOrNew(['intId' => 0]);
            $objUsuarioExtrato->intIdTipoLancamento = $intIdTipoLancamento;
            $objUsuarioExtrato->floatValor = $arrayData['floatValor'];
            $objUsuarioExtrato->intIdUsuarioLancamento = $intIdUsuarioLancamento;
            $objUsuarioExtrato->intIdUsuario = $objIdUsuario->intId;
            $objUsuarioExtrato->strObservacao = (isset($arrayData['strObservacao']) ? $arrayData['strObservacao'] : null);
            $objUsuarioExtrato->save();

            return $objUsuarioExtrato->intId;
        } catch (CustomException $th) {
            throw new CustomException($th->getMessage(), $th->getStatus(), $th->getOptions());
        } catch (\Exception $th) {
            throw new \Exception($th->getMessage());
        }
    }
}
