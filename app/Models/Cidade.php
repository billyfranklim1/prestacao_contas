<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Cidade extends Authenticatable
{
    protected $table = 'cidades';
    protected $primaryKey = "codigo_ibge";
    protected $guarded = [];

}
