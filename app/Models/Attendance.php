<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'employee_id',
        'geofence_id',
        'date',
        'check_in',
        'check_in_lat',
        'check_in_lng',
        'check_in_photo',
        'check_out',
        'check_out_lat',
        'check_out_lng',
        'check_out_photo',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function geofence() {
        return $this->belongsTo(Geofence::class);
    }
}