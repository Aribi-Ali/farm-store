<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductService
{
  protected $storageService;

  public function __construct(StorageService $storageService)
  {
    $this->storageService = $storageService;
  }


  public function create(array $data, array $images = []): Product
  {

    return DB::transaction(function () use ($data, $images) {
      $data['is_active'] = $data['is_active'] ?? true;

      $product = Product::create([
        'SKU' => $data['SKU'],
        'name' => $data['name'],
        'description' => $data['description'],
        'price' => $data['price'],
        'newPrice' => $data['newPrice'],
        'stock' => $data['stock'],
        'category_id' => $data['category_id'],
        'is_active' => $data['is_active'],
        'store_id' => $data['store_id'],
        'created_by' => $data['created_by'] ?? null,
        'updated_by' => $data['updated_by'] ?? null,
      ]);
      // Handle image upload if present
      $this->handleImageUpload($product, $images);
      return $product;
    });
  }


  /** * Handle the image uploads and save their paths. * * @param \App\Models\Product $product * @param array $images */ protected function handleImageUpload($product, array $images)
  {
    if (!empty($images)) {
      $storedPaths = $this->storageService->storeImage("local_image_driver", "products", $images);
      foreach ($storedPaths as $path) {
        $product->images()->create(['url' => $path]);
      }
    }
  }

  public function update(Product $product, array $data, array $images)
  {

    $data['is_active'] = $data['is_active'] ?? true;
    $product->update([
      'SKU' => $data['SKU'],
      'name' => $data['name'],
      'description' => $data['description'],
      'price' => $data['price'],
      'newPrice' => $data['newPrice'],
      'stock' => $data['stock'],
      'category_id' => $data['category_id'],
      'is_active' => $data['is_active'],
      //  'store_id' => $data['store_id'],
      'created_by' => $data['created_by'] ?? null,
      'updated_by' => $data['updated_by'] ?? null,
    ]);
    $this->handleImageUpload($product, $images);
    return $product;
    // Handle image upload if present
    $this->handleImageUpload($product, $images);
  }
  public function delete(Product $product)
  {

    return DB::transaction(function () use ($product) {
      // Delete image if exists
      $product->load('images');
      if ($product->images) {
        $this->storageService->deleteImage("local_image_driver", "products", $product->images);
      }
      // Delete category
      return $product->delete();
    });
  }


  public function getPaginated(array $filters, int $per_page = 15)
  {

    $product = Product::query();
    if (!empty($filters["search"])) {
      $product->where("name", "like", "%" . $filters["search"] . "%")
        ->orWhere("name", "like", "%" . $filters["search"] . "%");
    }
    return   $product->with(["images", "categories"])->paginate($per_page);
  }
}