<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class PrestacaoConta extends Authenticatable
{
    protected $table = 'prestacao_conta';
    protected $primaryKey = "id";
    protected $guarded = [];

    public function hasUsuario(){
        return $this->hasOne('\App\Models\Usuario', 'id', 'usuario_id');
    }

    public function hasEmpresa(){
        return $this->hasOne('\App\Models\Empresa', 'id', 'empresa_id');
    }

    public function hasFilial(){
        return $this->hasOne('\App\Models\Filial', 'id', 'filial_id');
    }

}
