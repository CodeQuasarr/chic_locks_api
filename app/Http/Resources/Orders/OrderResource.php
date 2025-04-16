<?php

namespace App\Http\Resources\Orders;

use App\Http\Resources\Users\UserAddressResource;
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
            'data' => [
                'type' => 'orders',
                'id' => (string) $this->id,
                'attributes' => [
                    'status' => $this->status,
                    'payment_intent_id' => $this->payment_intent_id,
                    'amount' => $this->amount,
                    'payment_status' => $this->payment_status,
                    'payment_address' => $this->payment_address,
                    'payment_method' => $this->payment_method,
                    'createdAt' => $this->created_at->toISOString(),
                    'updatedAt' => $this->updated_at->toISOString(),
                ],
                'link' => [
                    'self' => "----------------------",
                ],
            ],
        ];
    }
}
