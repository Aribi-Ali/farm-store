<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    // Relationship to users
    public function users()
    {
        return $this->belongsToMany(User::class, 'store_user_roles')->withPivot('store_id');
    }
}