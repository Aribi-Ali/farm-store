<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductReviewResource;
use App\Models\ProductReview;
use App\Services\ProductReviewService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductReviewController extends Controller
{
    public function __construct(public ProductReviewService $productReviewService) {}



    public function store(Request $request, $productId)
    {
        $productReview = $this->productReviewService->create($request->validated(), $productId);
        return Response::json(
            new ProductReviewResource($productReview),
            201
        );
    }
    public function show($productReviewId)
    {

        $productReview = $this->productReviewService->show($productReviewId);
        return Response::json(new ProductReviewResource($productReview));
    }
    public function update(Request $request, $productReviewId)
    {

        $updatedProductReview = $this->productReviewService->update($request->validated(), $productReviewId);
        return Response::json(new ProductReviewResource($updatedProductReview));
    }
    public function delete($productReviewId)
    {

        $this->productReviewService->delete($productReviewId);
        return Response::json(null, 204);
    }
}
