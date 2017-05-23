<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Color extends Eloquent
{
    protected $connection = 'origin_data';

    protected $table = 'colors';
}
