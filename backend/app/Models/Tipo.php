<?php

namespace App\Models;

class Tipo extends BaseModel
{
    protected $table = 'tipo';
    protected $primaryKey = 'intId';
    protected $hidden = ['intIdTipo'];
    public $timestamps = false;

}
