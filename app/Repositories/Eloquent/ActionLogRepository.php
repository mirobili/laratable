<?php

namespace App\Repositories\Eloquent;

use App\Models\ActionLog;
use App\Repositories\Contracts\ActionLogRepositoryInterface;
use Illuminate\Support\Collection;

class ActionLogRepository extends BaseRepository implements ActionLogRepositoryInterface
{
    public function __construct(ActionLog $model)
    {
        parent::__construct($model);
    }

    public function getLogsByTable(int $tableId, int $limit = 10): Collection
    {
        return $this->model->where('table_id', $tableId)
            ->with('employee')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getPendingLogsByVenue(int $venueId): Collection
    {
        return $this->model->whereHas('table', function($query) use ($venueId) {
                $query->where('venue_id', $venueId);
            })
            ->where('status', 'pending')
            ->with(['table', 'employee'])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function markAsCompleted(int $logId, int $employeeId): bool
    {
        return $this->model->where('id', $logId)
            ->update([
                'status' => 'completed',
                'employee_id' => $employeeId,
                'reaction_stamp' => now(),
            ]) > 0;
    }
}
