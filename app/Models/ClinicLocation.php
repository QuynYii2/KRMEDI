<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicLocation extends Model
{
    use HasFactory;

    protected $table = 'clinic_locations';
    protected $fillable = [
        'user_id',
        'address_detail',
        'province_id',
        'district_id',
        'commune_id',
        'latitude',
        'longitude',
        'status',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'code');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'code');
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class, 'commune_id', 'code');
    }

}
