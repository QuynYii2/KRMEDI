<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'title_en', 'title_laos', 'status', 'type', 'thumbnail',
        'short_description', 'short_description_en', 'short_description_laos',
        'description', 'description_en', 'description_laos',
    ];
}
