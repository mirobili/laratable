<?php

namespace App\Services;

use App\Models\Table;
use App\Repositories\Contracts\TableRepositoryInterface;
use Illuminate\Support\Collection;

class TableService
{
    protected $tableRepository;

    public function __construct(TableRepositoryInterface $tableRepository)
    {
        $this->tableRepository = $tableRepository;
    }

    public function getTablesByVenue(int $venueId): Collection
    {
        return $this->tableRepository->getTablesByVenue($venueId);
    }

    public function getTableByQrCode(string $qrCode): ?Table
    {
        return $this->tableRepository->getTableByQrCode($qrCode);
    }

    public function getTablesWithActiveOrders(int $venueId): Collection
    {
        return $this->tableRepository->getTablesWithActiveOrders($venueId);
    }

    public function createTable(array $data): Table
    {
        return $this->tableRepository->create($data);
    }

    public function updateTable(int $id, array $data): bool
    {
        return $this->tableRepository->update($id, $data);
    }

    public function deleteTable(int $id): bool
    {
        return $this->tableRepository->delete($id);
    }

    public function generateQrCode(Table $table): string
    {
        // This is a placeholder - you'll need to implement actual QR code generation
        $qrCode = 'TBL-' . strtoupper(uniqid()) . '-' . $table->id;
        $this->updateTable($table->id, ['qr_code' => $qrCode]);
        return $qrCode;
    }
}
