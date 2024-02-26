<?php

namespace App\Http\Controllers;

use App\Enums\DepartmentStatus;
use App\Models\Department;
use App\Models\SurveyQuestion;
use ReflectionClass;

class SurveyController extends Controller
{


    public function getList()
    {
        $surveys = SurveyQuestion::all();
        return view('admin.surveys.list', compact('surveys'));
    }

    public function detail($id)
    {
        $survey = SurveyQuestion::where('id', $id)->with('survey_answers')->first();

        if (!$survey) {
            alert()->error('Survey not found!');
            return back();
        }

        $departments = Department::where('status', '!=', DepartmentStatus::DELETED)
            ->orderBy('id', 'desc')
            ->get();

        $survey_answers = $survey->survey_answers;

        return view('admin.surveys.detail', compact('survey', 'survey_answers', 'departments'));
    }

    public function create()
    {
        $departments = Department::where('status', '!=', DepartmentStatus::DELETED)->orderBy('id', 'desc')->get();
        $reflector = new ReflectionClass('App\Enums\SurveyType');
        $types = $reflector->getConstants();
        return view('admin.surveys.create', compact('departments', 'types'));
    }


    public function getQuestionByDepartment($departmentId)
    {
        $questions = SurveyQuestion::where('department_id', $departmentId)
            ->orWhereIn('department_id', explode(',', $departmentId))
            ->with('survey_answers') // Eager load the survey_answers relationship
            ->get();
        return response()->json($questions);
    }


    public function getAnswerByUser($question_id, $user_id)
    {
        $answer = SurveyQuestion::where('id', $question_id)->with([
            'survey_answers' => function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            }
        ])->first();
        return response()->json($answer);
    }

}
