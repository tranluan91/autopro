<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vps extends Model
{
    protected $table = 'vps';

    const MAX_SITE_VPS = 5;

    protected $fillable = [
        'ip',
        'username',
        'password',
        'port',
    ];

    public static $rule = [
        'ip' => 'required|ip|unique:vps',
        'username' => 'required',
        'password' => 'required',
        'port' => 'required',
    ];

    public static function rule($id)
    {
        return [
            'ip' => 'required|ip|unique:vps,ip,' . $id,
            'username' => 'required',
            'password' => 'required',
            'port' => 'required',
        ];
    }
}
