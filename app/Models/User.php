<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use  HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'avatar', 'firstName', 'lastName', 'date_of_birth', 'password',
        'userName', 'phone_number', 'email', 'is_active', 'email_verified_at'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $with = [
        'storeUserRoles.store',
        'storeUserRoles.role.permissions',
        'stores',
        'roles',
        'permissions',
        "userDetail"
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }








    // Define the relationship to roles through the store_user_roles table
    public function storeUserRoles()
    {
        return $this->hasMany(StoreUserRole::class);
    }

    // Define the relationship to roles
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'store_user_roles')->withPivot('store_id');
    }

    // Define the relationship to permissions through store_user_permissions
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'store_user_permissions', 'store_user_role_id', 'permission_id');
    }

    // Include other necessary user relations
    public function stores()
    {
        return $this->belongsToMany(Store::class, 'store_user_roles');
    }


// badges relation
    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
            ->withPivot('earned_at')
            ->withTimestamps();
    }

    public function userDetail(){
        return $this->hasOne(User::class);
    }
}
