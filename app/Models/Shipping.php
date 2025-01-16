<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{


    // relations
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}