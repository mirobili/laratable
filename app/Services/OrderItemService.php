<?php

namespace App\Services;

use App\Models\OrderItem;
use App\Repositories\Contracts\OrderItemRepositoryInterface;
use Illuminate\Support\Collection;

class OrderItemService
{
    protected $orderItemRepository;

    public function __construct(OrderItemRepositoryInterface $orderItemRepository)
    {
        $this->orderItemRepository = $orderItemRepository;
    }

    public function getItemsByOrder(int $orderId): Collection
    {
        return $this->orderItemRepository->getItemsByOrder($orderId);
    }

    public function getPendingItemsByVenue(int $venueId): Collection
    {
        return $this->orderItemRepository->getPendingItemsByVenue($venueId);
    }

    public function createOrderItem(array $data): OrderItem
    {
        $defaults = [
            'status' => 'pending',
            'create_stamp' => now(),
            'quantity' => $data['quantity'] ?? 1,
        ];

        return $this->orderItemRepository->create(array_merge($defaults, $data));
    }

    public function updateOrderItem(int $id, array $data): bool
    {
        return $this->orderItemRepository->update($id, $data);
    }

    public function deleteOrderItem(int $id): bool
    {
        return $this->orderItemRepository->delete($id);
    }

    public function updateStatus(int $id, string $status, ?int $employeeId = null): bool
    {
        return $this->orderItemRepository->updateStatus($id, $status, $employeeId);
    }

    public function getOrderItem(int $id): ?OrderItem
    {
        return $this->orderItemRepository->find($id);
    }

    public function bulkUpdateStatus(array $itemIds, string $status, ?int $employeeId = null): int
    {
        $count = 0;
        
        foreach ($itemIds as $itemId) {
            if ($this->updateStatus($itemId, $status, $employeeId)) {
                $count++;
            }
        }
        
        return $count;
    }
}
