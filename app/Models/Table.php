<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Table extends BaseModel
{
    protected $fillable = [
        'venue_id',
        'name',
        'number',
        'capacity',
        'qr_code',
    ];

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function actionLogs(): HasMany
    {
        return $this->hasMany(ActionLog::class);
    }
}
