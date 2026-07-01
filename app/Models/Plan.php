<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration_days',
        'features',
        'active',
        'is_popular',
        'is_trial',
    ];

    protected $casts = [
        'features' => 'array',
        'active' => 'boolean',
        'is_popular' => 'boolean',
        'is_trial' => 'boolean',
        'duration_days' => 'integer',
    ];
}
