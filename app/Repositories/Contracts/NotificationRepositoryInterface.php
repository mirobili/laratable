<?php

namespace App\Repositories\Contracts;

use App\Models\Notification;
use Illuminate\Support\Collection;

interface NotificationRepositoryInterface extends RepositoryInterface
{
    public function getUnreadByEmployee(int $employeeId): Collection;
    public function getUnreadByTable(int $tableId): Collection;
    public function markAsRead(int $notificationId, int $employeeId): bool;
    public function getRecentByVenue(int $venueId, int $limit = 10): Collection;
}
