<?php

namespace App\Http\Controllers;

use App\Enums\CategoryStatus;
use App\Models\Category;
use App\Models\Clinic;
use App\Models\Review;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.category.list');
    }

    public function create()
    {
        $reflector = new \ReflectionClass('App\Enums\CategoryStatus');
        $status = $reflector->getConstants();
        $categories = Category::where('status', CategoryStatus::ACTIVE)
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.category.create', compact('status', 'categories'));
    }

    public function detail($id)
    {
        $category = Category::find($id);
        $reflector = new \ReflectionClass('App\Enums\CategoryStatus');
        $status = $reflector->getConstants();
        $categories = Category::where('status', CategoryStatus::ACTIVE)
            ->where('id', '!=', $id)
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.category.detail', compact('category', 'status', 'categories'));
    }
}
