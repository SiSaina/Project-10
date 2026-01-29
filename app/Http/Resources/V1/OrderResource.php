<?php

namespace App\Http\Resources\V1;

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
            'productId' => $this->product_id,
            'quantity' => $this->quantity,
            'orderDetails' => OrderDetailResource::collection($this->whenLoaded('orderDetails')),
            'product' => new ProductResource($this->whenLoaded('product'))
        ];
    }
}
