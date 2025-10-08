<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends BaseModel
{
    protected $fillable = [
        'name',
        'irs_id',
        'stamp',
        'meta_data',
        'contact_info',
    ];

    protected $casts = [
        'meta_data' => 'array',
        'contact_info' => 'array',
    ];

    public function venues(): HasMany
    {
        return $this->hasMany(Venue::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
