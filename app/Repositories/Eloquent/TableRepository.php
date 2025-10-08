<?php

namespace App\Repositories\Eloquent;

use App\Models\Table;
use App\Repositories\Contracts\TableRepositoryInterface;
use Illuminate\Support\Collection;

class TableRepository extends BaseRepository implements TableRepositoryInterface
{
    public function __construct(Table $model)
    {
        parent::__construct($model);
    }

    public function getTablesByVenue(int $venueId): Collection
    {
        return $this->model->where('venue_id', $venueId)
            ->orderBy('name')
            ->get();
    }

    public function getTableByQrCode(string $qrCode): ?Table
    {
        return $this->model->where('qr_code', $qrCode)
            ->with(['venue', 'orders' => function($query) {
                $query->where('status', 'open');
            }])
            ->first();
    }

    public function getTablesWithActiveOrders(int $venueId): Collection
    {
        return $this->model->where('venue_id', $venueId)
            ->whereHas('orders', function($query) {
                $query->where('status', 'open');
            })
            ->with(['orders' => function($query) {
                $query->where('status', 'open')
                    ->with(['items', 'employee']);
            }])
            ->get();
    }
}
