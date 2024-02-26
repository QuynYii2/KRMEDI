<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalcViewQuestion extends Model
{
    use HasFactory;

    public static function getViewQuestion($id)
    {
        return CalcViewQuestion::where('question_id', $id)->first('views');
    }
}
