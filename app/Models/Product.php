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
        "isActive"
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


    // public function images()
    // {
    //     return $this->morphMany(Image::class, 'imageable');
    // }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attributes')->withPivot('attribute_option_id')->withTimestamps();
    }

    // add all scopes
    public function scopeActive($query)
    {
        return $query->where('isActive', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
    public function scopeFeatured($query)
    {
        return $query->where('isFeatured', true);
    }
    public function scopeNotFeatured($query)
    {
        return $query->where('isFeatured', false);
    }
    public
    function scopeHasCustomShipping($query)
    {
        return $query->where('hasCustomShipping', true);
    }
    public
    function scopeFreeShipping($query)
    {
        return $query->where('freeShipping', true);
    }
    public function scopePriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }
    public
    function scopeNewPriceRange($query, $min, $max)
    {
        return $query->whereBetween('newPrice', [$min, $max]);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, "product_tags");
    }
}