<?php

namespace App\Models;

use App\Helpers\Utilidade;
use Illuminate\Support\Facades\Hash;

class Usuario extends BaseModel
{

    protected $table = 'usuario';
    protected $primaryKey = 'intId';
    protected $hidden = ['strSenha', 'intIdTipoUsuario'];
    protected $with = ['objTipoUsuario'];

    public function objTipoUsuario()
    {
        return $this->belongsTo(Tipo::class, 'intIdTipoUsuario');
    }

    public function setStrSenhaAttribute($value)
    {
        $this->attributes['strSenha'] = Hash::make($value);
    }

    public function setStrEmailAttribute($value)
    {
        $this->attributes['strEmail'] = Utilidade::lowerCase($value);
    }

    public function setStrNomeAttribute($value)
    {
        $this->attributes['strNome'] = Utilidade::upperCase($value);
    }

    public function setStrDocumentoAttribute($value)
    {
        $this->attributes['strDocumento'] = Utilidade::onlyNumber($value);
    }

    public function setFloatSaldoAttribute($value)
    {
        $this->attributes['floatSaldo'] = floatval($value);
    }
}
