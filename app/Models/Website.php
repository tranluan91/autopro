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
        'protocol',
        'sun_id',
    ];

    public static $rule = [
        'domain' => 'required|unique:websites',
        'vps_id' => 'required|exists:vps,id',
        'sun_id' => 'required|exists:sun_accounts,id',
    ];

    const WAIT_DEPLOY = 0;
    const DONE_DEPLOY = 1;

    public function vps()
    {
        return $this->belongsTo(Vps::class);
    }

    public function sunAccount()
    {
        return $this->belongsTo(SunAccount::class, 'sun_id', 'id');
    }
}
