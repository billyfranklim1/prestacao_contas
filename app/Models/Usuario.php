<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Usuario extends Authenticatable
{
    protected $table = 'usuario';
    protected $primaryKey = "id";
    protected $guarded = [];

    public function hasEmpresa(){
        return $this->hasOne('\App\Models\Empresa', 'id', 'empresa_id');
    }

    public function hasFilial(){
        return $this->hasOne('\App\Models\Filial', 'id', 'filial_id');
    }

}
