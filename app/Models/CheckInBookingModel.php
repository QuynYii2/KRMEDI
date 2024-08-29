<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckInBookingModel extends Model
{
    use HasFactory;
    protected $table='check_in_booking';
    protected $fillable=[
        'clinic_id',
        'user_id'
    ];
}
