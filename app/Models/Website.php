<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $table = 'websites';

    protected $fillable = [
        'domain',
        'vps_id',
        'status',
    ];

    public static $rule = [
        'domain' => 'required|unique:websites',
        'vps_id' => 'required|exists:vps,id',
    ];

    const WAIT_DEPLOY = 0;
    const DONE_DEPLOY = 1;
}
