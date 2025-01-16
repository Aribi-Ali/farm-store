<?php

namespace App\Services;

use App\Exceptions\CustomNotFoundException;
use App\Models\StoreFeedback;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StoreFeedbackService
{



  public function create(array $data, $productId)
  {
    $userId = Auth::user()->id; // Authenticated user
    $existingReview = StoreFeedback::where('product_id', $productId)->where('user_id', $userId)->first();

    if ($existingReview) {
      return response()->json(['message' => 'You have already gave a Feedback to this store.'], 403);
    }
    $data["userId"] = $userId;
    return DB::transaction(function () use ($data) {
      return StoreFeedback::create($data);
    });
  }
  public function show($storeFeedbackId)
  {

    $storeFeedback = StoreFeedback::findOr($storeFeedbackId, function () use ($storeFeedbackId) {

      throw new CustomNotFoundException("Store Feedback with ID {$storeFeedbackId} was not found.", 404);
    });


    return $storeFeedback;
  }
  public function update($storeFeedbackId, array $data)
  {

    $storeFeedback = StoreFeedback::findOr($storeFeedbackId, function () use ($storeFeedbackId) {

      throw new CustomNotFoundException("Store Feedback with ID {$storeFeedbackId} was not found.", 404);
    });

    return DB::transaction(function () use ($data, $storeFeedback) {
      return $storeFeedback->update($data);
    });
  }
  public function delete($storeFeedbackId)
  {


    $storeFeedback = StoreFeedback::findOr($storeFeedbackId, function () use ($storeFeedbackId) {

      throw new CustomNotFoundException("Store Feedback with ID {$storeFeedbackId} was not found.", 404);
    });

    return $storeFeedback->delete();
  }
}
