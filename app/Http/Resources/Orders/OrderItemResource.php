<?php

namespace App\Http\Resources\Orders;

use App\Http\Resources\Products\ProductResource;
use App\Http\Resources\Users\UserAddressResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'order_item',
            'id' => (string) $this->id,
            'attributes' => [
                'quantity' => $this->quantity,
                'price_at_time' => $this->price_at_time
            ],
            'link' => [
                'self' => route('orders.show', $this->id),
            ],
            'relationships' => [
                'product' => $this->whenLoaded('product', function () {
                    return [
                        'type' => 'products',
                        'id' => (string) $this->product->id,
                        'attributes' => [
                            'name' => $this->product->name,
                            'image' => $this->product->image,
                            // Ajoute d'autres attributs si nécessaire
                        ],
                        'link' => [
                            'self' => route('products.show', ['product' => $this->product->id]),
                        ],
                    ];
                }),
            ],
        ];
    }
}
