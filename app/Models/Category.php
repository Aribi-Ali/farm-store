<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;


    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'parent_id',
        "isActive"
    ];

    // Automatically generate slug when name is set
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }



    // Define self-referencing relationship for subcategories
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }
    // Many-to-Many with Product
    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }
}
