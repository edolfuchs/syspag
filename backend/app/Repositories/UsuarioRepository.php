<?php

namespace App\Repositories;

use App\Models\Usuario;
use App\Helpers\Utilidade;
use App\Traits\FilterTrait;
use App\Traits\ValidateTrait;
use App\Rules\DocumentoValidation;
use App\Exceptions\CustomException;
use App\Repositories\AuthRepository;
use App\Rules\NomeCompletoValidation;
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

    public function cadastrarUsuario(array $arrayData):int
    {   

        $arrayData = $this->validate(
            $arrayData,
            array(
                'intId' => 'required|numeric|min:0',
                'strNome' => ['required','max:100',new NomeCompletoValidation()],
                'intIdTipoUsuario' => 'required|numeric|min:2|max:3',
                'strEmail' => 'required|email|max:100',
                'strSenha' => 'required|min:6',
                'strConfirmarSenha' => 'required|same:strSenha',
                'strDocumento' => ['required', new DocumentoValidation()],
            )
        );

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
            $objUsuario->save();

            return $objUsuario->intId;
        } catch (CustomException $th) {
            throw new CustomException($th->getMessage(), $th->getStatus(), $th->getOptions());
        } catch (\Exception $th) {
            throw new \Exception($th->getMessage());
        }
    }
}
