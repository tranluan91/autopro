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
    ];

    public static $rule = [
        'domain' => 'required|unique:websites',
        'vps_id' => 'required|exists:vps,id',
    ];

    public static function ruleUpdate($id)
    {
        return [
            'domain' => 'required|unique:websites,domain,' . $id,
            'vps_id' => 'required|exists:vps,id',
        ];
    }

    const WAIT_DEPLOY = 0;
    const DONE_DEPLOY = 1;

    public function vps()
    {
        return $this->belongsTo(Vps::class);
    }
}
