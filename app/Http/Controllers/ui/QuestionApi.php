<?php

namespace App\Http\Controllers\ui;

use App\Enums\QuestionStatus;
use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionApi extends Controller
{
    public function getAllByTopics(Request $request)
    {
        $topic = $request->input('topic');
        switch ($topic) {
            case 'HEALTH':
                $value = 1;
                break;
            case 'BEAUTY':
                $value = 2;
                break;
            case 'LOSING_WEIGHT':
                $value = 3;
                break;
            case 'KIDS':
                $value = 4;
                break;
            case 'PETS':
                $value = 5;
                break;
            default :
                $value = 6;
                break;

        }
        $questions = Question::where('category_id', $value)
            ->where('status', '!=', QuestionStatus::DELETED)
            ->orderByDesc('score')
            ->get();

        return response()->json($questions);
    }
}
