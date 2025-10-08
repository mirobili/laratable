<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\VenueRequest;
use App\Services\VenueService;
use Illuminate\Http\JsonResponse;

class VenueController extends Controller
{
    protected $venueService;

    public function __construct(VenueService $venueService)
    {
        $this->venueService = $venueService;
        $this->middleware('auth:api');
    }

    /**
     * Get all venues for a company
     *
     * @param int $companyId
     * @return JsonResponse
     */
    public function index(int $companyId): JsonResponse
    {
        $venues = $this->venueService->getVenuesByCompany($companyId);
        return $this->sendResponse($venues, 'Venues retrieved successfully');
    }

    /**
     * Store a newly created venue
     *
     * @param VenueRequest $request
     * @param int $companyId
     * @return JsonResponse
     */
    public function store(VenueRequest $request, int $companyId): JsonResponse
    {
        $data = array_merge($request->validated(), ['company_id' => $companyId]);
        $venue = $this->venueService->createVenue($data);
        return $this->sendResponse($venue, 'Venue created successfully', 201);
    }

    /**
     * Display the specified venue
     *
     * @param int $companyId
     * @param int $venueId
     * @return JsonResponse
     */
    public function show(int $companyId, int $venueId): JsonResponse
    {
        $venue = $this->venueService->getVenueWithRelations($venueId);
        
        if (!$venue || $venue->company_id != $companyId) {
            return $this->sendError('Venue not found or does not belong to this company');
        }

        return $this->sendResponse($venue, 'Venue retrieved successfully');
    }

    /**
     * Update the specified venue
     *
     * @param VenueRequest $request
     * @param int $companyId
     * @param int $venueId
     * @return JsonResponse
     */
    public function update(VenueRequest $request, int $companyId, int $venueId): JsonResponse
    {
        $venue = $this->venueService->getVenue($venueId);
        
        if (!$venue || $venue->company_id != $companyId) {
            return $this->sendError('Venue not found or does not belong to this company');
        }

        $updated = $this->venueService->updateVenue($venueId, $request->validated());
        
        if (!$updated) {
            return $this->sendError('Venue could not be updated');
        }

        return $this->sendResponse([], 'Venue updated successfully');
    }

    /**
     * Remove the specified venue
     *
     * @param int $companyId
     * @param int $venueId
     * @return JsonResponse
     */
    public function destroy(int $companyId, int $venueId): JsonResponse
    {
        $venue = $this->venueService->getVenue($venueId);
        
        if (!$venue || $venue->company_id != $companyId) {
            return $this->sendError('Venue not found or does not belong to this company');
        }

        try {
            $deleted = $this->venueService->deleteVenue($venueId);
            
            if (!$deleted) {
                return $this->sendError('Venue could not be deleted');
            }

            return $this->sendResponse([], 'Venue deleted successfully');
            
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), [], 400);
        }
    }

    /**
     * Get venue statistics
     *
     * @param int $companyId
     * @param int $venueId
     * @return JsonResponse
     */
    public function statistics(int $companyId, int $venueId): JsonResponse
    {
        $venue = $this->venueService->getVenue($venueId);
        
        if (!$venue || $venue->company_id != $companyId) {
            return $this->sendError('Venue not found or does not belong to this company');
        }

        $statistics = $this->venueService->getVenueStatistics($venueId);
        return $this->sendResponse($statistics, 'Venue statistics retrieved successfully');
    }
}
