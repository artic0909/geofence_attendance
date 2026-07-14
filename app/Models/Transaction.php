<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'employee_count',
        'razorpay_payment_id',
        'razorpay_order_id',
        'amount',
        'gst_amount',
        'currency',
        'status',
        'invoice_number',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (empty($transaction->invoice_number)) {
                do {
                    $invoiceNumber = 'INV-' . date('ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(6));
                } while (self::where('invoice_number', $invoiceNumber)->exists());
                
                $transaction->invoice_number = $invoiceNumber;
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }
}
