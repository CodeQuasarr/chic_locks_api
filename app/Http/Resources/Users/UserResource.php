<?php

namespace App\Http\Resources\Users;

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
            'data' => [
                'type' => 'users',
                'id' => (string) $this->id,
                'attributes' => [
                    'name' => $this->name,
                    'email' => $this->email,
                    'role' => $this->getRoleNames(),
                    'created_at' => $this->created_at->toISOString(),
                    'updatedAt' => $this->updated_at->toISOString(),
                ],
                'link' => [
                    'self' => route('users.show', ['user' => $this->id]),
                ],
                'relationships' => [
                    'addresses' => UserAddressResource::collection($this->addresses)
                ]
            ],
        ];
    }
}
