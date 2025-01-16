<?php

namespace App\Services;

use App\Exceptions\CustomNotFoundException;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class ProductService
{
  /**
   * The default number of items per page
   * @var int
   *
   * @const int
   * @default 15
   * @access private
   * @static
   */

  private const DEFAULT_PER_PAGE = 15;
  private const DEFAULT_IS_ACTIVE = true;

  public function __construct(public StorageService $storageService) {}

  /**
   * Create a new product with associated images
   *
   * @param array $data
   * @param array $images
   * @return Product
   */
  public function create(array $data, array $images = []): Product
  {
    return DB::transaction(function () use ($data, $images) {
      $product = Product::create($this->prepareProductData($data));

      $this->syncTags($product, $data);
      $this->handleImageUpload($product, $images);

      return $product->load('images', 'tags');
    });
  }

  /**
   * Update an existing product
   *
   * @param int $productId
   * @param array $data
   * @param array $images
   * @return Product
   * @throws CustomNotFoundException
   */
  public function update(int $productId, array $data, array $images = []): Product
  {
    $product = $this->findProductOrFail($productId);

    return DB::transaction(function () use ($product, $data, $images) {
      $product->update($this->prepareProductData($data));
      $this->syncTags($product, $data);
      $this->handleImageUpload($product, $images);


      return $product->load('images', 'tags');
    });
  }

  /**
   * Delete a product and its associated images
   *
   * @param int $productId
   * @return bool
   * @throws CustomNotFoundException
   */
  public function delete(int $productId): bool
  {
    $product = $this->findProductOrFail($productId);

    return DB::transaction(function () use ($product) {
      $product->load('images');

      $this->deleteProductImages($product);
      return $product->delete();
    });
  }

  /**
   * Get paginated products with optional filters
   *
   * @param array $filters
   * @param int|null $perPage
   * @return LengthAwarePaginator
   */
  public function getPaginated(array $filters, ?int $perPage = self::DEFAULT_PER_PAGE): LengthAwarePaginator
  {
    $query = Product::query()
      ->with(['images', 'categories', 'tags']);

    $this->applyFilters($query, $filters);

    return $query->paginate($perPage);
  }

  /**
   * Get a single product by ID
   *
   * @param int $productId
   * @return Product
   * @throws CustomNotFoundException
   */
  public function show(int $productId): Product
  {
    return $this->findProductOrFail($productId)
      ->load(['images', 'categories', 'tags']);
  }



  // uncontroller function

  /**
   * Delete a product image
   *
   * @param int $productId
   * @param int $imageId
   * @return bool
   * @throws CustomNotFoundException
   */
  public function deleteProductImage(int $productId, int $imageId): bool
  {
    $product = $this->findProductOrFail($productId);
    $image = $product->images()->findOr($imageId, function () use ($imageId) {
      throw new CustomNotFoundException("Image with ID {$imageId} was not found.", 404);
    });

    return DB::transaction(function () use ($image) {
      $this->storageService->deleteImage('local_image_driver', 'products', $image->url);
      return $image->delete();
    });
  }


  /**
   * Get paginated product reviews
   *
   * @param array $filters
   * @param int|null $perPage
   * @return LengthAwarePaginator
   */
  public function getProductReviewsPaginated(array $filters = [], ?int $perPage = self::DEFAULT_PER_PAGE): LengthAwarePaginator
  {
    $query = ProductReview::query();

    // Add filter logic here if needed

    return $query->paginate($perPage);
  }

  // add function to reverse the status of product
  public function reverseStatus(int $productId): Product
  {
    $product = $this->findProductOrFail($productId);

    return DB::transaction(function () use ($product) {
      $product->update([
        'isActive' => !$product->isActive
      ]);

      return $product;
    });
  }

  /**
   * Prepare product data for creation/update
   *
   * @param array $data
   * @return array
   */
  private function prepareProductData(array $data, bool $isUpdate = false): array
  {
    $userId = Auth::guard('api')->id();

    $productData = [
      'SKU' => $data['SKU'],
      'name' => $data['name'],
      'description' => $data['description'],
      'price' => $data['price'],
      'stock' => $data['stock'],
      'category_id' => $data['category_id'],
      'store_id' => $data['store_id'],
      'isActive' => $data['isActive'] ?? self::DEFAULT_IS_ACTIVE,
      'created_by' => !$isUpdate ? $userId : null,
      'updated_by' => $isUpdate ? $userId : null,
      'priority' => $data['priority'] ?? null,
      'hasCustomShipping' => $data['hasCustomShipping'] ?? false,
      'homeCustomShipping_cost' => $data['homeCustomShipping_cost'] ?? null,
      'stopDeskCustomShipping_cost' => $data['stopDeskCustomShipping_cost'] ?? null,
      'freeShipping' => $data['freeShipping'] ?? false,
      'metadata' => $data['metadata'] ?? null,
      'specialPrice' => $data['specialPrice'] ?? null,
      'specialPriceStartDate' => $data['specialPriceStartDate'] ?? null,
      'specialPriceEndDate' => $data['specialPriceEndDate'] ?? null,
      'brand_id' => $data['brand_id'] ?? null,
    ];
    if (!$isUpdate) {
      $productData['created_by'] = $userId;
    }
    return $productData;
  }



  /**
   * Apply filters to the product query
   *
   * @param Builder $query
   * @param array $filters
   * @return void
   */
  private function applyFilters(Builder $query, array $filters): void
  {
    if (!empty($filters['search'])) {
      $query->where(function ($q) use ($filters) {
        $q->where('name', 'like', "%{$filters['search']}%")
          ->orWhere('description', 'like', "%{$filters['search']}%")
          ->orWhere('SKU', 'like', "%{$filters['search']}%");
      });
    }

    // Add more filter conditions as needed
  }

  /**
   * Find a product by ID or throw an exception
   *
   * @param int $productId
   * @return Product
   * @throws CustomNotFoundException
   */
  private function findProductOrFail(int $productId): Product
  {
    return Product::findOr($productId, function () use ($productId) {
      throw new CustomNotFoundException("Product with ID {$productId} was not found.", 404);
    });
  }

  /**
   * Handle image upload for a product
   *
   * @param Product $product
   * @param array $images
   * @return void
   */
  private function handleImageUpload(Product $product, array $images): void
  {
    if (empty($images)) {
      return;
    }
    $storedPaths = $this->storageService->storeImage('local_image_driver', 'products', $images);
    foreach ($storedPaths as $path) {
      $product->images()->create(['url' => $path]);
    }
    if (count($storedPaths) > 1) {
      $product->update(['thumbnailImage' => $storedPaths[0], 'secondaryImage' => $storedPaths[1]]);
    }
  }




  private function syncTags(Product $product, array $data): void
  {
    if (isset($data['tags'])) {
      $product->tags()->sync($data['tags']);
    }
  }


  private function deleteProductImages(Product $product): void
  {
    if ($product->images->isNotEmpty()) {
      foreach ($product->images as $image) {
        $this->storageService->deleteImage('local_image_driver', 'products', $image->url);
      }
    }
  }
}