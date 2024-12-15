<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }

    // Relationship to users via store_user_permissions
    public function users()
    {
        return $this->belongsToMany(User::class, 'store_user_permissions', 'permission_id', 'store_user_role_id');
    }
}
