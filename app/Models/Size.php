<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Size extends Eloquent
{
    protected $connection = 'origin_data';

    protected $table = 'sizes';
}
