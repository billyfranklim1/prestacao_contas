<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class PrestacaoContaDetalhe extends Authenticatable
{
    protected $table = 'prestacao_conta_detalhe';
    protected $primaryKey = "id";
    protected $guarded = [];

    public function hasPrestacaoConta(){
        return $this->hasOne('\App\Models\PrestacaoConta', 'id', 'prestacao_conta_id');
    }

    public function hasCategoria(){
        return $this->hasOne('\App\Models\Categoria', 'id', 'categoria_id');
    }


}
