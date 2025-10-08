<?php

namespace App\Repositories\Contracts;

use App\Models\MenuItem;
use Illuminate\Support\Collection;

interface MenuItemRepositoryInterface extends RepositoryInterface
{
    public function getItemsBySection(int $sectionId): Collection;
    public function getAvailableItemsByMenu(int $menuId): Collection;
    public function updateAvailability(int $id, bool $isAvailable): bool;
}
