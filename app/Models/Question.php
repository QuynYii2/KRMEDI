<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'content', 'content_en', 'content_laos', 'status','user_id',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

}
