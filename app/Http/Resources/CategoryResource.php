<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->image ? Storage::url("images/categories/" . $this->image) : null,
            'parent_id' => $this->parent_id,
            // 'parent' => $this->whenLoaded('allChildren', function () {
            //     return [
            //         'id' => $this->parent->id,
            //         'name' => $this->parent->name
            //     ];
            // }),
            'children' => CategoryResource::collection($this->whenLoaded('allChildren')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            "isActive" => $this->isActive ?? false,
        ];
    }
}