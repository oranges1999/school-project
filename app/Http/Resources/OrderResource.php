<?php

namespace App\Http\Resources;

use App\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'status' => $this->status->label(),
            'admin_id' => $this->admin_id,
            'user' => $this->whenLoaded('users'),
            'products' => $this->whenLoaded('products')
        ];
    }
}
