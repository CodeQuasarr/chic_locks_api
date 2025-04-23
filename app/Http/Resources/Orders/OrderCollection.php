<?php

namespace App\Http\Resources\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'data' => $this->collection->map(function ($order) use ($request) {
                return (new OrderResource($order))->transformDataOnly($request);
            }),
            'links' => [
                'self' => url()->current(),
            ],
        ];
    }
}
