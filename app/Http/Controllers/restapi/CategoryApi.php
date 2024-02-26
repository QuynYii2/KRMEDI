<?php

namespace App\Http\Controllers\restapi;

use App\Enums\CategoryStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryApi extends Controller
{
    public function getAll()
    {
        $categories = Category::where('status', CategoryStatus::ACTIVE)->get();
        return response()->json($categories);
    }

    public function getAllByUser($id)
    {
        $categories = Category::where('status', CategoryStatus::ACTIVE)->where('user_id', $id)->get();
        return response()->json($categories);
    }

    public function detail($id)
    {
        $category = Category::find($id);
        if (!$category || $category->status != CategoryStatus::ACTIVE) {
            return response('Not found', 404);
        }
        return response()->json($category);
    }
}
