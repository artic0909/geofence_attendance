<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutsideAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'employee_id',
        'date',
        'check_in',
        'check_in_lat',
        'check_in_lng',
        'check_in_photo',
        'checkin_location',
        'check_out',
        'check_out_lat',
        'check_out_lng',
        'check_out_photo',
        'checkout_location',
        'reason',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
