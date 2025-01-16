<?php

namespace App\Services;

use App\Exceptions\CustomNotFoundException;
use App\Models\Category;
use Faker\Test\Provider\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;

class CategoryService
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
  public function create(array $data, ?UploadedFile $image = null): Category
  {
    return DB::transaction(function () use ($data, $image) {
      // Handle image upload if present
      if ($image) {
        $data['image'] = $this->storageService->storeSingleImage("local_image_driver", null, "categories", $image);
      }
      if (empty($data["isActive"])) {
        $data["isActive"] = false;
      }

      // Create category
      return Category::create($data);
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
  public function update($categoryId, array $data, ?UploadedFile $image = null): Category
  {

    $category = Category::findOr($categoryId, function () use ($categoryId) {
      throw new CustomNotFoundException("Category with ID {$categoryId} was not found.", 404);
    });



    return DB::transaction(function () use ($category, $data, $image) {
      // Handle image upload if present

      if (empty($data["isActive"])) {
        $data["isActive"] = false;
      }
      if ($image) {
        $data['image'] = $this->storageService->storeSingleImage(
          "local_image_driver",
          null,
          'categories',
          $image,
        );
      }


      // Update category
      $category->update($data);

      return $category;
    });
  }

  /**
   * Delete a category
   *
   * @param Category $category
   * @return bool
   */
  public function delete($categoryId): bool
  {

    $category = Category::findOr($categoryId, function () use ($categoryId) {
      throw new CustomNotFoundException("Category with ID {$categoryId} was not found.", 404);
    });
    return DB::transaction(function () use ($category) {
      // Delete image if exists
      if ($category->image) {
        $this->storageService->deleteSingleImage("local_image_driver", null, "categories", $category->image);
      }

      // Delete category
      return $category->delete();
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
    $query = Category::query();

    // Apply filters
    if (!empty($filters['search'])) {
      $query->where('name', 'like', '%' . $filters['search'] . '%');
    }

    $query->where("parent_id", null);
    // if (!empty($filters['parent_id'])) {
    //   $query->where('parent_id', $filters['parent_id']);
    // }

    // Eager load parent relationship
    return $query->with('allChildren')->paginate($perPage);
  }


  public function getAllCategories(array $filters, int $perPage = self::DEFAULT_PER_PAGE)
  {
    // dd($filters);
    $query = Category::query();
    if (!empty($filters['search'])) {
      $query->where('name', 'like', '%' . $filters['search'] . '%')
        ->orWhere('description', 'like', '%' . $filters['search'] . '%');
    }


    return $query->paginate($perPage);
  }

  public function show($categoryId)
  {

    $category = Category::findOr($categoryId, function () use ($categoryId) {
      throw new CustomNotFoundException("Category with ID {$categoryId} was not found.", 404);
    });
    return     $category->load('parent', 'children');
  }
}
