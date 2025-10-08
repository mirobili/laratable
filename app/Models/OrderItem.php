<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItem extends BaseModel
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'serving',
        'quantity',
        'price',
        'notes',
        'status',
        'confirm_by',
        'completed_by',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'create_stamp' => 'datetime',
        'confirm_stamp' => 'datetime',
        'complete_stamp' => 'datetime',
        'delivery_stamp' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'confirm_by');
    }

    public function completedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'completed_by');
    }
}
