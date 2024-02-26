<?php

namespace App\Http\Controllers\restapi;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\AnswerLike;
use App\Models\User;
use Illuminate\Http\Request;

class AnswerLikeApi extends Controller
{
    public function handleLikeOrDislike(Request $request)
    {
        try {
            $user_id = $request->input('user_id');
            $answer_id = $request->input('answer_id');

            $answer = Answer::find($answer_id);
            if (!$answer) {
                return response()->json((new MainApi())->returnMessage('Answer not found!'), 404);
            }
            $userCheck = User::find($user_id);
            if (!$userCheck) {
                return response()->json((new MainApi())->returnMessage('User not found!'), 404);
            }

            $old = AnswerLike::where('user_id', $user_id)->where('answer_id', $answer_id)->first();
            if ($old) {
                if ($old->is_like == 1) {
                    $old->is_like = 0;

                    $answer->likes = $answer->likes - 1;

                } else {
                    $old->is_like = 1;
                    $answer->likes = $answer->likes + 1;
                }
            } else {
                $old = new AnswerLike();
                $old->is_like = 1;
                $old->user_id = $user_id;
                $old->answer_id = $answer_id;
                $answer->likes = $answer->likes + 1;
            }
            $success = $old->save();
            $answer->save();
            if ($success) {
                return response()->json([
                    'message' => 'Success!',
                    'data' => $answer->likes,
                ], 200);
            }
            return response()->json((new MainApi())->returnMessage('Error!'), 400);
        } catch (\Exception $exception) {
            return response()->json((new MainApi())->returnMessage('Error, please try again!'), 400);
        }
    }
}
