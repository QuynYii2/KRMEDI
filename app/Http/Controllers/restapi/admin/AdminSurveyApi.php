<?php

namespace App\Http\Controllers\restapi\admin;

use App\Enums\DepartmentStatus;
use App\Enums\SurveyStatus;
use App\Enums\SurveyType;
use App\Http\Controllers\Controller;
use App\Http\Controllers\restapi\MainApi;
use App\Http\Controllers\restapi\SurveyApi;
use App\Http\Controllers\TranslateController;
use App\Models\Department;
use App\Models\SurveyAnswer;
use App\Models\SurveyAnswerUser;
use App\Models\SurveyQuestion;
use App\Models\Surveys;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminSurveyApi extends Controller
{
    public function getAll(Request $request)
    {
        $status = $request->input('status');
        if ($status) {
            $surveys = Surveys::orderBy('id', 'desc')->where('status', $status)->get();
        } else {
            $surveys = Surveys::orderBy('id', 'desc')->where('status', '!=', SurveyStatus::DELETED)->get();
        }
        return response()->json($surveys);
    }

    public function getAllByDepartment($id, Request $request)
    {
        $status = $request->input('status');
        $surveys = DB::table('surveys')->where('department_id', $id)->orderBy('id', 'desc')->when($status,
            function ($query) use ($status) {
                $query->where('status', $status);
            })->where('status', '!=', SurveyStatus::DELETED)->cursor()->map(function ($item) {
            $survey = (array)$item;
            $answerFormat = (new SurveyApi())->checkTypeSurvey($item->type, $item->answer);
            $survey['answerFormat'] = $answerFormat;
            return $survey;
        });

        return response()->json($surveys);
    }

    public function detail($id)
    {
        $survey = Surveys::find($id);
        if (!$survey || $survey->status == SurveyStatus::DELETED) {
            return response((new MainApi())->returnMessage('Not found!'), 404);
        }
        return response()->json($survey);
    }

    public function create(Request $request)
    {

        try {
            $survey = new SurveyQuestion();

            $params = $request->only('question', 'department_id', 'type');

            $translate = new TranslateController();
            $params['question_en'] = $translate->translateText($params['question'], 'en');
            $params['question_laos'] = $translate->translateText($params['question'], 'lo');

            $department = Department::find($params['department_id']);
            if (!$department || $department->status == DepartmentStatus::DELETED) {
                return response((new MainApi())->returnMessage('Department not found!'), 400);
            }

            $survey->fill($params);
            $result = $survey->save();

            if (!$result) {
                return response((new MainApi())->returnMessage('Create error, Please try again!!!'), 400);
            }

            if ($params['type'] == SurveyType::TEXT) {
                return response()->json($survey);
            }

            $surveyId = $survey->id;

            $symbol = '@#!';

            $arrAnswer_vi = explode($symbol, $request->input('answer_vi'));
            $arrAnswer_en = explode($symbol, $request->input('answer_en'));
            $arrAnswer_laos = explode($symbol, $request->input('answer_laos'));

            for ($i = 0; $i < count($arrAnswer_vi); $i++) {
                $answer = new SurveyAnswer();
                $answer->survey_question_id = $surveyId;
                $answer->answer = $arrAnswer_vi[$i];
                $answer->answer_en = $arrAnswer_en[$i];
                $answer->answer_laos = $arrAnswer_laos[$i];
                $answer->save();
            }

            return response()->json($survey);
        } catch (Exception $exception) {
            return response((new MainApi())->returnMessage('Create error, Please try again!!!'), 400);
        }

    }

    public function update($id, Request $request)
    {

        try {
            $survey = SurveyQuestion::find($id);

            $params = $request->only('question', 'department_id', 'type');

            $translate = new TranslateController();
            $params['question_en'] = $translate->translateText($params['question'], 'en');
            $params['question_laos'] = $translate->translateText($params['question'], 'lo');

            $department = Department::find($params['department_id']);
            if (!$department || $department->status == DepartmentStatus::DELETED) {
                return response((new MainApi())->returnMessage('Department not found!'), 400);
            }

            $survey->fill($params);
            $result = $survey->save();

            if (!$result) {
                return response((new MainApi())->returnMessage('Create error, Please try again!!!'), 400);
            }

            $surveyId = $survey->id;

            $arrayAnswerID = explode(',', $request->input('arrayAnswerId'));

            if ($params['type'] == SurveyType::TEXT) {
                SurveyAnswer::where('survey_question_id', $surveyId)->delete();
                return response()->json($survey);
            }

            $symbol = '@#!';

            $arrAnswer_vi = explode($symbol, $request->input('answer_vi'));
            $arrAnswer_en = explode($symbol, $request->input('answer_en'));
            $arrAnswer_laos = explode($symbol, $request->input('answer_laos'));

            for ($i = 0; $i < count($arrAnswer_vi); $i++) {
                if ($arrAnswer_vi[$i] == '' || $arrAnswer_en[$i] == '' || $arrAnswer_laos[$i] == '') {
                    continue;
                }

                if (array_key_exists($i, $arrayAnswerID) && $arrayAnswerID[$i]) {
                    $answer = SurveyAnswer::find($arrayAnswerID[$i]);
                } else {
                    $answer = new SurveyAnswer();
                }

                $answer->survey_question_id = $surveyId;
                $answer->answer = $arrAnswer_vi[$i];
                $answer->answer_en = $arrAnswer_en[$i];
                $answer->answer_laos = $arrAnswer_laos[$i];
                $answer->save();
            }

            return response()->json($survey);
        } catch (Exception $exception) {
            return response((new MainApi())->returnMessage('Create error, Please try again!!!'), 400);
        }
    }

    public function delete($id)
    {
        try {
            $survey = SurveyQuestion::find($id)->delete();
            SurveyAnswer::where('survey_question_id', $id)->delete();

            return response((new MainApi())->returnMessage('Delete success!'), 200);
        } catch (Exception $exception) {
            return response((new MainApi())->returnMessage('Delete error, Please try again!!!'), 400);
        }
    }

    public function handleFormSurvey(Request $request)
    {
        foreach ($request->all() as $value) {
            if (!array_key_exists('booking_id', $value)) {
                return response((new MainApi())->returnMessage('Không có booking id!!!'), 400);
            }
            if (!array_key_exists('user_id', $value)) {
                continue;
            }
            if (!array_key_exists('result', $value)) {
                continue;
            }
            $survey_answer = new SurveyAnswerUser();
            $survey_answer->result = $value['result'];
            $survey_answer->user_id = $value['user_id'];
            $survey_answer->booking_id = $value['booking_id'];
            $survey_answer->save();
        }
        return response((new MainApi())->returnMessage('Success!!!'), 200);
    }
}
