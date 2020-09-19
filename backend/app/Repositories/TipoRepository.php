<?php

namespace App\Repositories;

use App\Models\Tipo;
use App\Traits\FilterTrait;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\TipoRepositoryIntercace;
use App\Traits\ValidateTrait;

class TipoRepository extends Tipo implements TipoRepositoryIntercace
{
    use FilterTrait, ValidateTrait;

    public function listar(int $intId = null)
    {

        if ($intId) {
            return $this->find($intId);
        }

        return $this
            ->orderBy($this->getOrderBy(), $this->getOrderType())
            ->paginate($this->getTotalPage());
    }

    public function cadastrarTipo(array $arrayData)
    {
        $arrayData = $this->validate(
            $arrayData,
            array(
                'intId' => 'required|numeric|min:0',
                'strNome' => 'required|max:255',
                'intOrdem' => 'required|numeric|min:0',
            )
        );

        DB::beginTransaction();

        try {
            $objTipo = $this->firstOrNew(['intId' => $arrayData['intId']]);
            $objTipo->intIdTipo = (isset($arrayData['intIdTipo']) ? $arrayData['intIdTipo'] : null);
            $objTipo->strNome = $arrayData['strNome'];
            $objTipo->intOrdem = $arrayData['intOrdem'];
            $objTipo->save();

            DB::commit();

            return $objTipo;
        } catch (CustomException $th) {
            DB::rollBack();
            throw new CustomException($th->getMessage(), $th->getStatus(), $th->getOptions());
        } catch (\Exception $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }
}
