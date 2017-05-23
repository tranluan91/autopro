<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Item extends Eloquent
{
    protected $connection = 'origin_data';

    protected $table = 'items';

    public function details()
    {
        return $this->hasMany(Detail::class, 'itemId', 'id');
    }
}
