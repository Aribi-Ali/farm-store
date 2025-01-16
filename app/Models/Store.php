<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        "name",
        "slug",
        "email",
        "logo",
        "phone_number",
        "address",
        "description",
        "is_active",
        "is_featured",
        "opening_hours"
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'store_user_roles');
    }

    // Relationship to roles through store_user_roles
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'store_user_roles');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function shippings()
    {
        return $this->hasMany(Shipping::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}