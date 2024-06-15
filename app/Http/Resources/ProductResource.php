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
            'id' =>$this->id,
            'name' => $this->title,
            'slug' => $this->slug,
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity,
            'summary' => $this->summary,
            'description' => $this->description,
            'feature_image_url' => $this->feature_image_url,
        ];
    }
}
