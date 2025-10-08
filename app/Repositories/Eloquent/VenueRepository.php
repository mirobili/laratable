<?php

namespace App\Repositories\Eloquent;

use App\Models\Venue;
use App\Repositories\Contracts\VenueRepositoryInterface;
use Illuminate\Support\Collection;

class VenueRepository extends BaseRepository implements VenueRepositoryInterface
{
    public function __construct(Venue $model)
    {
        parent::__construct($model);
    }

    public function getVenuesByCompany(int $companyId): Collection
    {
        return $this->model->where('company_id', $companyId)
            ->with(['tables', 'menus'])
            ->orderBy('name')
            ->get();
    }

    public function getVenueWithRelations(int $venueId): ?Venue
    {
        return $this->model->with([
            'company', 
            'tables', 
            'menus', 
            'orders' => function($query) {
                $query->where('status', 'open');
            }
        ])->find($venueId);
    }
}
