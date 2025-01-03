<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;

    protected $table = 'clinics';
    protected $fillable = [
        'user_id',
        'name',
        'address_detail',
        'experience',
        'introduce',
        'gallery',
        'email',
        'time_work',
        'status',
        'type',
        'open_date',
        'close_date',
        'service_id',
        'department',
        'symptom',
        'emergency',
        'insurance',
        'parking',
        'information',
        'facilities',
        'equipment',
        'costs',
        'representative_doctor',
        'latitude',
        'longitude',
        'address',
        'phone'
    ];

    protected $casts = [
        'open_date' => 'datetime',
        'close_date' => 'datetime',
    ];

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

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
