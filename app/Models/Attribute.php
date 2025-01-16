<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function options()
    {
        return $this->hasMany(AttributeOption::class);
    }
}
