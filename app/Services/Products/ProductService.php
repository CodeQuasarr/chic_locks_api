<?php

namespace App\Services\Products;

use App\Interfaces\Products\ProductServiceInterface;
use App\Models\Product;
use App\Repositories\Products\ProductRepository;
use App\Repositories\Users\UserRepository;
use App\Services\BaseService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class ProductService extends BaseService implements ProductServiceInterface
{

    public function __construct(
        private readonly ProductRepository $productRepository
    )
    {}


    /**
     * @inheritDoc
     */
    public function getProducts(): Product
    {
        return $this->productRepository->all();
    }

    /**
     * @inheritDoc
     */
    public function createProduct(array $data): Product
    {
        // TODO: Implement createProduct() method.
    }

    /**
     * @inheritDoc
     */
    public function showProductBySlug(string $slug): Product
    {
        // TODO: Implement showProductBySlug() method.
    }

    /**
     * @inheritDoc
     */
    public function showProductById(int $id): Product
    {
        // TODO: Implement showProductById() method.
    }

    /**
     * @inheritDoc
     */
    public function updateUser(array $data, Product $product): Product
    {
        // TODO: Implement updateUser() method.
    }
}
