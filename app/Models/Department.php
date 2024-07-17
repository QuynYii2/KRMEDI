<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'thumbnail', 'isFilter', 'order'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'department_id', 'id');
    }
}
