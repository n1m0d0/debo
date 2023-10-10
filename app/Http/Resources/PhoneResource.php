<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhoneResource extends JsonResource
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
            'phoneable_id' => $this->phoneable_id,
            'number' => $this->number,
        ];
    }

    public function with($request)
    {
        return [
            'is_success' => true
        ];
    }
}
