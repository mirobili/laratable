<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends BaseModel
{
    protected $fillable = [
        'name',
        'description',
        'product_type',
        'image_url',
    ];

    protected $casts = [
        'product_type' => 'string',
    ];

    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
