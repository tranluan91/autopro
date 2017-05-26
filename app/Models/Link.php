<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Link extends Eloquent
{
    protected $fillable = ['website_id', 'product_images', 'product_url', 'product_name', 'product_desc', 'check_pin'];

    protected $table = 'links';
}
