<?php

namespace App\Repositories\Contracts;

use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function getProductsByType(string $type): Collection;
    public function searchProducts(string $query): Collection;
}
