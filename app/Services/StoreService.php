<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Exceptions\CustomNotFoundException;
use App\Models\Category;
use App\Models\Store;
use Faker\Test\Provider\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StoreService
{
  const DEFAULT_PER_PAGE = 15;

  protected $storageService;

  public function __construct(StorageService $storageService)
  {
    $this->storageService = $storageService;
  }

  /**
   * Create a new category
   *
   * @param array $data
   * @param UploadedFile|null $image
   * @return Category
   */
  public function create(array $data, ?UploadedFile $logo = null): Store
  {
    return DB::transaction(function () use ($data, $logo) {
      // Handle image upload if present
      if ($logo) {
        $data['logo'] = $this->storageService->storeSingleImage("local_image_driver", null, "stores/logos", $logo);
      }
      if (empty($data["is_active"])) {
        $data["is_active"] = false;
      }

      // Create category
      return Store::create($data);
    });
  }

  /**
   * Update an existing category
   *
   * @param Category $category
   * @param array $data
   * @param UploadedFile|null $image
   * @return Category
   */
  public function update($storeId, array $data, ?UploadedFile $logo = null): Store
  {

    $store = Store::findOr($storeId, function () use ($storeId) {
      throw new CustomNotFoundException("Store with ID {$storeId} was not found.", 404);
    });


    return DB::transaction(function () use ($store, $data, $logo) {
      // Handle image upload if present

      if (empty($data["is_active"])) {
        $data["is_active"] = false;
      }
      if ($logo) {
        $data['logo'] = $this->storageService->storeSingleImage(
          "local_image_driver",
          null,
          'stores/logos',
          $logo,
        );
      }


      // Update category
      $store->update($data);

      return $store;
    });
  }

  /**
   * Delete a category
   *
   * @param Category $category
   * @return bool
   */
  public function delete($storeId): bool
  {

    $store = Store::findOr($storeId, function () use ($storeId) {
      throw new CustomNotFoundException("Store with ID {$storeId} was not found.", 404);
    });
    return DB::transaction(function () use ($store) {

      // Delete store
      return $store->delete();
    });
  }

  /**
   * Get paginated categories with optional filtering
   *
   * @param array $filters
   * @param int $perPage
   * @return \Illuminate\Pagination\LengthAwarePaginator
   */
  public function getPaginated(array $filters = [], int|null $perPage = self::DEFAULT_PER_PAGE)
  {
    $query = Store::query();

    // Apply filters
    if (!empty($filters['search'])) {
      $query->where('name', 'like', '%' . $filters['search'] . '%')
        ->orWhere('descriptions', 'like', '%' . $filters['search'] . '%');
    }

    // Eager load parent relationship
    return $query->paginate($perPage);
  }





  public function getStoreById($storeId)
  {
    return Store::findOr($storeId, function () use ($storeId) {
      throw new CustomNotFoundException("Store with ID {$storeId} was not found.", 404);
    });
  }


  public function getStoreBySlug(String $storeSlug)
  {
    return  Store::where("slug", $storeSlug)->firstOr(function () use ($storeSlug) {

      throw new CustomNotFoundException("Store with slug '{$storeSlug}' was not found.", 404);
    });
  }
}
