<?php

namespace App\Http\Resources;

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
            'addressable_id' => $this->addressable_id,
            'ubication' => $this->ubication,
        ];
    }

    public function with($request)
    {
        return [
            'is_success' => true
        ];
    }
}
