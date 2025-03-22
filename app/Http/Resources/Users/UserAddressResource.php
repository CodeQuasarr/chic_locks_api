<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'addresses',
            'id' => (string) $this->getKey(),
            'attributes' => [
                'street' => $this->street,
                'city' => $this->city,
                'post_code' => $this->post_code,
                'country' => $this->country,
                'is_default' => $this->is_default,
                'created_at' => $this->created_at->toISOString(),
                'updated_at' => $this->updated_at->toISOString()
            ],
            'link' => [
                'self' => 'users/' . $this->getKey()
            ]
        ];
    }
}
