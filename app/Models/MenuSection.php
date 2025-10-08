<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuSection extends BaseModel
{
    protected $fillable = [
        'menu_id',
        'section_name',
        'position',
    ];

    protected $casts = [
        'position' => 'integer',
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'section_id');
    }
}
