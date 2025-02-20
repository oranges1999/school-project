<?php

namespace App\Http\Resources;

use App\Status;
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
            'name'=>$this->name,
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'category' => $this->categories->name,
            'image' => asset('storage/'.$this->image),
            'stock' => $this->stock,
            'status' => $this->status->label(),
            'created_at'=> $this->created_at,
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
        ];
    }
}
