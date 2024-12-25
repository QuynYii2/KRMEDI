<?php

namespace App\Models;

use App\Events\BookingCreated;
use App\Models\Clinic;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['user_id', 'clinic_id', 'check_in', 'check_out', 'consulting_form', 'member_family_id', 'department_id', 'service',
        'doctor_id','status','extend','is_result','prescription_file','type','is_read','service_price', 'clinic_location_id'];

    protected $casts = [
        'extend' => 'array',
    ];

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

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
    protected $dispatchesEvents = [
        'created' => BookingCreated::class,
    ];
}
