<?php

namespace App\Services;

use App\Exceptions\CustomNotFoundException;
use App\Models\Role;
use App\Models\Store;
use App\Models\StoreUserRole;
use Illuminate\Support\Facades\DB;

class RoleService
{

  const DEFAULT_PER_PAGE = 15;

  public function getPaginated(array $filters = [], int|null $perPage = self::DEFAULT_PER_PAGE)
  {

    $query = Role::query();

    // Apply filters
    if (!empty($filters['search'])) {
      $query->where('name', 'like', '%' . $filters['search'] . '%');
    }


    return $query->paginate($perPage);
  }

  public function create(array $data)
  {

    return DB::transaction(function () use ($data) {
      return Role::create($data);
    });
  }
  public function show($roleId)
  {

    $role = Role::findOr($roleId, function () use ($roleId) {

      throw new CustomNotFoundException("Role with ID {$roleId} was not found.", 404);
    });


    return $role;
  }
  public function update($roleId, array $data)
  {

    $role = Role::findOr($roleId, function () use ($roleId) {

      throw new CustomNotFoundException("Role with ID {$roleId} was not found.", 404);
    });

    return DB::transaction(function () use ($data, $role) {

      return $role->update($data);
    });

    // delete and save  the role image
  }
  public function delete($roleId)
  {


    $role = Role::findOr($roleId, function () use ($roleId) {

      throw new CustomNotFoundException("Role with ID {$roleId} was not found.", 404);
    });



    // add delete image later
    return $role->delete();
  }



  // other function
  public function assignRole(array $data, $storeId)
  {

    $store = Store::findOr($storeId, function () use ($storeId) {

      throw new CustomNotFoundException("Store with ID {$storeId} was not found.", 404);
    });


    $storeUserRole = StoreUserRole::updateOrCreate(
      [
        'user_id' => $data['user_id'],
        'store_id' => $store->id,
      ],
      ['role_id' => $data['role_id']]
    );

    return $storeUserRole;
  }
}
