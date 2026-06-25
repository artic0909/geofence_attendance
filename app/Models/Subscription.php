<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'transaction_id',
        'plan_name',
        'features',
        'price',
        'duration_days',
        'starts_at',
        'expires_at',
        'status',
    ];

    protected $casts = [
        'features' => 'array',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }}
