<?php

namespace App\Repositories\Contracts;

use App\Models\Table;
use Illuminate\Support\Collection;

interface TableRepositoryInterface extends RepositoryInterface
{
    public function getTablesByVenue(int $venueId): Collection;
    public function getTableByQrCode(string $qrCode): ?Table;
    public function getTablesWithActiveOrders(int $venueId): Collection;
}
