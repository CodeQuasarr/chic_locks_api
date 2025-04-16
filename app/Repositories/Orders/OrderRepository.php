<?php

namespace App\Repositories\Orders;

use App\Models\Order;

class OrderRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(private readonly Order $order)
    {}

    public function getInstanceOforder(): Order
    {
        return $this->order;
    }


    /**
     * Create a new order.
     */
    public function create(array $data): ?Order
    {
        return $this->order->create($data);
    }

    /**
     * Find order by ID.
     */
    public function findById(int $id): ?Order
    {
        return $this->order->find($id);
    }

    /**
     * Update a order.
     */
    public function update(array $data, Order $order): bool
    {
        return $order->update($data);
    }
}
