<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static $rule = [
        'password' => 'required',
        'new_password' => 'required|string|min:6|confirmed',
    ];

    const USER = 0;
    const ADMIN = 1;

    public function isAdmin()
    {
        return $this->role == USER::ADMIN;
    }
}
