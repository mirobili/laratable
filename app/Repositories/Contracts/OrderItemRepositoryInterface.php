<?php

namespace App\Repositories\Contracts;

use App\Models\OrderItem;
use Illuminate\Support\Collection;

interface OrderItemRepositoryInterface extends RepositoryInterface
{
    public function getItemsByOrder(int $orderId): Collection;
    public function getPendingItemsByVenue(int $venueId): Collection;
    public function updateStatus(int $id, string $status, ?int $employeeId = null): bool;
}
