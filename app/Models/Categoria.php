<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Categoria extends Authenticatable
{
    protected $table = 'categoria';
    protected $primaryKey = "id";
    protected $guarded = [];

}
