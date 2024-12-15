<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ["name", "slug"];
    public function users()
    {
        return $this->belongsToMany(User::class, 'store_user_roles');
    }

    // Relationship to roles through store_user_roles
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'store_user_roles');
    }
}
