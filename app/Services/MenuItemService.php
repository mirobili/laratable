<?php

namespace App\Services;

use App\Models\MenuItem;
use App\Repositories\Contracts\MenuItemRepositoryInterface;
use Illuminate\Support\Collection;

class MenuItemService
{
    protected $menuItemRepository;

    public function __construct(MenuItemRepositoryInterface $menuItemRepository)
    {
        $this->menuItemRepository = $menuItemRepository;
    }

    public function getItemsBySection(int $sectionId): Collection
    {
        return $this->menuItemRepository->getItemsBySection($sectionId);
    }

    public function getAvailableItemsByMenu(int $menuId): Collection
    {
        return $this->menuItemRepository->getAvailableItemsByMenu($menuId);
    }

    public function getItem(int $id): ?MenuItem
    {
        return $this->menuItemRepository->find($id);
    }

    public function createItem(array $data): MenuItem
    {
        return $this->menuItemRepository->create($data);
    }

    public function updateItem(int $id, array $data): bool
    {
        return $this->menuItemRepository->update($id, $data);
    }

    public function deleteItem(int $id): bool
    {
        return $this->menuItemRepository->delete($id);
    }

    public function updateAvailability(int $id, bool $isAvailable): bool
    {
        return $this->menuItemRepository->updateAvailability($id, $isAvailable);
    }
}
