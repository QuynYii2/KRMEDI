<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewStore extends Model
{
    use HasFactory;

    protected $fillable = [
        'content', 'content_en', 'content_laos', 'status','user_id','store_id'
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

}
