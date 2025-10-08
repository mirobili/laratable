<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Collection;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function getProductsByType(string $type): Collection
    {
        return $this->model->where('product_type', $type)
            ->orderBy('name')
            ->get();
    }

    public function searchProducts(string $query): Collection
    {
        return $this->model->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->orderBy('name')
            ->get();
    }
}
