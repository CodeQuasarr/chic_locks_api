<?php

namespace App\Http\Resources\Products;

use App\Http\Resources\Users\UserAddressResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [ 'data' => $this->transformDataOnly($request),];
    }

    public function transformDataOnly(Request $request): array
    {
        return [
            'type' => 'products',
            'id' => (string) $this->id,
            'attributes' => [
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'slug' => $this->slug,
                'stock' => $this->stock,
                'created_at' => $this->created_at->toISOString(),
            ],
            'link' => [
                'self' => route('products.show', ['product' => $this->id]),
            ],
        ];
    }
}
