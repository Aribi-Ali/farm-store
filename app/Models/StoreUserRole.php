<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreUserRole extends Model
{


    protected $fillable = [
        'user_id',
        'store_id',
        'role_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    // Define the relationship to permissions
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'store_user_permissions', 'store_user_role_id', 'permission_id');
    }
}
