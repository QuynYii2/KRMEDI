<?php

namespace App\Http\Controllers;

use App\Models\QuestionLikes;

class QuestionLikesController extends Controller
{
    public function checkEmotion($questionId, $userId)
    {
        $emotion = QuestionLikes::where('question_id', $questionId)
            ->where('user_id', $userId)
            ->first();
        if ($emotion) {
            return $emotion->emotion;
        }
        return false;
    }

    public function changeEmotion($questionId, $userId)
    {
        $emotion = QuestionLikes::where('question_id', $questionId)
            ->where('user_id', $userId)
            ->first();
        if (!$emotion) {
            $emotion = new QuestionLikes();
            $emotion->question_id = $questionId;
            $emotion->user_id = $userId;
            $emotion->is_like = true;
        } else {
            $emotion->is_like = !$emotion->is_like;
        }
        $emotion->save();

        return $emotion;
    }
}
