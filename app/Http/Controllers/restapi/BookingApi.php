<?php

namespace App\Http\Controllers\restapi;

use App\Enums\BookingStatus;
use App\Enums\Role;
use App\Enums\SurveyType;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Clinic;
use App\Models\SurveyAnswer;
use App\Models\SurveyAnswerUser;
use App\Models\SurveyQuestion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingApi extends Controller
{
    public function createBooking(Request $request)
    {
        try {
            $booking = new Booking();
            $booking = (new ClinicController())->createBooking($request, $booking);

            $clinicID = $booking->clinic_id;
            $timestamp = $booking->check_in;
            $datetime = $timestamp->addMinutes(30);
            $familyId = $booking->member_family_id;
            $exitBooking = Booking::where('clinic_id', $clinicID)
                ->where('member_family_id', $familyId)
                ->where('check_in', '<', $datetime)
                ->where('status', BookingStatus::APPROVED)
                ->get();
            if (count($exitBooking) > 5) {
                $array = [
                    'message' => 'The pre-booking service has reached the allowed number! Please re-choose again!'
                ];
                return response($array, 400);
            }

            $clinic = Clinic::find($clinicID);
            if (!$clinic) {
                return response((new MainApi())->returnMessage('Not found!'), 404);
            }

            $user = User::find($booking->user_id);
            if (!$user || $user->type == 'MEDICAL' || $user->type == 'BUSINESS') {
                return response((new MainApi())->returnMessage('Not permission!'), 400);
            }

            $success = $booking->save();

            $department = $clinic->department;
            $array_department = explode(',', $department);
            $list_department = DB::table('departments')
                ->whereIn('id', $array_department)
                ->update(['score' => DB::raw('score + 2')]);
            if ($success) {
                $response = $booking->toArray();
                $response['time_convert_checkin'] = date('Y-m-d H:i:s', strtotime($booking->check_in));
                return response()->json($response);
            }
            return response('Create error', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function detail($id)
    {
        $booking = Booking::find($id);
        if (!$booking || $booking->status == BookingStatus::DELETE) {
            return response('Not found!', 404);
        }
        return response()->json($booking);
    }

    public function getAllBookingByUserId($id, $status, Request $request)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 400);
        }

        $business_role1 = \App\Models\Role::where('name', Role::HOSPITALS)->first();
        $business_role2 = \App\Models\Role::where('name', Role::PHARMACEUTICAL_COMPANIES)->first();
        $business_role3 = \App\Models\Role::where('name', Role::CLINICS)->first();
        $business_role4 = \App\Models\Role::where('name', Role::PHARMACIES)->first();
        $business_role5 = \App\Models\Role::where('name', Role::SPAS)->first();
        $business_role6 = \App\Models\Role::where('name', Role::OTHERS)->first();

        $array_id = [$business_role1->id,
            $business_role2->id,
            $business_role3->id,
            $business_role4->id,
            $business_role5->id,
            $business_role6->id,
        ];
        $role_user = DB::table('role_users')->whereIn('role_id', $array_id)->where('user_id', $id)->first();
        $arrayBookings = null;
        if ($role_user) {
            $clinic = Clinic::where('user_id', $id)->first();
            $bookings = Booking::where('clinic_id', $clinic->id)
                ->where('status', $status)
                ->get();

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
        } else {
            $bookings = Booking::where('user_id', $id)
                ->where('status', $status)
                ->get();

            foreach ($bookings as $booking) {
                $arrayBooking = null;
                $arrayBooking = $booking->toArray();
                $arrayBooking['time_convert_checkin'] = date('Y-m-d H:i:s', strtotime($booking->check_in));

                $survey_answer_user = SurveyAnswerUser::where([['booking_id', $booking->id], ['user_id', $id]])->get();

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
        }

        return response()->json($arrayBookings);
    }

    public function getAllBookingByClinicID($id, Request $request)
    {
        $status = $request->input('status');
        if ($status) {
            $bookings = Booking::where('clinic_id', $id)
                ->where('status', $status)
                ->get();
        } else {
            $bookings = Booking::where('clinic_id', $id)
                ->where('status', '!=', BookingStatus::CANCEL)
                ->get();
        }
        $arrayBookings = null;
        foreach ($bookings as $booking) {
            $arrayBooking = null;
            $arrayBooking = $booking->toArray();
            $arrayBooking['time_convert_checkin'] = date('Y-m-d H:i:s', strtotime($booking->check_in));
            $arrayBookings[] = $arrayBooking;
        }
        return response()->json($arrayBookings);
    }

    public function cancelBooking(Request $request, $id)
    {
        $booking = Booking::find($id);
        $status = $request->input('status') ?? BookingStatus::CANCEL;
        $reason = $request->input('reason');
        if ($booking) {
            $booking->status = $status;
            $booking->reason_cancel = $reason;
            $booking->save();
            return response()->json(['message' => 'Booking status updated successfully']);
        } else {
            return response()->json(['error' => 'Booking not found'], 404);
        }
    }

    public function bookingCancel(Request $request, $id)
    {
        $booking = Booking::find($id);
        $status = $request->input('status') ?? BookingStatus::CANCEL;
        $reason = $request->input('reason');
        if ($booking) {
            $booking->status = $booking->status == BookingStatus::PENDING ? BookingStatus::CANCEL :
                ($booking->status == BookingStatus::CANCEL ? BookingStatus::PENDING : BookingStatus::CANCEL);
            $booking->reason_cancel = $reason;
            $booking->save();
            return response()->json(['message' => 'Booking status updated successfully']);
        } else {
            return response()->json(['error' => 'Booking not found'], 404);
        }
    }

    public function getAllBooking($id = null)
    {
        $arrayBookings = Booking::all();

        if ($id) {
            $arrayBookings = Booking::where('clinic_id', $id)->get();
        }

        return response()->json($arrayBookings);
    }

    public function getListReason()
    {
        $reflector = new \ReflectionClass('App\Enums\ReasonCancel');
        $reasons = $reflector->getConstants();
        return response()->json($reasons);
    }
}
