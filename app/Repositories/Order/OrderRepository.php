<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Repositories\BaseRepositories;

class OrderRepository extends BaseRepositories implements OrderRepositoryInterface
{
    public function getModel()
    {
        return Order::class;
    }
    public function getOrdersByUserId($userId)
    {
        return $this->model
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')->get();
    }
}
