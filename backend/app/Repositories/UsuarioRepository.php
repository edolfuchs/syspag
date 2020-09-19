<?php

namespace App\Repositories;

use App\Models\Usuario;
use App\Traits\FilterTrait;
use App\Traits\ValidateTrait;
use App\Helpers\Utilidade;
use App\Rules\FloatValidation;
use App\Rules\DocumentoValidation;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;
use App\Repositories\AuthRepository;
use App\Repositories\Contracts\UsuarioRepositoryIntercace;

class UsuarioRepository extends Usuario implements UsuarioRepositoryIntercace
{

    use ValidateTrait, FilterTrait;

    public function __construct()
    {
    }

    public function listar(int $intId = null)
    {

        $objUsuarioRepositoryLogado = AuthRepository::getUsuarioRepositoryLogado();

        $builder = $this;

        if ($intId) {
            return $builder->where('intId', $intId)->first();
        }

        return $builder
            ->where('intId', '<>', $objUsuarioRepositoryLogado->intId)
            ->orderBy($this->getOrderBy(), $this->getOrderType())
            ->paginate($this->getTotalPage());
    }

    public function cadastrarUsuario(array $arrayData)
    {   

        $arrayData = $this->validate(
            $arrayData,
            array(
                'intId' => 'required|numeric|min:0',
                'strNome' => 'required|max:100',
                'intIdTipoUsuario' => 'required|numeric|min:2|max:3',
                'strEmail' => 'required|email|max:100',
                'strSenha' => 'required|min:6',
                'strConfirmarSenha' => 'required|same:strSenha',
                'strDocumento' => ['required', new DocumentoValidation()],
            )
        );


        DB::beginTransaction();
 
        try {

            if ($this->where('strEmail', $arrayData['strEmail'])->first()) {
                throw new CustomException("Esse email já está cadastrado. Por favor digite outro.", 400, ['strEmail' => 'Esse email já está cadastrado. Por favor digite outro.']);
            }

            if ($this->where('strDocumento', Utilidade::onlyNumber($arrayData['strDocumento']))->first()) {
                throw new CustomException("Esse documento já está cadastrado. Por favor digite outro.", 400, ['strDocumento' => 'Esse documento já está cadastrado. Por favor digite outro.']);
            }

            $objUsuario = $this->firstOrNew(['intId' => $arrayData['intId']]);
            $objUsuario->intIdTipoUsuario = $arrayData['intIdTipoUsuario'];
            $objUsuario->strNome = $arrayData['strNome'];
            $objUsuario->strEmail = $arrayData['strEmail'];
            $objUsuario->strDocumento = $arrayData['strDocumento'];
            $objUsuario->strSenha = $arrayData['strSenha'];
            $objUsuario->floatSaldo = 0;
            $objUsuario->save();

            DB::commit();

            return $objUsuario;
        } catch (CustomException $th) {
            DB::rollBack();
            throw new CustomException($th->getMessage(), $th->getStatus(), $th->getOptions());
        } catch (\Exception $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }
}
