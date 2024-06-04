<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       // return parent::toArray($request);

        return [
            'id' =>$this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'feature_image_url' => $this->feature_image_url,
            'category' => new CategoryResource($this->category), // Assuming CategoryResource exists
            // Include comments
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
        ];
    }
}
