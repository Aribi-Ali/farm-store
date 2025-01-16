<?php

namespace App\Services;

use App\Exceptions\CustomNotFoundException;
use App\Models\Permission;
use App\Models\StoreUserPermission;
use App\Models\StoreUserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionService
{

  const DEFAULT_PER_PAGE = 15;

  public function getPaginated(array $filters = [], int|null $perPage = self::DEFAULT_PER_PAGE)
  {

    $query = Permission::query();

    // Apply filters
    if (!empty($filters['search'])) {
      $query->where('name', 'like', '%' . $filters['search'] . '%');
    }


    return $query->paginate($perPage);
  }

  public function create(array $data)
  {

    return DB::transaction(function () use ($data) {
      return Permission::create($data);
    });
  }

  public function show($permissionId)
  {

    $permission = Permission::findOr($permissionId, function () use ($permissionId) {

      throw new CustomNotFoundException("Permission with ID {$permissionId} was not found.", 404);
    });


    return $permission;
  }
  public function update($permissionId, array $data)
  {

    $permission = Permission::findOr($permissionId, function () use ($permissionId) {

      throw new CustomNotFoundException("Permission with ID {$permissionId} was not found.", 404);
    });

    return DB::transaction(function () use ($data, $permission) {

      return $permission->update($data);
    });

    // delete and save  the permission image
  }
  public function delete($permissionId)
  {


    $permission = Permission::findOr($permissionId, function () use ($permissionId) {

      throw new CustomNotFoundException("Permission with ID {$permissionId} was not found.", 404);
    });



    // add delete image later
    return $permission->delete();
  }


  // other functions
  public function assignPermission(array $data,  $storeUserRoleId)
  {


    $storeUserRole = StoreUserRole::findOr($storeUserRoleId, function () use ($storeUserRoleId) {

      throw new CustomNotFoundException("Store User Role with ID {$storeUserRoleId} was not found.", 404);
    });



    $permission = StoreUserPermission::updateOrCreate(
      [
        'store_user_role_id' => $storeUserRole->id,
        'permission_id' => $data['permission_id'],
      ]
    );

    return $permission;
  }
}
