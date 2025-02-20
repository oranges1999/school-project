<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'author' => new UserResource($this->users),
            'product_id' => $this->product_id,
            'content' => $this->content,
            'status' => $this->status->label(),
            'created_at' => $this->created_at,
            'product' => new ProductResource($this->whenLoaded('products')),
        ];
    }
}
