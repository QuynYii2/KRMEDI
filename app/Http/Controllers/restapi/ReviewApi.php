<?php

namespace App\Http\Controllers\restapi;

use App\Enums\ClinicStatus;
use App\Enums\ReviewStatus;
use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewApi extends Controller
{
    public function getAll()
    {
        $reviews = Review::where('status', ReviewStatus::APPROVED)->get();
        return response()->json($reviews);
    }

    public function getAllByClinicId($id, Request $request)
    {
        $reviews = DB::table('reviews')
            ->where('status', ReviewStatus::APPROVED)
            ->where('clinic_id', $id)
            ->where('user_id', 0)
            ->orderByDesc('id')
            ->get();

        $review_users = DB::table('reviews')
            ->where('reviews.status', ReviewStatus::APPROVED)
            ->where('reviews.clinic_id', $id)
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->select('reviews.*', 'users.points')
            ->orderByDesc('reviews.id')
            ->get();

        $mergedCollection = $reviews->merge($review_users);
        $mergedCollection->sortByDesc('id');
        return response()->json($mergedCollection);
    }

    public function detail($id)
    {
        $review = Review::find($id);
        if (!$review || $review->status != ReviewStatus::APPROVED) {
            return response('Not found', 404);
        }

        return response()->json($review);
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
            $star = $request->input('star');
            $content = $request->input('content');
            $userID = $request->input('user_id');

            $clinic = Clinic::find($clinic_id);
            if (!$clinic || $clinic->status != ClinicStatus::ACTIVE) {
                return response('Clinics not found!', 400);
            }

            if (!$userID) {
                $userID = 0;
            }

            $review->name = $name;
            $review->address = $address;
            $review->phone = $phone;
            $review->email = $email;
            $review->clinic_id = $clinic_id;
            $review->user_id = $userID;
            $review->star = $star;
            $review->content = $content;
            $review->status = ReviewStatus::APPROVED;

            $success = $review->save();

            $listReview = Review::where('clinic_id', $clinic_id)
                ->where('status', ReviewStatus::APPROVED)
                ->get();

            $totalReview = $listReview->count();
            $totalStar = $listReview->sum('star');
            $calcReview = ($totalReview > 0) ? ($totalStar / $totalReview) : 0;
            $clinic->average_star = $calcReview;
            $clinic->save();

            if ($success) {
                $user = User::find($userID);
                if ($user) {
                    $user->points = $user->points + 1;
                    $user->save();
                }
                return response()->json($review);
            }
            return response('Create review error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }
}
