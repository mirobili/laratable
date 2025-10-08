<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends BaseModel
{
    protected $fillable = [
        'product_id',
        'menu_id',
        'section_id',
        'price',
        'alt_name',
        'description',
        'item_meta',
        'image_url',
        'product_type',
        'qr_code',
        'is_available',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'item_meta' => 'array',
        'is_available' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(MenuSection::class, 'section_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'product_id');
    }
}
