<?php

namespace App\Services;

use App\Models\Menu;
use App\Repositories\Contracts\MenuRepositoryInterface;
use Illuminate\Support\Collection;

class MenuService
{
    protected $menuRepository;

    public function __construct(MenuRepositoryInterface $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function getActiveMenusByVenue(int $venueId): Collection
    {
        return $this->menuRepository->getActiveMenusByVenue($venueId);
    }

    public function getMenuWithItems(int $menuId): ?Menu
    {
        return $this->menuRepository->getMenuWithItems($menuId);
    }

    public function createMenu(array $data): Menu
    {
        return $this->menuRepository->create($data);
    }

    public function updateMenu(int $id, array $data): bool
    {
        return $this->menuRepository->update($id, $data);
    }

    public function deleteMenu(int $id): bool
    {
        return $this->menuRepository->delete($id);
    }
}
