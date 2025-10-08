<?php

namespace App\Services;

use App\Models\ActionLog;
use App\Repositories\Contracts\ActionLogRepositoryInterface;
use Illuminate\Support\Collection;

class ActionLogService
{
    protected $actionLogRepository;

    public function __construct(ActionLogRepositoryInterface $actionLogRepository)
    {
        $this->actionLogRepository = $actionLogRepository;
    }

    public function getLogsByTable(int $tableId, int $limit = 10): Collection
    {
        return $this->actionLogRepository->getLogsByTable($tableId, $limit);
    }

    public function getPendingLogsByVenue(int $venueId): Collection
    {
        return $this->actionLogRepository->getPendingLogsByVenue($venueId);
    }

    public function createLog(array $data): ActionLog
    {
        $logData = array_merge($data, [
            'status' => 'pending',
            'stamp' => now(),
        ]);

        return $this->actionLogRepository->create($logData);
    }

    public function markAsCompleted(int $logId, int $employeeId): bool
    {
        return $this->actionLogRepository->markAsCompleted($logId, $employeeId);
    }

    public function logTableAction(int $tableId, string $action, ?array $details = null, ?int $employeeId = null): ActionLog
    {
        $data = [
            'table_id' => $tableId,
            'action' => $action,
            'details' => $details,
        ];

        if ($employeeId) {
            $data['employee_id'] = $employeeId;
        }

        return $this->createLog($data);
    }
}
