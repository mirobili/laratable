<?php

namespace App\Repositories\Contracts;

use App\Models\Venue;
use Illuminate\Support\Collection;

interface VenueRepositoryInterface extends RepositoryInterface
{
    public function getVenuesByCompany(int $companyId): Collection;
    public function getVenueWithRelations(int $venueId): ?Venue;
}
