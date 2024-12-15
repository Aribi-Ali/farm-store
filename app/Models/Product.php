<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;


    protected $fillable = [
        'name',
        'description',
        'price',
        "stock",
        "category_id",
        "store_id",
        "created_by",
        "updated_by",
        "newPrice",
        "SKU",
        "is_active"
    ];
    // generate SKU if is null
    public function setSKUAttribute($value)
    {
        if ($value != null) {
            $this->attributes['SKU'] = Str::slug($value);
        }
    }

    // Many-to-Many with Category
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }


    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
