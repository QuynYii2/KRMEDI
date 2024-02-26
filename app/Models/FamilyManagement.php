<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyManagement extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_code', 'user_id', 'relationship',
        'name', 'date_of_birth', 'number_phone',
        'email', 'sex',
        'province_id', 'district_id', 'ward_id', 'detail_address'
    ];

}
