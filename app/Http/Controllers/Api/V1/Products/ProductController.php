<?php

namespace App\Http\Controllers\Api\V1\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Products\ProductCollection;
use App\Interfaces\Products\ProductServiceInterface;
use App\Models\Product;
use App\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct(
        private readonly ProductServiceInterface $productService
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json(new ProductCollection(Product::all()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkStock(Request $request): JsonResponse
    {
        $items = $request->input('items');
        $products = $this->productService->checkStock($items);

        return ApiResponse::success([
            "data" => [
                "type" => "products",
                "id" => null,
                "attributes" => [
                    "hasStock" => $products[0],
                    "insufficientStock" => $products[1],
                ],
                "links" => [
                    "self" => "/users/123"
                ]
            ],
            "meta" => [
                "message" => "Utilisateur créé. Veuillez confirmer votre email pour activer votre compte."
            ]
        ],  201);
    }
}
