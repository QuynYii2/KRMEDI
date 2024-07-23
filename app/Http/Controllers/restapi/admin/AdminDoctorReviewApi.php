<?php

namespace App\Http\Controllers\restapi\admin;

use App\Enums\DoctorReviewStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\restapi\DoctorReviewApi;
use App\Http\Controllers\restapi\MainApi;
use App\Models\DoctorReview;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDoctorReviewApi extends Controller
{
    public function getList(Request $request)
    {
        $reviewDoctor = DoctorReview::where('status', '!=', DoctorReviewStatus::DELETED)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($reviewDoctor);
    }

    public function detail(Request $request, $id)
    {
        $reviewDoctor = DoctorReview::find($id);
        if (!$reviewDoctor || $reviewDoctor->status != DoctorReviewStatus::DELETED) {
            return response('Not found', 404);
        }
        return response()->json($reviewDoctor);
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $reviewDoctor = DoctorReview::find($id);
            if (!$reviewDoctor || $reviewDoctor->status == DoctorReviewStatus::DELETED) {
                return response('Not found', 404);
            }

            $status = $request->input('status');
            if (!$status) {
                $status = DoctorReviewStatus::PENDING;
            }

            $reviewDoctor->status = $status;
            $success = $reviewDoctor->save();
            (new DoctorReviewApi())->calcReview($reviewDoctor);
            if ($success) {
                $user = User::find($reviewDoctor->created_by);
                if ($status == 'APPROVED'){
                    $userNotification = Notification::create([
                        'title' => 'Đánh giá bác sĩ',
                        'sender_id' => $user->id,
                        'follower' => $user->id,
                        'description' => 'Đánh giá bác sĩ của bạn đã được duyệt. Vui lòng đến kiểm tra!',
                    ]);
                    $mainApi = new MainApi();
                    $mainApi->sendQuestionNotification($user->token_firebase,$userNotification->id);
                }
                if ($status == 'REFUSE'){
                    $userNotification = Notification::create([
                        'title' => 'Đánh giá bác sĩ',
                        'sender_id' => $user->id,
                        'follower' => $user->id,
                        'description' => 'Đánh giá bác sĩ của bạn đã bị từ chối',
                    ]);
                    $mainApi = new MainApi();
                    $mainApi->sendQuestionNotification($user->token_firebase,$userNotification->id);
                }
                return response()->json($reviewDoctor);
            }
            return response('Update error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $reviewDoctor = DoctorReview::find($id);
            if (!$reviewDoctor || $reviewDoctor->status == DoctorReviewStatus::DELETED) {
                return response('Not found', 404);
            }

            $reviewDoctor->status = DoctorReviewStatus::DELETED;
            (new DoctorReviewApi())->calcReview($reviewDoctor);
            $success = $reviewDoctor->save();
            if ($success) {
                return response('Delete success!', 200);
            }
            return response('Delete error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }
}
