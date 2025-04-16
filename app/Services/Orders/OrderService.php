<?php

namespace App\Services\Orders;

use App\Models\Order;
use App\Models\User;
use App\Repositories\Orders\OrderRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class OrderService extends BaseService implements \App\Interfaces\Orders\OrderServiceInterface
{

    public function __construct(
        private readonly OrderRepository $orderRepository
    )
    {}


    public function createOrder(User $user, array $data): Order
    {
        $fields = $this->getModelFields($this->orderRepository->getInstanceOfOrder(), collect($data));

        DB::beginTransaction();
        $order = $user->orders()->create($fields->toArray());

        if (!$order) {
            DB::rollBack();
            throw new RuntimeException('Un problème est survenu lors de la création de la commande', 500);
        }
        DB::commit();
        return $order;
    }
}
