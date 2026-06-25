<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'features',
        'active',
        'is_popular',
    ];

    protected $casts = [
        'features' => 'array',
        'active' => 'boolean',
        'is_popular' => 'boolean',
    ];
}
