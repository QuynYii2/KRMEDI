<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'instagram', 'facebook', 'youtube',
        'tiktok', 'google_review', 'other', 'status',
    ];
}
