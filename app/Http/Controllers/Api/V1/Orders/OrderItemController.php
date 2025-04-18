<?php

namespace App\Http\Controllers\Api\V1\Orders;

use App\Http\Controllers\Controller;
use App\Http\Resources\Orders\OrderCollection;
use App\Models\Order;
use App\Models\OrderItem;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Order $order)
    {
        $items = $request->all();

        foreach ($items as $item) {
            $order->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price_at_time' => $item['price_at_time'],
            ]);
        }

        return ApiResponse::success(new OrderCollection($order->items), 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(OrderItem $orderItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderItem $orderItem)
    {
        //
    }
}
