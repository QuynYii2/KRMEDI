<?php

namespace App\Http\Controllers\backend;

use App\Enums\AnswerStatus;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;

class BackendAnswerController extends Controller
{
    public function getAll(Request $request)
    {
        $status = $request->input('status');
        if (!$status) {
            $answers = Answer::where('status', '!=', AnswerStatus::DELETED)
                ->orderByDesc('likes')
                ->get();
        } else {
            $answers = Answer::where('status', $status)
                ->orderByDesc('likes')
                ->get();
        }
        return response()->json($answers);
    }

    public function getAllByQuestion($id, Request $request)
    {
        $status = $request->input('status');
        if (!$status) {
            $answers = Answer::where('status', '!=', AnswerStatus::DELETED)
                ->where('question_id', $id)
                ->orderByDesc('likes')
                ->get();
        } else {
            $answers = Answer::where('status', $status)
                ->orderByDesc('likes')
                ->where('question_id', $id)
                ->get();
        }
        return response()->json($answers);
    }

    public function getAllByAnswer($id, Request $request)
    {
        $status = $request->input('status');
        if (!$status) {
            $answers = Answer::where('status', '!=', AnswerStatus::DELETED)
                ->where('answer_parent', $id)
                ->orderByDesc('likes')
                ->get();
        } else {
            $answers = Answer::where('status', $status)
                ->where('question_id', $id)
                ->orderByDesc('likes')
                ->get();
        }
        return response()->json($answers);
    }

    public function create(Request $request)
    {
        try {
            $answer = new Answer();

            $content = $request->input('content');
            $content_en = $request->input('content_en');
            $content_laos = $request->input('content_laos');
            $pings = $request->input('pings');
            $user_id = $request->input('user_id');
            $status = $request->input('status');

            if (!$status) {
                $status = AnswerStatus::PENDING;
            }

            $name = $request->input('name');

            $question_id = $request->input('question_id');
            $answer_parent = $request->input('answer_parent');
            if ($answer_parent) {
                $answer->answer_parent = $answer_parent;
            }

            $question = null;
            if ($question_id) {
                $answer->question_id = $question_id;
                $question = Question::find($question_id);
            } else {
                if ($answer->answer_parent) {
                    $parent_answer = Answer::find($answer->answer_parent);
                    $question = Question::find($parent_answer->question_id);
                }
            }

            if ($question) {
                $question->score = $question->score + 1;
                $question->save();
            }


            if ($name) {
                $answer->name = $name;
            } else {
                $user = User::find($user_id);
                if (!$user) {
                    return response('User not found!', 404);
                }
                $answer->name = $user->username;
            }

            $answer->content = $content;
            $answer->content_en = $content_en;
            $answer->content_laos = $content_laos;
            $answer->pings = $pings;
            $answer->user_id = $user_id;
            $answer->status = $status;

            $answer->id = $this->getMaxID();

            $success = $answer->save();
            if ($success) {
                return response()->json($answer);
            }
            return response('Create question error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function getMaxID()
    {
        $questionID = Question::max('id') + 1;
        $answerID = Answer::max('id') + 1;

        return $questionID > $answerID ? $questionID : $answerID;
    }

    public function detail($id)
    {
        $answer = Answer::find($id);
        if (!$answer || $answer->status == AnswerStatus::DELETED) {
            return response('Not found', 404);
        }

        return response()->json($answer);
    }

    public function changeStatus($id, Request $request)
    {
        try {
            $answer = Answer::find($id);
            if (!$answer || $answer->status == AnswerStatus::DELETED) {
                return response('Not found', 404);
            }
            $status = $request->input('status');
            if (!$status) {
                $status = AnswerStatus::APPROVED;
            }
            $answer->status = $status;
            $success = $answer->save();
            if ($success) {
                return response()->json($answer);
            }
            return response('Create question error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $answer = Answer::find($id);

            if (!$answer || $answer->status == AnswerStatus::DELETED) {
                return response('Not found', 404);
            }
            $content = $request->input('content');
            $content_en = $request->input('content_en');
            $content_laos = $request->input('content_laos');
            $pings = $request->input('pings');
            $user_id = $request->input('user_id');
            $status = $request->input('status');

            $question_id = $request->input('question_id');
            $answer_parent = $request->input('answer_parent');
            if ($answer_parent) {
                $answer->answer_parent = $answer_parent;
            }

            if ($question_id) {
                $answer->question_id = $question_id;
            }

            $user = User::find($user_id);
            if (!$user) {
                return response('User not found!', 404);
            }

            $answer->name = $user->username;

            $answer->content = $content;
            $answer->content_en = $content_en;
            $answer->content_laos = $content_laos;
            $answer->pings = $pings;
            $answer->user_id = $user_id;
            $answer->status = $status;

            $success = $answer->save();
            if ($success) {
                return response()->json($answer);
            }
            return response('Create question error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function getAnswerLikeOrDislike()
    {

    }

    public function delete($id)
    {
        try {
            $answer = Answer::find($id);
            if (!$answer || $answer->status == AnswerStatus::DELETED) {
                return response('Not found', 404);
            }
            $answer->status = AnswerStatus::DELETED;
            $success = $answer->save();
            if ($success) {
                return response()->json($answer);
            }
            return response('Delete question error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }
}
