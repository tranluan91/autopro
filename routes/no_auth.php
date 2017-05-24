<?php

Route::get('/web', function () {
    $website = \App\Models\Website::inRandomOrder()->first();
    if ($website) {
        return $website->domain;
    }

    return '#';
});