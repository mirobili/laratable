<?php

namespace App\Repositories\Eloquent;

use App\Models\OrderItem;
use App\Repositories\Contracts\OrderItemRepositoryInterface;
use Illuminate\Support\Collection;

class OrderItemRepository extends BaseRepository implements OrderItemRepositoryInterface
{
    public function __construct(OrderItem $model)
    {
        parent::__construct($model);
    }

    public function getItemsByOrder(int $orderId): Collection
    {
        return $this->model->where('order_id', $orderId)
            ->with(['product', 'confirmedBy', 'completedBy'])
            ->orderBy('create_stamp', 'desc')
            ->get();
    }

    public function getPendingItemsByVenue(int $venueId): Collection
    {
        return $this->model->whereHas('order', function($query) use ($venueId) {
                $query->where('venue_id', $venueId);
            })
            ->whereIn('status', ['pending', 'confirmed', 'preparing'])
            ->with(['order.table', 'product', 'confirmedBy'])
            ->orderBy('create_stamp', 'asc')
            ->get();
    }

    public function updateStatus(int $id, string $status, ?int $employeeId = null): bool
    {
        $updates = ['status' => $status];
        $now = now();

        switch ($status) {
            case 'confirmed':
                $updates['confirm_stamp'] = $now;
                $updates['confirm_by'] = $employeeId;
                break;
            case 'preparing':
                $updates['start_stamp'] = $now;
                break;
            case 'ready':
                $updates['complete_stamp'] = $now;
                $updates['completed_by'] = $employeeId;
                break;
            case 'delivered':
                $updates['delivery_stamp'] = $now;
                break;
            case 'cancelled':
                $updates['cancel_stamp'] = $now;
                $updates['cancelled_by'] = $employeeId;
                break;
        }

        return $this->model->where('id', $id)->update($updates) > 0;
    }
}
