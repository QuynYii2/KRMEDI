<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ZaloFollower extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'zalo_followers';
    protected $fillable = [
        'avatar',
        'name',
        'user_id',
        'user_id_by_app',
        'phone',
        'address',
        'extend'
    ];
}
