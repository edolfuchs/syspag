<?php

namespace App\Traits;

use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Validator;

trait ValidateTrait
{
    public function validate($data, $content)
    {

        $validator = Validator::make(
            $data,
            $content
        );

        if ($validator->fails()) {
            throw new CustomException("Erro ao validar os dados do formulário. Verifique e tente novamente.", 400, $validator->messages());
        }

        return $data;
    }
}
