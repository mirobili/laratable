<?php

namespace App\Repositories\Contracts;

use App\Models\MenuSection;
use Illuminate\Support\Collection;

interface MenuSectionRepositoryInterface extends RepositoryInterface
{
    public function getSectionsByMenu(int $menuId): Collection;
    public function reorderSections(array $order): bool;
}
