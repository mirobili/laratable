<?php

namespace App\Services;

use App\Models\Notification;
use App\Repositories\Contracts\NotificationRepositoryInterface;
use Illuminate\Support\Collection;

class NotificationService
{
    protected $notificationRepository;

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function getUnreadByEmployee(int $employeeId): Collection
    {
        return $this->notificationRepository->getUnreadByEmployee($employeeId);
    }

    public function getUnreadByTable(int $tableId): Collection
    {
        return $this->notificationRepository->getUnreadByTable($tableId);
    }

    public function markAsRead(int $notificationId, int $employeeId): bool
    {
        return $this->notificationRepository->markAsRead($notificationId, $employeeId);
    }

    public function getRecentByVenue(int $venueId, int $limit = 10): Collection
    {
        return $this->notificationRepository->getRecentByVenue($venueId, $limit);
    }

    public function createNotification(array $data): Notification
    {
        // Set default values
        $data = array_merge([
            'status' => 'sent',
            'stamp' => now(),
        ], $data);

        return $this->notificationRepository->create($data);
    }

    public function notifyWaiter(int $tableId, string $message, string $type = 'service'): Notification
    {
        return $this->createNotification([
            'message' => $message,
            'message_to' => 'waiter', // This could be a role or specific employee ID
            'type' => $type,
            'table_id' => $tableId,
        ]);
    }

    public function notifyOrderUpdate(int $orderId, string $message, ?int $employeeId = null): Notification
    {
        return $this->createNotification([
            'order_id' => $orderId,
            'message' => $message,
            'message_to' => $employeeId ? (string)$employeeId : 'kitchen',
            'type' => 'order_update',
        ]);
    }
}
