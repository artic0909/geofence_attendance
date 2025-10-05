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
        'is_active'
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // Add this relationship
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_geofence');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
