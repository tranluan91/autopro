<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SunAccount extends Model
{
    protected $table = 'sun_accounts';

    protected $fillable = [
        'sun_id',
        'username',
        'password',
    ];

    public static $rule = [
        'sun_id' => 'required|integer|unique:sun_accounts',
        'username' => 'required',
        'password' => 'required',
    ];

    public function websites()
    {
        return $this->hasMany(Website::class, 'sun_id', 'id');
    }
}
