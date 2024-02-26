<?php

namespace App\Http\Controllers\backend;

use App\Enums\ReviewStatus;
use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\Review;
use DB;
use Illuminate\Http\Request;

class BackendReviewController extends Controller
{
    public function getAll(Request $request)
    {
        $status = $request->input('status');
        if (!$status) {
            $reviews = Review::where('status', '!=', ReviewStatus::DELETED)->get();
        } else {
            $reviews = Review::where('status', $status)->get();
        }
        return response()->json($reviews);
    }

    public function getAllByClinicId($id, Request $request)
    {
        $status = $request->input('status');
        if (!$status) {
            $reviews = Review::where('status', '!=', ReviewStatus::DELETED)->where('clinic_id', $id)->get();
        } else {
            $reviews = Review::where('status', $status)->where('clinic_id', $id)->get();
        }
        return response()->json($reviews);
    }

    public function getAllByUserId($id, Request $request)
    {
        $status = $request->input('status');
        if (!$status) {
            $reviews = Review::where('status', '!=', ReviewStatus::DELETED)->where('user_id', $id)->get();
        } else {
            $reviews = Review::where('status', $status)->where('user_id', $id)->get();
        }
        return response()->json($reviews);
    }

    public function getAllMainUser($id, Request $request)
    {
        $status = $request->input('status');
        if (!$status) {
            $reviews = DB::table('reviews')
                ->join('clinics', 'clinics.id', '=', 'reviews.clinic_id')
                ->where('clinics.user_id', $id)
                ->where('reviews.status', '!=', ReviewStatus::DELETED)
                ->select('reviews.*')
                ->get();
        } else {
            $reviews = DB::table('reviews')
                ->join('clinics', 'clinics.id', '=', 'reviews.clinic_id')
                ->where('products.user_id', $id)
                ->where('reviews.status', '=', $status)
                ->select('reviews.*')
                ->get();
        }
        return response()->json($reviews);
    }

    public function create(Request $request)
    {
        try {
            $review = new Review();

            $name = $request->input('name');
            $address = $request->input('address');
            $phone = $request->input('phone');
            $email = $request->input('email');
            $clinic_id = $request->input('clinic_id');
            $user_id = $request->input('user_id');
            $star = $request->input('star');
            $content = $request->input('content');

            $review->name = $name;
            $review->address = $address;
            $review->phone = $phone;
            $review->email = $email;
            $review->clinic_id = $clinic_id;
            $review->user_id = $user_id;
            $review->star = $star;
            $review->content = $content;
            $review->status = ReviewStatus::PENDING;

            $success = $review->save();
            if ($success) {
                return response()->json($review);
            }
            return response('Create review error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function detail($id)
    {
        $review = Review::find($id);
        if (!$review || $review->status == ReviewStatus::DELETED) {
            return response('Not found', 404);
        }

        return response()->json($review);
    }

    public function changeStatus($id, Request $request)
    {
        try {
            $review = Review::find($id);
            if (!$review || $review->status == ReviewStatus::DELETED) {
                return response('Not found', 404);
            }
            $status = $request->input('status');
            if (!$status) {
                $status = ReviewStatus::APPROVED;
            }
            $review->status = $status;
            $success = $review->save();
            $this->updateAverage($review->clinic_id);
            if ($success) {
                return response()->json($review);
            }
            return response('Create question error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $review = Review::find($id);

            if (!$review || $review->status == ReviewStatus::DELETED) {
                return response('Not found', 404);
            }

            $name = $request->input('name');
            $address = $request->input('address');
            $phone = $request->input('phone');
            $email = $request->input('email');
            $clinic_id = $request->input('clinic_id');
            $user_id = $request->input('user_id');
            $star = $request->input('star');
            $content = $request->input('content');
            $status = $request->input('status');

            $review->name = $name;
            $review->address = $address;
            $review->phone = $phone;
            $review->email = $email;
            $review->clinic_id = $clinic_id;
            $review->user_id = $user_id;
            $review->star = $star;
            $review->content = $content;
            $review->status = $status;

            $success = $review->save();
            if ($success) {
                return response()->json($review);
            }
            return response('Create review error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function delete($id)
    {
        try {
            $review = Review::find($id);
            if (!$review || $review->status == ReviewStatus::DELETED) {
                return response('Not found', 404);
            }
            $review->status = ReviewStatus::DELETED;
            $success = $review->save();

            $this->updateAverage($review->clinic_id);
            if ($success) {
                return response('Delete review success!', 200);
            }
            return response('Delete review error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    private function updateAverage($clinic_id)
    {
        $clinic = Clinic::find($clinic_id);
        $listReview = Review::where('clinic_id', $clinic_id)
            ->where('status', ReviewStatus::APPROVED)
            ->get();

        $totalReview = $listReview->count();
        $totalStar = $listReview->sum('star');
        $calcReview = ($totalReview > 0) ? ($totalStar / $totalReview) : 0;
        $clinic->average_star = $calcReview;
        $clinic->save();
    }
}
