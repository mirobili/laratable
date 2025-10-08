<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class OrderService
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function createOrder(array $data): Order
    {
        $data['r_id'] = $this->generateOrderReference();
        return $this->orderRepository->create($data);
    }

    public function updateOrder(int $id, array $data): bool
    {
        return $this->orderRepository->update($id, $data);
    }

    public function getOrder(int $id): ?Order
    {
        return $this->orderRepository->find($id);
    }

    public function getOrderByReference(string $referenceId): ?Order
    {
        return $this->orderRepository->getOrderByReference($referenceId);
    }

    public function getActiveOrdersByVenue(int $venueId): Collection
    {
        return $this->orderRepository->getActiveOrdersByVenue($venueId);
    }

    public function getOrdersByTable(int $tableId): Collection
    {
        return $this->orderRepository->getOrdersByTable($tableId);
    }

    public function addItemToOrder(Order $order, array $itemData): OrderItem
    {
        return $order->items()->create($itemData);
    }

    public function updateOrderItem(Order $order, int $itemId, array $data): bool
    {
        return $order->items()->where('id', $itemId)->update($data) > 0;
    }

    public function removeItemFromOrder(Order $order, int $itemId): bool
    {
        return $order->items()->where('id', $itemId)->delete() > 0;
    }

    public function calculateOrderTotal(Order $order): float
    {
        return $order->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    public function closeOrder(Order $order, array $data = []): bool
    {
        $updateData = [
            'status' => 'closed',
            'close_time' => now(),
            'amount' => $this->calculateOrderTotal($order),
        ];

        if (!empty($data['payment_method'])) {
            $updateData['payment_method'] = $data['payment_method'];
        }

        if (!empty($data['employee_id'])) {
            $updateData['employee_id'] = $data['employee_id'];
        }

        return $this->updateOrder($order->id, $updateData);
    }

    protected function generateOrderReference(): string
    {
        return 'ORD-' . strtoupper(Str::random(8)) . '-' . time();
    }
}
