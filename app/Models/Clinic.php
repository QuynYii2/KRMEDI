<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;

    protected $table = 'clinics';

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function nation()
    {
        return $this->hasMany(Nation::class);
    }

    public function province()
    {
        return $this->hasMany(Province::class);
    }

    public function district()
    {
        return $this->hasMany(District::class);
    }

    public function commune()
    {
        return $this->hasMany(Commune::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'clinic_id', 'id');
    }
}
