<?php

namespace App\Services;

use App\Models\MenuSection;
use App\Repositories\Contracts\MenuSectionRepositoryInterface;
use Illuminate\Support\Collection;

class MenuSectionService
{
    protected $menuSectionRepository;

    public function __construct(MenuSectionRepositoryInterface $menuSectionRepository)
    {
        $this->menuSectionRepository = $menuSectionRepository;
    }

    public function getSectionsByMenu(int $menuId): Collection
    {
        return $this->menuSectionRepository->getSectionsByMenu($menuId);
    }

    public function getSection(int $id): ?MenuSection
    {
        return $this->menuSectionRepository->find($id);
    }

    public function createSection(array $data): MenuSection
    {
        // Set default position if not provided
        if (!isset($data['position'])) {
            $lastSection = $this->menuSectionRepository
                ->where('menu_id', $data['menu_id'])
                ->orderBy('position', 'desc')
                ->first();
            $data['position'] = $lastSection ? $lastSection->position + 1 : 0;
        }

        return $this->menuSectionRepository->create($data);
    }

    public function updateSection(int $id, array $data): bool
    {
        return $this->menuSectionRepository->update($id, $data);
    }

    public function deleteSection(int $id): bool
    {
        return $this->menuSectionRepository->delete($id);
    }

    public function reorderSections(array $order): bool
    {
        return $this->menuSectionRepository->reorderSections($order);
    }
}
