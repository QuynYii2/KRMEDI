<?php

namespace App\Http\Controllers\restapi;

use App\Enums\BookingStatus;
use App\Enums\Role;
use App\Enums\SurveyType;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Clinic;
use App\Models\SurveyAnswer;
use App\Models\SurveyAnswerUser;
use App\Models\SurveyQuestion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingApi extends Controller
{
    public function createBooking(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'checkInTime' => 'required|date',
                'checkOutTime' => 'required|date|after:checkInTime',
                'member_family_id' => 'nullable|numeric',
                'department_id' => 'required|numeric',
                'clinic_id' => 'required|numeric',
                'user_id' => 'required|numeric'
            ]);

            if ($validated->fails()) {
                return response()->json(['error' => -1, 'message' => $validated->errors()->first()], 400);
            }

            $validatedData = $validated->validated();

            $checkInTime = Carbon::parse($validatedData['checkInTime']);
            $checkOutTime = Carbon::parse($validatedData['checkOutTime']);

            $validatedData['check_in'] = $checkInTime;
            $validatedData['check_out'] = $checkOutTime;

            $requestData = $request->only(['checkInTime', 'checkOutTime', 'clinic_id']);
            $request->merge($requestData);

            $checkWorkingTime = $this->checkWorkingTime($request);
            $slotAvailable = json_decode($checkWorkingTime->getContent())->data;

            if ($slotAvailable > 10) {
                return response()->json(['error' => -1, 'message' => 'This slot have full of 10 request'], 400);
            }

            $booking = Booking::create($validatedData);

            $newBooking = Booking::with('user', 'clinic')->find($booking->id);

            if ($newBooking) {
                $bookingController = new BookingController();
                $bookingController->sendMessageToUserOnBookingCreated($newBooking);
                // $bookingController->sendOAMessageFromAdminToClinic($newBooking);
            }

            return response()->json(['error' => 0, 'data' => $booking]);
        } catch (\Exception $e) {
            return response(['error' => -1, 'message' => $e->getMessage()], 400);
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

        $array_id = [
            $business_role1->id,
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
            $booking->status = $booking->status == BookingStatus::PENDING ? BookingStatus::CANCEL : ($booking->status == BookingStatus::CANCEL ? BookingStatus::PENDING : BookingStatus::CANCEL);
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

    public function checkWorkingTime(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'checkInTime' => 'required|date',
                'checkOutTime' => 'required|date|after:checkInTime',
                'clinic_id' => 'nullable|numeric'
            ]);

            if ($validated->fails()) {
                return response()->json(['error' => -1, 'message' => $validated->errors()->first()], 400);
            }

            $validatedData = $validated->validated();

            $checkInTime = $validatedData['checkInTime'];
            $checkOutTime = $validatedData['checkOutTime'];
            $clinic_id = $validatedData['clinic_id'];

            $bookingCount = Booking::where('check_in', '>=', $checkInTime)->where('check_out', '<=', $checkOutTime);

            if ($clinic_id) {
                $bookingCount = $bookingCount->where('clinic_id', $clinic_id);
            }

            $bookingCount = $bookingCount->count();

            return response()->json(['error' => 0, 'data' => $bookingCount]);
        } catch (\Exception $e) {
            return response(['error' => -1, 'message' => $e->getMessage()], 400);
        }
    }

    public function listWorkingTime(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'date' => 'required|date',
                'clinic_id' => 'required|numeric'
            ]);

            if ($validated->fails()) {
                return response()->json(['error' => -1, 'message' => $validated->errors()->first()], 400);
            }

            $validatedData = $validated->validated();

            $selectedDate = $validatedData['date'];
            $clinicId = $validatedData['clinic_id'];

            $workingHours = [
                "08:00-09:00",
                "09:00-10:00",
                "10:00-11:00",
                "12:00-13:00",
                "13:00-14:00",
                "14:00-15:00",
                "15:00-16:00",
                "16:00-17:00"
            ];

            $bookingCounts = [];

            foreach ($workingHours as $timeSlot) {
                list($startTime, $endTime) = explode('-', $timeSlot);

                $checkInTime = $selectedDate . ' ' . $startTime . ':00';
                $checkOutTime = $selectedDate . ' ' . $endTime . ':00';

                $query = Booking::where('check_in', '>=', $checkInTime)
                    ->where('check_out', '<=', $checkOutTime);

                if ($clinicId) {
                    $query->where('clinic_id', $clinicId);
                }

                $bookingCount = $query->count();

                $bookingInfo = null;
                if ($bookingCount > 0) {
                    $bookingInfo = $query->get();
                }

                $bookingCounts[] = [
                    'checkInTime' => $checkInTime,
                    'checkOutTime' => $checkOutTime,
                    'count' => $bookingCount,
                    'bookings' => $bookingInfo
                ];
            }

            return response()->json(['error' => 0, 'data' => $bookingCounts]);
        } catch (\Exception $e) {
            return response(['error' => -1, 'message' => $e->getMessage()], 400);
        }
    }

    public function getBusinessListBooking(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'status' => 'required|in:CANCEL,APPROVED,COMPLETE,DELETE',
                'date' => 'required|date',
                'user_id' => 'required|numeric'
            ]);

            if ($validated->fails()) {
                return response()->json(['error' => -1, 'message' => $validated->errors()->first()], 400);
            }

            $validatedData = $validated->validated();

            $selectedDate = $validatedData['date'];
            $userId = $validatedData['user_id'];
            $clinicId = User::getClinicID($userId);
            $status = $validatedData['status'];

            $workingHours = [
                "08:00-09:00",
                "09:00-10:00",
                "10:00-11:00",
                "12:00-13:00",
                "13:00-14:00",
                "14:00-15:00",
                "15:00-16:00",
                "16:00-17:00"
            ];

            $bookingCounts = [];

            foreach ($workingHours as $timeSlot) {
                list($startTime, $endTime) = explode('-', $timeSlot);

                $checkInTime = $selectedDate . ' ' . $startTime . ':00';
                $checkOutTime = $selectedDate . ' ' . $endTime . ':00';

                $query = Booking::where('check_in', '>=', $checkInTime)
                    ->where('check_out', '<=', $checkOutTime);

                if ($clinicId) {
                    $query->where('clinic_id', $clinicId);
                }

                if ($status) {
                    $query->where('status', $status);
                }

                $bookingCount = $query->count();

                $bookingInfo = null;
                if ($bookingCount > 0) {
                    $bookingInfo = $query->get();
                }

                $bookingCounts[] = [
                    'checkInTime' => $checkInTime,
                    'checkOutTime' => $checkOutTime,
                    'count' => $bookingCount,
                    'bookings' => $bookingInfo
                ];
            }

            return response()->json(['error' => 0, 'data' => $bookingCounts]);
        } catch (\Exception $e) {
            return response(['error' => -1, 'message' => $e->getMessage()], 400);
        }
    }

    public function getUserListBooking(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'status' => 'required|in:CANCEL,APPROVED,COMPLETE,DELETE',
                'date' => 'required|date',
                'user_id' => 'required|numeric',
            ]);

            if ($validated->fails()) {
                return response()->json(['error' => -1, 'message' => $validated->errors()->first()], 400);
            }

            $validatedData = $validated->validated();

            $selectedDate = $validatedData['date'];
            $userId = $validatedData['user_id'];
            $status = $validatedData['status'];

            $workingHours = [
                "08:00-09:00",
                "09:00-10:00",
                "10:00-11:00",
                "12:00-13:00",
                "13:00-14:00",
                "14:00-15:00",
                "15:00-16:00",
                "16:00-17:00"
            ];

            $bookingCounts = [];

            foreach ($workingHours as $timeSlot) {
                list($startTime, $endTime) = explode('-', $timeSlot);

                $checkInTime = $selectedDate . ' ' . $startTime . ':00';
                $checkOutTime = $selectedDate . ' ' . $endTime . ':00';

                $query = Booking::where('check_in', '>=', $checkInTime)
                    ->where('check_out', '<=', $checkOutTime);

                if ($userId) {
                    $query->where('user_id', $userId);
                }

                if ($status) {
                    $query->where('status', $status);
                }

                $bookingCount = $query->count();

                $bookingInfo = null;
                if ($bookingCount > 0) {
                    $bookingInfo = $query->get();
                }

                $bookingCounts[] = [
                    'checkInTime' => $checkInTime,
                    'checkOutTime' => $checkOutTime,
                    'count' => $bookingCount,
                    'bookings' => $bookingInfo
                ];
            }

            return response()->json(['error' => 0, 'data' => $bookingCounts]);
        } catch (\Exception $e) {
            return response(['error' => -1, 'message' => $e->getMessage()], 400);
        }
    }


}
