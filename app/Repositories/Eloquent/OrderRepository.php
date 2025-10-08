<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Collection;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function getActiveOrdersByVenue(int $venueId): Collection
    {
        return $this->model->where('venue_id', $venueId)
            ->where('status', '!=', 'closed')
            ->with(['table', 'items'])
            ->get();
    }

    public function getOrdersByTable(int $tableId): Collection
    {
        return $this->model->where('table_id', $tableId)
            ->with(['items', 'employee'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getOrdersByEmployee(int $employeeId): Collection
    {
        return $this->model->where('employee_id', $employeeId)
            ->with(['table', 'items'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getOrdersByStatus(string $status): Collection
    {
        return $this->model->where('status', $status)
            ->with(['table', 'items', 'employee'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getOrderByReference(string $referenceId): ?Order
    {
        return $this->model->where('r_id', $referenceId)
            ->with(['table', 'items', 'employee', 'venue'])
            ->first();
    }
}
