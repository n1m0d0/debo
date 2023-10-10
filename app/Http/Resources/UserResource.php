<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'phones' => PhoneResource::collection($this->whenLoaded('phones')),
            'orders' => OrderResource::collection($this->whenLoaded('orders')),
        ];
    }

    public function with($request)
    {
        return [
            'is_success' => true
        ];
    }
}
