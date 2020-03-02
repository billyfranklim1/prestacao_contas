<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Empresa extends Authenticatable
{
    protected $table = 'empresa';
    protected $primaryKey = "id";
    protected $guarded = [];

    public function hasEstado(){
        return $this->hasOne('\App\Models\Estado', 'codigo_uf', 'estado_id');
    }

    public function hasCidade(){
        return $this->hasOne('\App\Models\Cidade', 'codigo_ibge', 'cidade_id');
    }


}
