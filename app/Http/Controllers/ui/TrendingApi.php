<?php

namespace App\Http\Controllers\ui;

use App\Enums\DepartmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Question;
use Illuminate\Http\Request;

class TrendingApi extends Controller
{
    public function listDepartment(Request $request)
    {
        $departments = Department::where('status', DepartmentStatus::ACTIVE)
            ->orderByDesc('score')
            ->get();
        return response()->json($departments);
    }

    public function listTopicQuestion(Request $request)
    {
        $question_categories = Question::where('status', '!=', DepartmentStatus::DELETED)
            ->orderByDesc('score')
            ->pluck('category_id');

        $array_categories = $question_categories->toArray();
        $new_array_categories = $this->removeArray($array_categories);

        $all_categories = $this->getEnum();
        $my_categories = $this->handleArray($all_categories, $new_array_categories);
        return response()->json($my_categories);
    }

    private function removeArray($arr)
    {
        $uniqueArr = [];
        foreach ($arr as $element) {
            if (!in_array($element, $uniqueArr)) {
                $uniqueArr[] = $element;
            }
        }
        return $uniqueArr;
    }

    private function getEnum()
    {
        return [
            'HEALTH' => '1',
            'BEAUTY' => '2',
            'LOSING_WEIGHT' => '3',
            'KIDS' => '4',
            'PETS' => '5',
            'OTHER' => '6',
        ];
    }

    private function handleArray($categories, $selectedValues)
    {
        $selectedCategories = [];

        foreach ($selectedValues as $value) {
            foreach ($categories as $key => $categoryId) {
                if ($value == $categoryId) {
                    $selectedCategories[] = $key;
                    break;
                }
            }
        }
        return $selectedCategories;
    }

    private function sortArray($array)
    {
        $count = array_count_values($array);
        arsort($count);
        $result = array_keys($count);
        return $result;
    }
}
