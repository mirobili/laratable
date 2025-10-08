<?php

namespace App\Repositories\Eloquent;

use App\Models\Menu;
use App\Repositories\Contracts\MenuRepositoryInterface;
use Illuminate\Support\Collection;

class MenuRepository extends BaseRepository implements MenuRepositoryInterface
{
    public function __construct(Menu $model)
    {
        parent::__construct($model);
    }

    public function getActiveMenusByVenue(int $venueId): Collection
    {
        return $this->model->where('venue_id', $venueId)
            ->where('is_active', true)
            ->with(['sections', 'items'])
            ->get();
    }

    public function getMenuWithItems(int $menuId): ?Menu
    {
        return $this->model->with(['sections' => function($query) {
                $query->orderBy('position');
            }, 'sections.items' => function($query) {
                $query->where('is_available', true);
            }])
            ->find($menuId);
    }
}
