<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends BaseModel
{
    protected $fillable = [
        'name',
        'venue_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(MenuSection::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }
}
