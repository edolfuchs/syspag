<?php

namespace App\Rules;

use App\Helpers\Utilidade;
use Illuminate\Contracts\Validation\Rule;

class DocumentoValidation implements Rule
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
        return(Utilidade::isCpf($value) || Utilidade::isCnpj($value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Por favor informe um CPF/CNPJ válido.';
    }
}
