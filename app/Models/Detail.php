<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Detail extends Eloquent
{
    protected $connection = 'origin_data';

    protected $table = 'details';

    public function item()
    {
        return $this->belongsTo(Item::class, 'itemId', 'id');
    }

    public function color()
    {
        return $this->hasOne(Color::class, 'id', 'colorId');
    }

    public function style()
    {
        return $this->hasOne(Style::class, 'id', 'styleId');
    }
}
