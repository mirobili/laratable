<?php

namespace App\Repositories\Contracts;

use App\Models\ActionLog;
use Illuminate\Support\Collection;

interface ActionLogRepositoryInterface extends RepositoryInterface
{
    public function getLogsByTable(int $tableId, int $limit = 10): Collection;
    public function getPendingLogsByVenue(int $venueId): Collection;
    public function markAsCompleted(int $logId, int $employeeId): bool;
}
