<?php

namespace App\Http\Controllers;

use App\Models\DoctorReview;
use App\Models\User;

class DoctorReviewController extends Controller
{
    public function index()
    {
        return view('admin.reviews-doctor.list');
    }

    public function detail($id)
    {
        $review = DoctorReview::find($id);
        $reflector = new \ReflectionClass('App\Enums\DoctorReviewStatus');
        $status = $reflector->getConstants();
        $medical = User::find($review->doctor_id);
        return view('admin.reviews-doctor.detail', compact('review', 'status', 'medical'));
    }
}
