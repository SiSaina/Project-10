<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
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
            'status' => $this->status,
            'date' => $this->date,
            'orderId' => OrderResource::Collection($this->whenLoaded('order')),
            'userId' => UserResource::Collection($this->whenLoaded('user')),
            'addressId' => AddressResource::Collection($this->whenLoaded('address'))
        ];
    }
}
