<?php

namespace App\Repositories\Eloquent;

use App\Models\MenuSection;
use App\Repositories\Contracts\MenuSectionRepositoryInterface;
use Illuminate\Support\Collection;

class MenuSectionRepository extends BaseRepository implements MenuSectionRepositoryInterface
{
    public function __construct(MenuSection $model)
    {
        parent::__construct($model);
    }

    public function getSectionsByMenu(int $menuId): Collection
    {
        return $this->model->where('menu_id', $menuId)
            ->orderBy('position')
            ->with('items')
            ->get();
    }

    public function reorderSections(array $order): bool
    {
        foreach ($order as $position => $id) {
            $this->model->where('id', $id)->update(['position' => $position]);
        }
        return true;
    }
}
