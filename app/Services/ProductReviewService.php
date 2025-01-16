<?php

namespace App\Services;

use App\Exceptions\CustomNotFoundException;
use App\Models\ProductReview;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ProductReviewService
{




  public function create(array $data, $productId)
  {
    $userId = Auth::user()->id; // Authenticated user
    $existingReview = ProductReview::where('product_id', $productId)->where('user_id', $userId)->first();

    if ($existingReview) {
      return response()->json(['message' => 'You have already reviewed this product.'], 403);
    }
    $data["userId"] = $userId;
    return DB::transaction(function () use ($data) {
      return ProductReview::create($data);
    });
  }
  public function show($productReviewId)
  {

    $productReview = ProductReview::findOr($productReviewId, function () use ($productReviewId) {

      throw new CustomNotFoundException("Product Review with ID {$productReviewId} was not found.", 404);
    });


    return $productReview;
  }
  public function update($productReviewId, array $data)
  {

    $productReview = ProductReview::findOr($productReviewId, function () use ($productReviewId) {

      throw new CustomNotFoundException("Product Review with ID {$productReviewId} was not found.", 404);
    });

    return DB::transaction(function () use ($data, $productReview) {
      return $productReview->update($data);
    });
  }
  public function delete($productReviewId)
  {


    $productReview = ProductReview::findOr($productReviewId, function () use ($productReviewId) {

      throw new CustomNotFoundException("Product Review with ID {$productReviewId} was not found.", 404);
    });

    return $productReview->delete();
  }
}
