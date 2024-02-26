<?php

namespace App\Http\Controllers\restapi;

use App\Enums\SurveyStatus;
use App\Http\Controllers\Controller;
use App\Models\Surveys;
use Illuminate\Support\Facades\DB;

class SurveyApi extends Controller
{
    public function getAllByDepartment($id)
    {
        $surveys = DB::table('surveys')
            ->where('department_id', $id)
            ->where('status', SurveyStatus::ACTIVE)
            ->orderBy('id', 'desc')
            ->cursor()
            ->map(function ($item) {
                $survey = (array)$item;
                $answerFormat = $this->checkTypeSurvey($item->type, $item->answer);
                $survey['answerFormat'] = $answerFormat;
                return $survey;
            });
        return response()->json($surveys);
    }

    public function checkTypeSurvey($type, $answer)
    {
        $array_survey = ['type' => 'text', 'textChoices' => ''];

        switch ($type) {
            case 'MULTIPLE':
                $array_survey['type'] = 'multiple';
                $array_answer = explode(',', $answer);
                $list_answer = [];

                foreach ($array_answer as $item) {
                    $list_answer[] = ['key' => $item, 'value' => $item];
                }

                $array_survey['textChoices'] = $list_answer;
                break;

            case 'RADIO':
                $array_survey['type'] = 'radio';
                $array_answer = explode(',', $answer);
                $list_answer = [];

                foreach ($array_answer as $item) {
                    $list_answer[] = ['key' => $item, 'value' => $item];
                }

                $array_survey['textChoices'] = $list_answer;
                break;

            case 'BOOL':
                $array_survey['type'] = 'bool';
                $array_answer = ['Yes', 'No'];
                $list_answer = [];

                foreach ($array_answer as $item) {
                    $list_answer[] = ['key' => $item, 'value' => $item];
                }

                $array_survey['textChoices'] = $list_answer;
                break;
        }

        return $array_survey;
    }


    public function detail($id)
    {
        $survey = Surveys::find($id);
        if (!$survey || $survey->status != SurveyStatus::ACTIVE) {
            return response((new MainApi())->returnMessage('Not found!'), 400);
        }
        return response()->json($survey);
    }
}
