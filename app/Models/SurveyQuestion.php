<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'question',
        'question_en',
        'question_laos',
        'department_id',
        'type',
    ];

    // 1 - n with survey_answers
    public function survey_answers()
    {
        return $this->hasMany(SurveyAnswer::class, 'survey_question_id', 'id');
    }
}
