<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreFeedbackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "storeId" => $this->storeId,
            "userId" => $this->userId,
            "rating" => $this->rating,
            "reviewText" => $this->reviewText
        ];
    }
}
