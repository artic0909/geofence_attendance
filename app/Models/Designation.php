<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $fillable = ['name', 'admin_id'];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function employees()
    {
        return $this->hasMany(User::class, 'designation_id');
    }}
