<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceClinic extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'name', 'name_en', 'name_laos', 'user_id', 'service_price'
    ];
}
