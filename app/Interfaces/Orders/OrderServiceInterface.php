<?php

namespace App\Interfaces\Orders;

use App\Models\Order;
use App\Models\User;

interface OrderServiceInterface
{
    /**
     * @description Create new order
     * @param array $data
     * @return Order
     */
    public function createOrder(User $user, array $data): Order;
}
