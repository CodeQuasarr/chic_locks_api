<?php

namespace App\Repositories\Products;

use App\Models\Product;

class ProductRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(private readonly Product $product)
    {}

    public function getInstanceOfProduct(): Product
    {
        return $this->product;
    }

    /**
     * Find a user by email.
     */
    public function findBySlug(string $slug): ?Product
    {
        return $this->product->fieldValue('slug', $slug)->first();
    }

    /**
     * Create a new user.
     */
    public function create(array $data): ?Product
    {
        return $this->product->create($data);
    }

    /**
     * Find a user by ID.
     */
    public function findById(int $id): ?Product
    {
        return $this->product->find($id);
    }

    /**
     * Update a user.
     */
    public function update(array $data, Product $product): bool
    {
        return $product->update($data);
    }
}
