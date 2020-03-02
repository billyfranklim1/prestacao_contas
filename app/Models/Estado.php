<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Estado extends Authenticatable
{
    protected $table = 'estados';
    protected $primaryKey = "codigo_uf";
    protected $guarded = [];

}
