<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportmentoringModel extends Model
{
    use HasFactory;
    protected $table = 'report_mentoring';
    protected $fillable = [
        'question_id',
        'user_id',
        'content'
    ];
}
