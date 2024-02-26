<?php

namespace App\Models;

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
}
