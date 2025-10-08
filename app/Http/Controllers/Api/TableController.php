<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TableRequest;
use App\Services\TableService;
use Illuminate\Http\JsonResponse;

class TableController extends Controller
{
    protected $tableService;

    public function __construct(TableService $tableService)
    {
        $this->tableService = $tableService;
        $this->middleware('auth:api');
    }

    public function index(int $venueId): JsonResponse
    {
        $tables = $this->tableService->getTablesByVenue($venueId);
        return $this->sendResponse($tables, 'Tables retrieved successfully');
    }

    public function store(TableRequest $request, int $venueId): JsonResponse
    {
        $data = array_merge($request->validated(), ['venue_id' => $venueId]);
        $table = $this->tableService->createTable($data);
        return $this->sendResponse($table, 'Table created successfully', 201);
    }

    public function show(int $venueId, int $tableId): JsonResponse
    {
        $table = $this->tableService->getTableWithRelations($tableId);
        
        if (!$table || $table->venue_id != $venueId) {
            return $this->sendError('Table not found or does not belong to this venue');
        }

        return $this->sendResponse($table, 'Table retrieved successfully');
    }

    public function update(TableRequest $request, int $venueId, int $tableId): JsonResponse
    {
        $table = $this->tableService->getTable($tableId);
        
        if (!$table || $table->venue_id != $venueId) {
            return $this->sendError('Table not found or does not belong to this venue');
        }

        $updated = $this->tableService->updateTable($tableId, $request->validated());
        
        if (!$updated) {
            return $this->sendError('Table could not be updated');
        }

        return $this->sendResponse([], 'Table updated successfully');
    }

    public function destroy(int $venueId, int $tableId): JsonResponse
    {
        $table = $this->tableService->getTable($tableId);
        
        if (!$table || $table->venue_id != $venueId) {
            return $this->sendError('Table not found or does not belong to this venue');
        }

        try {
            $deleted = $this->tableService->deleteTable($tableId);
            
            if (!$deleted) {
                return $this->sendError('Table could not be deleted');
            }

            return $this->sendResponse([], 'Table deleted successfully');
            
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), [], 400);
        }
    }

    public function generateQrCode(int $venueId, int $tableId): JsonResponse
    {
        $table = $this->tableService->getTable($tableId);
        
        if (!$table || $table->venue_id != $venueId) {
            return $this->sendError('Table not found or does not belong to this venue');
        }

        $qrCode = $this->tableService->generateQrCode($tableId);
        
        return $this->sendResponse(
            ['qr_code' => $qrCode], 
            'QR code generated successfully'
        );
    }
}
