<?php

namespace App\Http\Resources\Orders;

use App\Http\Resources\Products\ProductResource;
use App\Http\Resources\Users\UserAddressResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemsResource extends JsonResource
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
                'type' => 'order_items',
                'id' => (string) $this->id,
                'attributes' => [
                    'quantity' => $this->quantity,
                    'price_at_time' => $this->price_at_time,
                    'createdAt' => $this->created_at->toISOString(),
                ],
                'link' => [
                    'self' => "----------------------",
                ],
                'relationships' => [
                    'product' => ProductResource::collection($this->product)
                ]
            ],
        ];
    }
}
