<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = array(
        'content', 'content_en', 'content_laos', 'status',
        'user_id', 'answer_parent', 'question_id',
    );
}
