<?php

namespace App\Models;

use App\Helpers\Utilidade;

class UsuarioExtrato extends BaseModel
{

    protected $table = 'usuario_extrato';
    protected $primaryKey = 'intId';
    protected $hidden = ['intIdUsuario', 'intIdUsuarioLancamento', 'intIdTipoLancamento'];
    protected $with = [];
    protected $guarded = [];

    public function objTipoLancamento()
    {
        return $this->belongsTo(Tipo::class, 'intIdTipoLancamento');
    }

    public function objUsuario()
    {
        return $this->belongsTo(Usuario::class, 'intIdUsuario');
    }

    public function objUsuarioLancamento()
    {
        return $this->belongsTo(Usuario::class, 'intIdUsuarioLancamento');
    }

    public function setFloatValorAttribute($value)
    {
        $this->attributes['floatValor'] = floatval($value);
    }

    public function setStrObservacaoAttribute($value)
    {
        $this->attributes['strObservacao'] = Utilidade::textLimit($value, 255);
    }
}
