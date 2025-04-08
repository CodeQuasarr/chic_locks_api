<?php

namespace App\Interfaces\Products;

use App\Models\Product;
use App\Models\User;

interface ProductServiceInterface
{


    /**
     * @description Get products
     *
     * @return Product
     */
    public function getProducts(): Product;

    /**
     * @description Create a new product
     * @param array $data
     * @return Product
     */
    public function createProduct(array $data): Product;

    /**
     * @description get product by slug
     * @param string $slug
     * @return Product
     */
    public function showProductBySlug(string $slug): Product;

    /**
     * @description get product by id
     * @param int $id
     * @return Product
     */
    public function showProductById(int $id): Product;

    /**
     * @description update product
     * @param array $data
     * @param Product $product
     * @return Product
     */
    public function updateUser(array $data, Product $product): Product;
}
