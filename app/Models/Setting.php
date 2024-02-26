<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'logo',
        'ad_banner_position',
        'ad_banner_link',
        'ad_banner_follow',
        'address',
        'email',
        'phone',
        'social_links',
        'website_description',
        'favicon',
    ];
}
