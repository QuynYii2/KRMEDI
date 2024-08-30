<?php

namespace App\Http\Controllers\restapi;

use App\Enums\BookingStatus;
use App\Enums\Role;
use App\Enums\SurveyType;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\Controller;
use App\Jobs\booking\ProcessBooking;
use App\Models\Booking;
use App\Models\Clinic;
use App\Models\Department;
use App\Models\PrescriptionResults;
use App\Models\SurveyAnswer;
use App\Models\SurveyAnswerUser;
use App\Models\SurveyQuestion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingApi extends Controller
{
    public function createBooking(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'checkInTime' => 'required|date',
                'checkOutTime' => 'required|date|after:checkInTime',
                'member_family_child_id' => 'nullable',
                'department_id' => 'nullable|numeric',
                'clinic_id' => 'required|numeric',
                'user_id' => 'required|numeric',
                'service' => 'nullable'
            ]);

            if ($validated->fails()) {
                return response()->json(['error' => -1, 'message' => $validated->errors()->first()], 400);
            }

            $validatedData = $validated->validated();

            if (isset($validatedData['service'])) {
                $validatedData['service'] = implode(',', $validatedData['service']);
            }

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

            $extend['isReminded'] = 0;
            $booking->insurance_use = $request->input('insurance_use');
            $booking->extend = $extend;
            $booking->member_family_id = $request->input('member_family_child_id');
            $booking->insurance_use = $request->input('is_use_insurance');
            $booking->save();

            $newBooking = Booking::with('user', 'clinic.users')->find($booking->id);

            if ($newBooking) {
                ProcessBooking::dispatch($newBooking);
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
                ->orderBy('id', 'desc')
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

                $data_prescription = PrescriptionResults::where('booking_id', $booking->id)->orderBy('created_at','desc')->first();
                $isPrescription = true;
                if (!$data_prescription){
                    $isPrescription = false;
                }

                $arrayBooking['question'] = $arrQuestion;
                $arrayBooking['examination_results_pdf'] = $booking->prescription_file??null;
                $arrayBooking['isPrescription'] = $isPrescription;
                $arrayBooking['department_name'] = Department::find($booking->department_id)->name??'';
                $arrayBooking['clinic_name'] = Clinic::find($booking->user_id)->name??'';

                $arrayBookings[] = $arrayBooking;
            }
        } else {
            $bookings = Booking::where('user_id', $id)
                ->where('status', $status)
                ->orderBy('id', 'desc')
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

                $data_prescription = PrescriptionResults::where('booking_id', $booking->id)->orderBy('created_at','desc')->first();
                $isPrescription = true;
                if (!$data_prescription){
                    $isPrescription = false;
                }

                $arrayBooking['question'] = $arrQuestion;
                $arrayBooking['examination_results_pdf'] = $booking->prescription_file??null;
                $arrayBooking['isPrescription'] = $isPrescription;
                $arrayBooking['department_name'] = Department::find($booking->department_id)->name??'';
                $arrayBooking['clinic_name'] = Clinic::find($booking->user_id)->name??'';

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

            if ($request->input('status') == BookingStatus::CANCEL) {
                $user_title = 'Một đơn booking đã huỷ';
                $clinic_title = 'Một đơn booking đã huỷ';
            } else {
                $user_title = 'Một đơn booking đã thay đổi trạng thái';
                $clinic_title = 'Một đơn booking đã thay đổi trạng thái';
            }

            $mainApi = new MainApi();
            $newRequestData = [
                'id' => $booking->id,
                'user_id' => $booking->user_id,
                'clinic_id' => $booking->clinic_id,
                'user_title' => $user_title,
                'clinic_title' => $clinic_title,
            ];
            $request = new Request($newRequestData);
            $mainApi->sendFcmNotification($request);
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

            $bookingCount = Booking::where('check_in', '>=', $checkInTime)->where('check_out', '<=', $checkOutTime)->where('status', '!=', 'CANCEL');

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

    public function getBookingDetail($id)
    {
        try {
            if (!$id) {
                return response()->json(['error' => -1, 'message' => 'Id is required'], 400);
            }

            $detail = Booking::with('clinic.users', 'user')->find($id);

            return response()->json(['error' => 0, 'data' => $detail]);
        } catch (\Exception $e) {
            return response()->json(['error' => -1, 'message' => $e->getMessage()]);
        }
    }

    public function fileBookingResult($booking_id)
    {
        try {
            if (!$booking_id) {
                return response()->json(['error' => -1, 'message' => 'Booking Id is required'], 400);
            }

            $detail = Booking::with('clinic.users', 'user', 'doctor')->find($booking_id);

            return response()->json(['error' => 0, 'data' => $detail]);
        } catch (\Exception $e) {
            return response()->json(['error' => -1, 'message' => $e->getMessage()]);
        }
    }

    public function examinationResultsPdf($id)
    {
        $data_prescription = PrescriptionResults::where('booking_id', $id)->orderBy('created_at','desc')->first();

        if (!$data_prescription) {
            return response()->json([
                'message' => 'Đơn thuốc không tồn tại.']);
        }

        $doctor_name = User::find($data_prescription->created_by);
        $user_name = User::find($data_prescription->user_id);

        $pdf = Pdf::loadView('components.head.pdf', [
            'doctor' => $doctor_name->name,
            'data' => json_decode($data_prescription->prescriptions, true),
            'user_name' => $user_name->name,
        ]);

        $fileName = 'donthuoc_' . $data_prescription->id . '.pdf';
        $filePath = 'prescriptions/' . $fileName;
        $pdf->save(storage_path('app/public/' . $filePath));

        return response()->json([
            'message' => 'File PDF đã được lưu thành công.',
            'pdf_url' => 'storage/'.$filePath,
        ]);
    }

    //Booking reminder through zalo & fcm
    public function bookingReminder()
    {
        $currentDateTime = Carbon::now('Asia/Ho_Chi_Minh');

        $booking = Booking::query();

        $booking = $booking->where(function ($query) use ($currentDateTime) {
            $query->where(function ($query) use ($currentDateTime) {
                $query->where('extend->isReminded', 0)
                    ->where('check_in', $currentDateTime->copy()->addHour()->minute(0)->second(0));
            });
        });

        $booking = $booking->get();

        $bookingController = new BookingController();
        foreach ($booking as $b) {
            $newBooking = Booking::with('user', 'clinic.users')->find($b->id);
            $bookingController->sendMessageToUserOnBookingCreated($newBooking);
            $extend['isReminded'] = 1;
            $b->extend = $extend;
            $b->save();

            //SEND FCM
            $mainApi = new MainApi();
            $newRequestData = [
                'id' => $newBooking->id,
                'user_id' => $newBooking->user_id,
                'clinic_id' => $newBooking->clinic_id,
                'clinic_title' => "Hãy chuẩn bị cho ca khám của bạn",
                'user_title' => "Hãy nhớ lịch khám sắp tới của bạn",
            ];
            $request = new Request($newRequestData);
            $mainApi->sendFcmNotification($request);
        }
    }
}
