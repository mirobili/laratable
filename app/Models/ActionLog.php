<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActionLog extends BaseModel
{
    protected $fillable = [
        'table_id',
        'action',
        'details',
        'stamp',
        'reaction_stamp',
        'employee_id',
        'employee_name',
        'status',
    ];

    protected $casts = [
        'details' => 'array',
        'stamp' => 'datetime',
        'reaction_stamp' => 'datetime',
    ];

    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
