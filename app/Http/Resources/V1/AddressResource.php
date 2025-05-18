<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'fullName' => $this->full_name,
            'postalCode' => $this->postal_code,
            'area' => $this->area,
            'city' => $this->city,
            'state' => $this->state,
            'userId' => $this->user_id
        ];
    }
}
