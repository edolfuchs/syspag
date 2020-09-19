<?php

namespace App\Models;

use App\Helpers\Utilidade;

class UsuarioTransferencia extends BaseModel
{

    protected $table = 'usuario_transferencia';
    protected $primaryKey = 'intId';
    protected $hidden = ['intIdTipoStatusTransferencia', 'intIdTipoStatusNotificacao', 'intIdUsuarioPagador', 'intIdUsuarioBeneficiario'];
    protected $guarded = [];

    public function objTipoStatusTransferencia()
    {
        return $this->belongsTo(Tipo::class, 'intIdTipoStatusTransferencia');
    }

    public function objTipoStatusNotificacao()
    {
        return $this->belongsTo(Tipo::class, 'intIdTipoStatusNotificacao');
    }

    public function objUsuarioPagador()
    {
        return $this->belongsTo(Usuario::class, 'intIdUsuarioPagador');
    }

    public function objUsuarioBeneficiario()
    {
        return $this->belongsTo(Usuario::class, 'intIdUsuarioBeneficiario');
    }

    public function setFloatValorAttribute($value)
    {
        $this->attributes['floatValor'] = floatval($value);
    }

    public function setStrObservacaoAttribute($value)
    {
        $this->attributes['strObservacao'] = Utilidade::upperCase(Utilidade::textLimit($value, 1000));
    }
}
