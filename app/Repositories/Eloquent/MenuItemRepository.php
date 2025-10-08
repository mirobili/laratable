<?php

namespace App\Repositories\Eloquent;

use App\Models\MenuItem;
use App\Repositories\Contracts\MenuItemRepositoryInterface;
use Illuminate\Support\Collection;

class MenuItemRepository extends BaseRepository implements MenuItemRepositoryInterface
{
    public function __construct(MenuItem $model)
    {
        parent::__construct($model);
    }

    public function getItemsBySection(int $sectionId): Collection
    {
        return $this->model->where('section_id', $sectionId)
            ->where('is_available', true)
            ->orderBy('name')
            ->get();
    }

    public function getAvailableItemsByMenu(int $menuId): Collection
    {
        return $this->model->where('menu_id', $menuId)
            ->where('is_available', true)
            ->with(['product', 'section'])
            ->get();
    }

    public function updateAvailability(int $id, bool $isAvailable): bool
    {
        return $this->model->where('id', $id)
            ->update(['is_available' => $isAvailable]) > 0;
    }
}
