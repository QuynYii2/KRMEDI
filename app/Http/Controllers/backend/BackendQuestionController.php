<?php

namespace App\Http\Controllers\backend;

use App\Enums\AnswerStatus;
use App\Enums\MentoringCategory;
use App\Enums\QuestionStatus;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\AnswerLike;
use App\Models\CalcViewQuestion;
use App\Models\Question;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BackendQuestionController extends Controller
{
    public function getAll(Request $request)
    {
        $status = $request->input('status');
        if ($status) {
            $questions = Question::where('status', $status)->get();
        } else {
            $questions = Question::where('status', '!=', QuestionStatus::DELETED)->get();
        }
        return response()->json($questions);
    }

    public function detail($id, Request $request)
    {
        $user_id = $request->input('user_id');
        $statusQuestion = Question::find($id);
        $question = CalcViewQuestion::getViewQuestion($id);

        $answersQuestion = DB::table('answers')
            ->where('status', '!=', AnswerStatus::DELETED)
            ->where('question_id', $id)
            ->orderByDesc('likes')
            ->cursor()
            ->map(function ($item) use ($user_id) {
                $like_answer = AnswerLike::where('answer_id', $item->id)
                    ->where('is_like', 1)
                    ->where('user_id', $user_id)
                    ->first();

                $like = false;

                if ($like_answer) {
                    $like = true;
                }
                $answer = (array)$item;
                $answer['is_likes'] = $like;
                return $answer;
            });

        if ($statusQuestion->status == QuestionStatus::DELETED) {
            return response('Not found', 404);
        }

        if ($question === null) {
            $question = new CalcViewQuestion();
            $question->views = 1;
            $question->question_id = $id;
        } else {
            $question->views = $question->views + 1;
        }
        $question->save();

        $responseData = [
            'statusQuestion' => $statusQuestion,
            'question' => $question,
            'answers' => $answersQuestion,
        ];
        return response()->json($responseData);
    }

    public function create(Request $request)
    {
        try {
            $question = new Question();

            $title = $request->input('title');
            $title_en = $request->input('title_en');
            $title_laos = $request->input('title_laos');
            $content = $request->input('content');
            $content_en = $request->input('content_en');
            $content_laos = $request->input('content_laos');
            $user_id = $request->input('user_id');
            $category_id = $request->input('category_id');
            $status = $request->input('status');

            $list_image = $request->input('list_public');

            $question->title = $title;
            $question->title_en = $title_en;
            $question->title_laos = $title_laos;
            $question->content = $content;
            $question->content_en = $content_en;
            $question->content_laos = $content_laos;
            $question->category_id = $category_id;
            $question->user_id = $user_id;
            $question->status = $status;

            if ($request->hasFile('gallery')) {
                $galleryPaths = array_map(function ($image) {
                    $itemPath = $image->store('gallery', 'public');
                    return asset('storage/' . $itemPath);
                }, $request->file('gallery'));
                $gallery = implode(',', $galleryPaths);
            } else {
                $gallery = '';
            }
            $user = User::find($user_id);
            if (!$user) {
                return response('User not found!', 404);
            }

            $arrayGalleries = explode(',', $gallery);
            $arrayPublic = explode(',', $list_image);


            if ($list_image) {
                $itemPublic = null;
                foreach ($arrayPublic as $quantity) {
                    $itemPublic[] = $arrayGalleries[$quantity];
                }
            } else {
                $itemPublic[] = '';
            }

            foreach ($arrayPublic as $index) {
                if (isset($arrayGalleries[$index])) {
                    unset($arrayGalleries[$index]);
                }
            }

            $itemPrivate = array_values($arrayGalleries);

            $question->name = $user->username;
            $question->id = $this->getMaxID();
            $question->gallery = implode(',', $itemPrivate);
            $question->gallery_public = implode(',', $itemPublic);

            $success = $question->save();
            if ($success) {
                return response()->json($question);
            }
            return response('Create question error!', 400);
        } catch (Exception $exception) {
            return response($exception, 400);
        }
    }

    public function getMaxID()
    {
        $questionID = Question::max('id') + 1;
        $answerID = Answer::max('id') + 1;

        return $questionID > $answerID ? $questionID : $answerID;
    }

    public function getAllByUserId(Request $request, $id)
    {
        $status = $request->input('status');
        if ($status && $status != QuestionStatus::DELETED) {
            $clinics = Question::where([
                ['status', $status],
                ['user_id', $id]
            ])->get();
        } else {
            $clinics = Question::where([
                ['status', '!=', QuestionStatus::DELETED],
                ['user_id', $id]
            ])->get();
        }
        return response()->json($clinics);
    }

    public function upgradeStatus($id, Request $request)
    {
        try {
            $question = Question::find($id);
            if (!$question || $question->status == QuestionStatus::DELETED) {
                return response('Not found', 404);
            }

            $status = $request->input('status');
            if (!$status) {
                $status = QuestionStatus::APPROVED;
            }
            $question->status = $status;
            $success = $question->save();
            if ($success) {
                return response('Update success!', 200);
            }
            return response('Update question error!', 400);
        } catch (Exception $exception) {
            return response($exception, 400);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $question = Question::find($id);
            if (!$question || $question->status == QuestionStatus::DELETED) {
                return response('Not found', 404);
            }

            $content = $request->input('content');
            $content_en = $request->input('content_en');
            $content_laos = $request->input('content_laos');
            $user_id = $request->input('user_id');
            $category_id = $request->input('category_id');
            $status = $request->input('status');

            $question->content = $content;
            $question->content_en = $content_en;
            $question->content_laos = $content_laos;
            $question->user_id = $user_id;
            $question->category_id = $category_id;
            $question->status = $status;

            $success = $question->save();
            if ($success) {
                return response()->json($question);
            }
            return response('Create question error!', 400);
        } catch (Exception $exception) {
            return response($exception, 400);
        }
    }

    public function delete($id)
    {
        try {
            $question = Question::find($id);
            if (!$question || $question->status == QuestionStatus::DELETED) {
                return response('Not found', 404);
            }
            $question->status = QuestionStatus::DELETED;
            $success = $question->save();
            if ($success) {
                return response('Delete success!', 200);
            }
            return response('Delete q   uestion error!', 400);
        } catch (Exception $exception) {
            return response($exception, 400);
        }
    }


    public function custom_getlist()
    {
        $list = [];

        $listQuestion = Question::where('status', QuestionStatus::APPROVED)->get();

        foreach ($listQuestion as $question) {

            $listAnswer = Answer::where('question_id', $question->id)->get();
            $question_id = $question->id;
            $item = [
                'id' => $question_id,
                'parent' => null,
                'content' => $question->content,
                'content_en' => $question->content_en,
                'content_laos' => $question->content_laos,
                'pings' => null,
                'attachments' => '',
                'creator' => $question->user_id,
                'created' => $question->created_at,
                'modified' => $question->updated_at,
                'fullname' => User::getNameByID($question->user_id),
                'comment_count' => $listAnswer->count(),
                'view_count' => CalcViewQuestion::getViewQuestion($question_id)->views ?? 0,
                'profile_picture_url' => 'https://viima-app.s3.amazonaws.com/media/public/defaults/user-icon.png',
            ];

            array_push($list, $item);

            foreach ($listAnswer as $answer) {
                $item = [
                    'id' => $answer->id,
                    'parent' => $question->id,
                    'content' => $answer->content,
                    'content_en' => $answer->content_en,
                    'content_laos' => $answer->content_laos,
                    'pings' => null,
                    'attachments' => '',
                    'creator' => $answer->user_id,
                    'created' => $answer->created_at,
                    'modified' => $answer->updated_at,
                    'fullname' => $answer->user_id ? User::getNameByID($answer->user_id) : $answer->name,
                    'profile_picture_url' => 'https://viima-app.s3.amazonaws.com/media/public/defaults/user-icon.png',
                ];
                array_push($list, $item);
            }
        }

        return response()->json($list);
    }

    public function getListQuestion($id)
    {
        $query = [];

        $param = ['status', '=', QuestionStatus::APPROVED];
        array_push($query, $param);

        if ($id) {
            switch ($id) {
                case MentoringCategory::ALL:
                    break;
                case MentoringCategory::HEALTH:
                case MentoringCategory::BEAUTY:
                case MentoringCategory::LOSING_WEIGHT:
                case MentoringCategory::KIDS:
                case MentoringCategory::PETS:
                case MentoringCategory::OTHER:
                    $param = ['category_id', '=', $id];
                    array_push($query, $param);
                    break;
            }
        }

        $questions = Question::where($query)->get();
        $list = [];
        foreach ($questions as $question) {

            $listAnswer = Answer::where('question_id', $question->id)->get();
            $question_id = $question->id;
            $item = [
                'id' => $question_id,
                'parent' => null,
                'title' => $question->title,
                'title_en' => $question->title_en,
                'title_laos' => $question->title_laos,
                'content' => $question->content,
                'content_en' => $question->content_en,
                'content_laos' => $question->content_laos,
                'pings' => null,
                'attachments' => '',
                'creator' => $question->user_id,
                'created' => $question->created_at,
                'modified' => $question->updated_at,
                'fullname' => User::getNameByID($question->user_id),
                'comment_count' => $listAnswer->count(),
                'view_count' => CalcViewQuestion::getViewQuestion($question_id)->views ?? 0,
                'profile_picture_url' => 'https://viima-app.s3.amazonaws.com/media/public/defaults/user-icon.png',
            ];

            array_push($list, $item);

        }

        return response()->json($list);
    }

    public function getQuestionByUserId($id)
    {
        $query = [];

        $param = ['status', '=', QuestionStatus::APPROVED];
        array_push($query, $param);

        if (Auth::user()) {
            $param = ['user_id', '=', $id];
            array_push($query, $param);
        }

        $questions = Question::where($query)->get();
        $list = [];
        foreach ($questions as $question) {

            $listAnswer = Answer::where('question_id', $question->id)->get();
            $question_id = $question->id;
            $item = [
                'id' => $question_id,
                'parent' => null,
                'title' => $question->title,
                'title_en' => $question->title_en,
                'title_laos' => $question->title_laos,
                'content' => $question->content,
                'content_en' => $question->content_en,
                'content_laos' => $question->content_laos,
                'pings' => null,
                'attachments' => '',
                'creator' => $question->user_id,
                'created' => $question->created_at,
                'modified' => $question->updated_at,
                'fullname' => User::getNameByID($question->user_id),
                'comment_count' => $listAnswer->count(),
                'view_count' => CalcViewQuestion::getViewQuestion($question_id)->views ?? 0,
                'profile_picture_url' => 'https://viima-app.s3.amazonaws.com/media/public/defaults/user-icon.png',
            ];

            array_push($list, $item);

        }

        return response()->json($list);
    }

    public function getQuestionByUserIdAndCategoryId($userId, $categoryId)
    {
        if ($categoryId == 0) {
            $questions = Question::where(
                [
                    'status' => QuestionStatus::APPROVED,
                    'user_id' => $userId,
                ])->get();
        } else {
            $questions = Question::where(
                [
                    'status' => QuestionStatus::APPROVED,
                    'user_id' => $userId,
                    'category_id' => $categoryId
                ]
            )->get();
        }

        $list = [];
        foreach ($questions as $question) {

            $listAnswer = Answer::where('question_id', $question->id)->get();
            $question_id = $question->id;
            $item = [
                'id' => $question_id,
                'parent' => null,
                'title' => $question->title,
                'title_en' => $question->title_en,
                'title_laos' => $question->title_laos,
                'content' => $question->content,
                'content_en' => $question->content_en,
                'content_laos' => $question->content_laos,
                'pings' => null,
                'attachments' => '',
                'creator' => $question->user_id,
                'created' => $question->created_at,
                'modified' => $question->updated_at,
                'fullname' => User::getNameByID($question->user_id),
                'comment_count' => $listAnswer->count(),
                'view_count' => CalcViewQuestion::getViewQuestion($question_id)->views ?? 0,
                'profile_picture_url' => 'https://viima-app.s3.amazonaws.com/media/public/defaults/user-icon.png',
            ];

            array_push($list, $item);

        }

        return response()->json($list);
    }
}
