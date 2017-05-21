<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vps extends Model
{
    protected $table = 'vps';

    protected $fillable = [
        'ip',
        'username',
        'password',
        'port',
    ];

    public static $rule = [
        'ip' => 'required|unique:vps',
        'username' => 'required',
        'password' => 'required',
        'port' => 'required',
    ];
}
