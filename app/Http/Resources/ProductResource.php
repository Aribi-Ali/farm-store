<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'SKU' => $this->SKU,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'newPrice' => $this->newPrice,
            'stock' => $this->stock,
            'category_id' => $this->category_id,
            'is_active' => $this->is_active,
            'store_id' => $this->store_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'images' => ImageResource::collection($this->whenLoaded('images'), "products"),
        ];
    }
}