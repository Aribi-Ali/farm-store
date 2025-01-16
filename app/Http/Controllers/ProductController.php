<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ProductService $productService;
    public  function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
 
        // return $request->query("per_page");
        $products = $this->productService->getPaginated($request->all(), $request->query("per_page"));
        return Response::json([
            'data' => ProductResource::collection($products),
            'meta' => [
                'total' => $products->total(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
            ]
        ]);
    }


    public function store(ProductStoreRequest $request, Product $product)
    {
        $product = $this->productService->create(
            $request->validated(),
            $request->file('images', [])
        );
        return Response::json(
            new ProductResource($product),
            201
        );
    }




    public function show($productId): JsonResponse
    {

        $product = $this->productService->show($productId);

        return Response::json(new ProductResource($product));
    }

    public function update(ProductUpdateRequest $request, $productId)
    {

        $updatedProduct = $this->productService->update($productId, $request->all(), $request->file("images", []));
        return Response::json(new ProductResource($updatedProduct));
    }

    public function delete($productId)
    {
        $this->productService->delete($productId);
        return Response::json(null, 204);
    }
}
