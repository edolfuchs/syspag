<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NomeCompletoValidation implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $arrayNome = explode(' ',$value);

        if(count($arrayNome) != 2){
            return false;
        }else if(strlen($arrayNome[0]) < 2 || strlen($arrayNome[1])<2){
            return false;
        }else{
            return true;
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Por favor informe corretamente seu nome e sobrenome';
    }
}
