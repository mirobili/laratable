<?php

namespace App\Repositories\Eloquent;

use App\Models\Notification;
use App\Repositories\Contracts\NotificationRepositoryInterface;
use Illuminate\Support\Collection;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    public function __construct(Notification $model)
    {
        parent::__construct($model);
    }

    public function getUnreadByEmployee(int $employeeId): Collection
    {
        return $this->model->where('message_to', (string)$employeeId)
            ->where('status', 'sent')
            ->with(['order', 'confirmedBy'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getUnreadByTable(int $tableId): Collection
    {
        return $this->model->whereHas('order', function($query) use ($tableId) {
                $query->where('table_id', $tableId);
            })
            ->where('status', 'sent')
            ->with(['order', 'confirmedBy'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function markAsRead(int $notificationId, int $employeeId): bool
    {
        return $this->model->where('id', $notificationId)
            ->update([
                'status' => 'read',
                'confirmed_by' => $employeeId,
                'confirmed_stamp' => now(),
            ]) > 0;
    }

    public function getRecentByVenue(int $venueId, int $limit = 10): Collection
    {
        return $this->model->whereHas('order', function($query) use ($venueId) {
                $query->where('venue_id', $venueId);
            })
            ->with(['order.table', 'confirmedBy'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
