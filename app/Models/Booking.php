<?php

namespace App\Models;

use App\Events\BookingCreated;
use App\Models\Clinic;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['user_id', 'clinic_id', 'check_in', 'check_out', 'consulting_form', ''];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }
    
    protected $dispatchesEvents = [
        'created' => BookingCreated::class,
    ];
}
