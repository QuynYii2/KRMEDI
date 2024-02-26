<?php

namespace App\Http\Controllers\restapi\admin;

use App\Enums\BookingStatus;
use App\Enums\SurveyType;
use App\Http\Controllers\Controller;
use App\Http\Controllers\restapi\MainApi;
use App\Models\Booking;
use App\Models\SurveyAnswer;
use App\Models\SurveyAnswerUser;
use App\Models\SurveyQuestion;
use Illuminate\Http\Request;

class AdminBookingApi extends Controller
{
    public function getAll(Request $request)
    {
        $status = $request->input('status');
        if ($status) {
            $bookings = Booking::where('status', $status)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $bookings = Booking::where('status', '!=', BookingStatus::CANCEL)
                ->orderBy('id', 'desc')
                ->get();
        }
        return response()->json($bookings);
    }

    public function getAllByClinicId($id, Request $request)
    {
        $status = $request->input('status');
        if ($status) {
            $bookings = Booking::where('status', $status)
                ->where('clinic_id', $id)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $bookings = Booking::where('status', '!=', BookingStatus::DELETE)
                ->where('clinic_id', $id)
                ->orderBy('id', 'desc')
                ->get();
        }
        return response()->json($bookings);
    }

    public function getAllByUserId($id, Request $request)
    {
        $status = $request->input('status');
        if ($status) {
            $bookings = Booking::where('status', $status)
                ->where('user_id', $id)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $bookings = Booking::where('status', '!=', BookingStatus::DELETE)
                ->where('user_id', $id)
                ->orderBy('id', 'desc')
                ->get();
        }
        return response()->json($bookings);
    }

    public function detail($id)
    {
        $booking = Booking::find($id);
        if (!$booking || $booking->status == BookingStatus::DELETE) {
            return response('Not found!', 404);
        }
        return response()->json($booking);
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $booking = Booking::find($id);
            if (!$booking || $booking->status == BookingStatus::DELETE) {
                return response((new MainApi())->returnMessage('Booking not found'), 404);
            }
            $status = $request->input('status') ?? BookingStatus::CANCEL;
            $reason = $request->input('reason');

            $booking->status = $status;
            $booking->reason_cancel = $reason;
            $booking->save();
            return response((new MainApi())->returnMessage('Booking status updated successfully'), 200);

        } catch (\Exception $exception) {
            return response((new MainApi())->returnMessage('Error, Please try again!'), 400);
        }
    }

    public function delete($id)
    {
        try {
            $booking = Booking::find($id);
            if (!$booking || $booking->status == BookingStatus::DELETE) {
                return response('Not found!', 404);
            }

            if ($booking->status == BookingStatus::COMPLETE) {
                return response('Không thể xóa khi đã hoàn thành!', 400);
            }

            $booking->status = BookingStatus::DELETE;
            $success = $booking->save();
            if ($success) {
                return response()->json($booking);
            }
            return response('Error, Delete error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function getAllByDoctorID($id, Request $request)
    {
        $status = $request->input('status');
        if ($status) {
            $bookings = Booking::where('status', $status)
                ->where('doctor_id', $id)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $bookings = Booking::where('status', '!=', BookingStatus::DELETE)
                ->where('doctor_id', $id)
                ->orderBy('id', 'desc')
                ->get();
        }
        $arrayBookings = null;
        foreach ($bookings as $booking) {
            $arrayBooking = null;
            $arrayBooking = $booking->toArray();
            $arrayBooking['time_convert_checkin'] = date('Y-m-d H:i:s', strtotime($booking->check_in));

            $survey_answer_user = SurveyAnswerUser::where('booking_id', $booking->id)->get();

            $arrQuestion = [];

            foreach ($survey_answer_user as $survey_answer) {
                $surveyResult = $survey_answer->result;

                /* Tách chuỗi thành mảng sử dụng dấu '-' */
                $parts = explode('-', $surveyResult);

                /* Lấy idQuestion */
                $idQuestion = $parts[0];

                $question = SurveyQuestion::find($idQuestion);

                $typeQuestion = SurveyQuestion::find($idQuestion) ? SurveyQuestion::find($idQuestion)->type : '';

                if ($typeQuestion == SurveyType::TEXT) {
                    $pos = strpos($surveyResult, '-');
                    $answer = '';
                    if ($pos !== false) {
                        /* Nếu tìm thấy dấu "-", cắt bỏ phần đầu của chuỗi */
                        $result = substr($surveyResult, $pos + 1);

                        $answer = $result;
                        $question['answers'] = $answer;

                    }
                    array_push($arrQuestion, $question);
                } else {

                    /* Lấy phần còn lại của mảng, bắt đầu từ phần tử thứ hai */
                    $idAnswersArray = array_slice($parts, 1);

                    /* Chuyển mảng thành chuỗi nếu cần */
                    $idAnswers = implode(',', $idAnswersArray);
                    $idAnswers = explode(',', $idAnswers);

                    $answer = SurveyAnswer::whereIn('id', $idAnswers)->get();
                    $question['answers'] = $answer;
                    array_push($arrQuestion, $question);
                }
            }

            $arrayBooking['question'] = $arrQuestion;

            $arrayBookings[] = $arrayBooking;
        }
        return response()->json($arrayBookings);
    }
}
