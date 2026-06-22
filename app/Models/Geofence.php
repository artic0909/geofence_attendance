<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Geofence extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'name',
        'latitude',
        'longitude',
        'radius',
        'address',
        'is_active',
        'tracking_radius'
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function employees()
    {
        return $this->belongsToMany(User::class, 'employee_geofence', 'geofence_id', 'employee_id');
    }
}
