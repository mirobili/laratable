<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use Illuminate\Support\Collection;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function getActiveOrdersByVenue(int $venueId): Collection;
    public function getOrdersByTable(int $tableId): Collection;
    public function getOrdersByEmployee(int $employeeId): Collection;
    public function getOrdersByStatus(string $status): Collection;
    public function getOrderByReference(string $referenceId): ?Order;
}
