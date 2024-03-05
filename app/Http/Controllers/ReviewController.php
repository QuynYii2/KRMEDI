<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        return view('admin.reviews.list');
    }

    public function detail($id)
    {
        $review = Review::find($id);
        $reflector = new \ReflectionClass('App\Enums\ReviewStatus');
        $status = $reflector->getConstants();
        $business = Clinic::find($review->clinic_id);
        return view('admin.reviews.detail', compact('review', 'status', 'business'));
    }
}
