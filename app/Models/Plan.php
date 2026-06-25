<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'description',
        'monthly_price',
        'yearly_price',
        'features',
        'active',
    ];

    protected $casts = [
        'features' => 'array',
        'active' => 'boolean',
    ];
}
