<?php

namespace App\Repositories\Contracts;

use App\Models\Menu;
use Illuminate\Support\Collection;

interface MenuRepositoryInterface extends RepositoryInterface
{
    public function getActiveMenusByVenue(int $venueId): Collection;
    public function getMenuWithItems(int $menuId): ?Menu;
}
