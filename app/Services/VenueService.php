<?php

namespace App\Services;

use App\Models\Venue;
use App\Repositories\Contracts\VenueRepositoryInterface;
use Illuminate\Support\Collection;

class VenueService
{
    protected $venueRepository;

    public function __construct(VenueRepositoryInterface $venueRepository)
    {
        $this->venueRepository = $venueRepository;
    }

    public function getVenuesByCompany(int $companyId): Collection
    {
        return $this->venueRepository->getVenuesByCompany($companyId);
    }

    public function getVenue(int $id): ?Venue
    {
        return $this->venueRepository->find($id);
    }

    public function getVenueWithRelations(int $venueId): ?Venue
    {
        return $this->venueRepository->getVenueWithRelations($venueId);
    }

    public function createVenue(array $data): Venue
    {
        return $this->venueRepository->create($data);
    }

    public function updateVenue(int $id, array $data): bool
    {
        return $this->venueRepository->update($id, $data);
    }

    public function deleteVenue(int $id): bool
    {
        // Check if venue has any dependencies before deleting
        $venue = $this->getVenueWithRelations($id);
        
        if ($venue->tables->count() > 0) {
            throw new \Exception('Cannot delete venue with existing tables');
        }
        
        if ($venue->menus->count() > 0) {
            throw new \Exception('Cannot delete venue with existing menus');
        }
        
        if ($venue->orders->count() > 0) {
            throw new \Exception('Cannot delete venue with existing orders');
        }

        return $this->venueRepository->delete($id);
    }

    public function getVenueStatistics(int $venueId): array
    {
        $venue = $this->getVenueWithRelations($venueId);
        
        if (!$venue) {
            throw new \Exception('Venue not found');
        }

        return [
            'tables_count' => $venue->tables->count(),
            'active_menus' => $venue->menus->where('is_active', true)->count(),
            'active_orders' => $venue->orders->where('status', 'open')->count(),
            'total_orders' => $venue->orders->count(),
        ];
    }
}
