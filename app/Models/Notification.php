<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends BaseModel
{
    protected $fillable = [
        'order_id',
        'message',
        'message_to',
        'type',
        'status',
        'stamp',
        'confirmed_stamp',
        'confirmed_by',
    ];

    protected $casts = [
        'stamp' => 'datetime',
        'confirmed_stamp' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'confirmed_by');
    }
}
