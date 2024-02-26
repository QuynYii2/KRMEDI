<?php

namespace App\Models\online_medicine;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'name_en', 'name_laos', 'status'
    ];
}
