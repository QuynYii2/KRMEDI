<?php

namespace App\Http\Controllers;

use App\Enums\BookingStatus;
use App\Enums\CartStatus;
use App\Enums\ClinicStatus;
use App\Enums\Constants;
use App\Enums\ReviewStatus;
use App\Models\Commune;
use App\Models\District;
use App\Models\Province;
use App\Models\Review;
use App\Models\Symptom;
use App\Services\FcmService;
use App\Enums\ServiceClinicStatus;
use App\Enums\SurveyType;
use App\Enums\TypeProductCart;
use App\Http\Controllers\restapi\MainApi;
use App\Models\Booking;
use App\Models\BookingResult;
use App\Models\Cart;
use App\Models\Clinic;
use App\Models\Department;
use App\Models\Notification;
use App\Models\PrescriptionResults;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\ServiceClinic;
use App\Models\SurveyAnswer;
use App\Models\SurveyAnswerUser;
use App\Models\SurveyQuestion;
use App\Models\WishList;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\ZaloController;
use App\Jobs\booking\ChangeBookingStatus;
use App\Models\User;
use App\Models\ZaloFollower;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Pusher\Pusher;
use setasign\Fpdi\Fpdi;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PhpOffice\PhpSpreadsheet\IOFactory as SpreadsheetIOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Html as HtmlWriter;

class BookingController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $id = Auth::user()->id;
            return view('bookings.listBooking', compact('id'));
        }
        return redirect()->route('home');
    }

    public function resultsDetail($id)
    {
        $resultBooking = BookingResult::where('booking_id', $id)->first();
        $medicine_favourites = null;
        if (Auth::check()) {
            $medicine_favourites = WishList::where('user_id', Auth::user()->id)
                ->where('type_product', TypeProductCart::MEDICINE)
                ->get();

            $medicine_favourites = json_encode($medicine_favourites->pluck('product_id')->toArray());
        }
        return view('bookings.resultBooking', compact('resultBooking', 'medicine_favourites'));
    }

    public function detailBooking($id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            toast('Booking không tồn tại', 'error', 'top-left');
            return back();
        }
        $clinic = Clinic::find($booking->clinic_id);
        $user = Auth::user();
        if ($booking->member_family_id == null) {
            $memberFamily = null;
        } else {
            $memberFamily = \DB::table('family_management')
                ->where('user_id', $booking->user_id)
                ->where('id', $booking->member_family_id)->get();
        }
        $serviceBookings = explode(',', $booking->service);
        $service = ServiceClinic::whereIn('id', $serviceBookings)->get();
        $isAdmin = (new MainController())->checkAdmin();

        $surveyByBooking = SurveyAnswerUser::where([['booking_id', $id], ['user_id', Auth::id()]])->get('result');

        $arraySurvey = [];
        foreach ($surveyByBooking as $survey) {
            $parts = explode('-', $survey->result, 2);
            $idQuestion = $parts[0];

            $question = SurveyQuestion::find($idQuestion)->toArray();

            if ($question['type'] === SurveyType::TEXT) {
                $question['answers'] = $parts[1];
                array_push($arraySurvey, $question);
                continue;
            }

            $idAnswer = $parts[1];
            $idAnswer = explode(',', $idAnswer);
            $answers = SurveyAnswer::whereIn('id', $idAnswer)->get()->toArray();
            $question['answers'] = $answers;

            array_push($arraySurvey, $question);
        }

        return view('bookings.detailBooking', compact('booking', 'clinic', 'user', 'memberFamily', 'service', 'isAdmin', 'arraySurvey'));
    }

    public function edit($id)
    {
        $dataBooking = Booking::find($id);
        $userId = $dataBooking->user_id;
        $checkInDate = \Carbon\Carbon::parse($dataBooking->check_in)->format('Y-m-d');
        $owner = $dataBooking->clinic->user_id;
        $isAdmin = (new MainController())->checkAdmin();

        $role_id = RoleUser::where('user_id',Auth::id())->first();
        $role_name = Role::find($role_id->role_id);
        $isDoctor = $role_name->name == 'DOCTORS';
        if ($role_name->name == 'DOCTORS'){
            $bookings_edit = Booking::where('user_id', $userId)->where('doctor_id',Auth::id())->where('type',0)
                ->whereDate('check_in', $checkInDate)->get();
        }elseif ($role_name->name == 'HOSPITALS' || $role_name->name == 'CLINICS' || $role_name->name == 'PHARMACIES'){
            $clinic = Clinic::where('user_id', Auth::user()->id)->first();
            $bookings_edit = Booking::where('user_id', $userId)->where('type',0)->where('clinic_id',$clinic->id)
                ->whereDate('check_in', $checkInDate)->get();
        }else{
            $bookings_edit = Booking::where('user_id', $userId)->where('type',0)
                ->whereDate('check_in', $checkInDate)->get();
        }

        foreach ($bookings_edit as $value){
            $serviceIds = explode(',', $value->service);

            $services = DB::table('service_clinics')
                ->whereIn('id', $serviceIds)
                ->pluck('name');
            $servicePrices = DB::table('service_clinics')
                ->whereIn('id', $serviceIds)
                ->pluck('service_price');

            $value->name_service = implode(', ', $services->toArray());
            $value->total_service = $servicePrices->sum();
            $value->services = ServiceClinic::where('status', ServiceClinicStatus::ACTIVE)->get();
            $value->repeaterItems = [];

            $doctor_id = null;
            $doctor_name = null;

            if (isset($value->doctor_id) && $value->doctor_id) {
                $doctor = User::find($value->doctor_id);
                $value->doctor_name = $doctor->name;
            }
            $repeaterItems = [];
            if (isset($value->extend['booking_results'])) {
                foreach ($value->extend['booking_results'] as $bookingResult) {
                    $selectValue = $bookingResult['type'];
                    $fileUrl = $bookingResult['url'];
                    $doctorId = $bookingResult['doctor_id'];
                    $doctorName = User::find($doctorId)->name;

                    // Create a new repeater item array
                    $items = [
                        'selectValue' => $selectValue,
                        'fileUrl' => $fileUrl,
                        'doctorId' => $doctorId,
                        'doctorName' => $doctorName,
                    ];

                    // Add the repeater item to the array
                    $repeaterItems[] = $items;
                }
                $value->repeaterItems = $repeaterItems??[];
            }

            $data_prescription = PrescriptionResults::where('booking_id',$value->id)->first();
            if (isset($data_prescription)){
                $value->prescription_product = json_decode($data_prescription->prescriptions, true);
            }else{
                $value->prescription_product = [];
            }

            if ($role_name->name == 'HOSPITALS'){
                $value->list_doctor = User::where('manager_id',$role_id->user_id)->orWhere('id',$value->doctor_id)->get();
            }else{
                $value->list_doctor = User::where('department_id',$value->department_id)->orWhere('id',$value->doctor_id)->get();
            }

        }

        $userFollower = ZaloFollower::where('extend->user_id', $userId)->first();
        $user_zalo_id = $userFollower->user_id ?? 0;

        $reflector = new \ReflectionClass('App\Enums\ReasonCancel');
        $reasons = $reflector->getConstants();

        $departments = Department::where('status','ACTIVE')->get();

        if ($owner == Auth::id() || $isAdmin || $isDoctor) {
            return view('admin.booking.tab-edit-booking', compact('bookings_edit', 'isAdmin', 'reasons', 'user_zalo_id','isDoctor','departments','dataBooking'));
        } else {
            session()->flash('error', 'You do not have permission.');
            return \redirect()->back();
        }
    }

    public function editDirect($id)
    {
        $dataBooking = Booking::find($id);
        $userId = $dataBooking->user_id;
        $checkInDate = \Carbon\Carbon::parse($dataBooking->check_in)->format('Y-m-d');
        $owner = $dataBooking->clinic->user_id;
        $isAdmin = (new MainController())->checkAdmin();

        $role_id = RoleUser::where('user_id',Auth::id())->first();
        $role_name = Role::find($role_id->role_id);
        $isDoctor = $role_name->name == 'DOCTORS';
        if ($role_name->name == 'DOCTORS'){
            $bookings_edit = Booking::where('user_id', $userId)->where('doctor_id',Auth::id())->where('type',1)
                ->whereDate('check_in', $checkInDate)->get();
        }elseif ($role_name->name == 'HOSPITALS' || $role_name->name == 'CLINICS' || $role_name->name == 'PHARMACIES'){
            $clinic = Clinic::where('user_id', Auth::user()->id)->first();
            $bookings_edit = Booking::where('user_id', $userId)->where('type',1)->where('clinic_id',$clinic->id)
                ->whereDate('check_in', $checkInDate)->get();
        } else{
            $bookings_edit = Booking::where('user_id', $userId)->where('type',1)
                ->whereDate('check_in', $checkInDate)->get();
        }

        foreach ($bookings_edit as $value){
            $serviceIds = explode(',', $value->service);

            $services = DB::table('service_clinics')
                ->whereIn('id', $serviceIds)
                ->pluck('name');
            $servicePrices = DB::table('service_clinics')
                ->whereIn('id', $serviceIds)
                ->pluck('service_price');

            $value->name_service = implode(', ', $services->toArray());
            $value->total_service = $servicePrices->sum();
            $value->services = ServiceClinic::where('status', ServiceClinicStatus::ACTIVE)->get();
            $value->repeaterItems = [];

            $doctor_id = null;
            $doctor_name = null;

            if (isset($value->doctor_id) && $value->doctor_id) {
                $doctor = User::find($value->doctor_id);
                $value->doctor_name = $doctor->name;
            }
            $repeaterItems = [];
            if (isset($value->extend['booking_results'])) {
                foreach ($value->extend['booking_results'] as $bookingResult) {
                    $selectValue = $bookingResult['type'];
                    $fileUrl = $bookingResult['url'];
                    $doctorId = $bookingResult['doctor_id'];
                    $doctorName = User::find($doctorId)->name;

                    // Create a new repeater item array
                    $items = [
                        'selectValue' => $selectValue,
                        'fileUrl' => $fileUrl,
                        'doctorId' => $doctorId,
                        'doctorName' => $doctorName,
                    ];

                    // Add the repeater item to the array
                    $repeaterItems[] = $items;
                }
                $value->repeaterItems = $repeaterItems??[];
            }

            $data_prescription = PrescriptionResults::where('booking_id',$value->id)->first();
            if (isset($data_prescription)){
                $value->prescription_product = json_decode($data_prescription->prescriptions, true);
            }else{
                $value->prescription_product = [];
            }

            if ($role_name->name == 'HOSPITALS'){
                $value->list_doctor = User::where('manager_id',$role_id->user_id)->orWhere('id',$value->doctor_id)->get();
            }else{
                $value->list_doctor = User::where('department_id',$value->department_id)->orWhere('id',$value->doctor_id)->get();
            }

        }

        $userFollower = ZaloFollower::where('extend->user_id', $userId)->first();
        $user_zalo_id = $userFollower->user_id ?? 0;

        $reflector = new \ReflectionClass('App\Enums\ReasonCancel');
        $reasons = $reflector->getConstants();

        $departments = Department::where('status','ACTIVE')->get();

        if ($owner == Auth::id() || $isAdmin || $isDoctor) {
            return view('admin.booking.tab-edit-booking', compact('bookings_edit', 'isAdmin', 'reasons', 'user_zalo_id', 'doctor_id', 'doctor_name','isDoctor','departments','dataBooking'));
        } else {
            session()->flash('error', 'You do not have permission.');
            return \redirect()->back();
        }
    }

    public function creatBookingNew(Request $request)
    {
        try {
            $clinicID = $request->input('clinic_id');
            $service = $request->input('service');
            $memberFamily = $request->input('memberFamily');
            if ($memberFamily == 'family') {
                $memberFamily = $request->input('membersFamily');
            } else {
                $memberFamily = null;
            }
            $medical_history = $request->input('medical_history') ?? '';

            if (is_array($service)) {
                $servicesAsString = implode(',', $service);
            } else {
                $servicesAsString = $service;
            }

            if (is_array($medical_history)) {
                $medical_historyAsString = implode('&&', $medical_history);
            } else {
                $medical_historyAsString = $medical_history;
            }

            $time = $request->input('selectedTime');
            $timestamp = Carbon::parse($time);
            $booking = new Booking();

            $booking->user_id = Auth::user()->id;
            $booking->clinic_id = $clinicID;
            $booking->check_in = $timestamp;
            $booking->status = BookingStatus::APPROVED;
            $booking->service = $servicesAsString;
            $booking->medical_history = $medical_historyAsString;
            $booking->member_family_id = $memberFamily;

            $clinicID = $booking->clinic_id;

            $clinic = Clinic::find($clinicID);
            if (!$clinic) {
                alert('Booking error');
                return back('Not found');
            }
            $department = $clinic->department;
            $array_department = explode(',', $department);
            $list_department = DB::table('departments')
                ->whereIn('id', $array_department)
                ->update(['score' => DB::raw('score + 2')]);

            $servicesAsString = $booking->service;
            $timestamp = $booking->check_in;
            $datetime = $timestamp->addMinutes(30);
            $familyId = $booking->member_family_id;
            $exitBooking = Booking::where('clinic_id', $clinicID)
                ->where('service', $servicesAsString)
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
            $booking->save();
            if ($booking) {
                alert('Đặt lịch thành công');
                return back()->with('success', 'Đặt lịch thành công');
            }
            alert('Đặt lịch thất bại');
            return back('Create error',);
        } catch (\Exception $exception) {
            alert('Đặt lịch thất bại');
            return back();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $isSendOaToUser = false;

            $booking = Booking::find($id);
            $status = $request->input('status');
            // $doctor_id = $request->input('doctor_id');
            $is_result = $request->input('is_result');
            if (!$is_result) {
                $is_result = 0;
            }
            if ($request->hasFile('prescription_file')) {
                $file = $request->file('prescription_file');
                $extension = $file->getClientOriginalExtension();

                $originalFilePath = 'prescriptions/' . time() . '.' . $extension;
                Storage::disk('public')->put($originalFilePath, File::get($file));

                if (in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'png', 'jpg', 'jpeg'])) {
                    $pdfFileName =  time() . '.pdf';
                    $pdfPath = 'prescriptions';
                    $pdfUrl = 'storage/' . $pdfPath . '/' . $pdfFileName;
                    $pdfFullPath = storage_path('app/public/' . $pdfPath . '/' . $pdfFileName);

                    $pdfContent = $this->convertToPDF(Storage::disk('public')->path($originalFilePath), $extension);

                    Storage::disk('public')->put($pdfPath . '/' . $pdfFileName, $pdfContent);

                    Storage::disk('public')->delete($originalFilePath);

                    $booking->prescription_file = $pdfUrl;
                } else {
                    $booking->prescription_file = $originalFilePath;
                }
            }

            $bookingResults = $booking->extend['booking_results'] ?? [];

            $bookingResultList = $request->booking_result_list??[];

            //Check booking files changes
            $isChange = false;

            foreach ($bookingResults as $oldItem) {
                $valueChange = true;

                foreach ($bookingResultList as $newItem) {
                    if (
                        $oldItem['type'] === $newItem['select']
                        && $oldItem['doctor_id'] === $newItem['doctor_id']
                        && $oldItem['url'] === $newItem['file_urls']
                    ) {
                        $valueChange = false;
                        break;
                    }
                }

                if ($valueChange) {
                    $isChange = true;
                    break;
                }
            }

            if (!$isChange && count($bookingResults) !== count($bookingResultList)) {
                $isChange = true;
            }

            if ($status == BookingStatus::COMPLETE && $is_result == 1) {
                foreach ($bookingResultList as $index => $result) {
                    if (isset($result['select']) && isset($result['doctor_id']) && (isset($result['file_urls']) || isset($result['file']))) {
                        $validator = Validator::make($result, [
                            'file.*' => 'mimes:pdf,jpg,jpeg,png,gif',
                        ]);

                        if ($validator->fails()) {
                            alert('Error', 'Tài liệu phải là định dạng PDF hoặc ảnh (jpg, jpeg, png, gif)', 'error');
                            return redirect()->back()->withErrors($validator)->withInput();
                        }

                        // Remove the old file if it exists new file
                        if (isset($bookingResults[$index]['url']) && Storage::exists(str_replace('/storage', 'public', $bookingResults[$index]['url'])) && isset($result['file'])) {
                            Storage::delete(str_replace('/storage', 'public', $bookingResults[$index]['url']));
                        }

                        // Handle the new file input
                        if (isset($result['file']) && $result['file']) {
                            $itemPath = $result['file']->store('bookings_result', 'public');
                            $fileUrl = asset('storage/' . $itemPath);
                            $fileExtension = $result['file']->getClientOriginalExtension();

                            if ($fileExtension === 'pdf') {
                                $qrCode = null;
                                if (isset($result['doctor_id']) && $result['doctor_id']) {
                                    $url = route('qr.code.show.doctor.info', $result['doctor_id']);
                                    $qrCode = QrCode::format('png')->size(150)->generate($url);
                                    $doctorName        = User::find($result['doctor_id'])->name ?? "";
                                    $doctorSignature   = User::find($result['doctor_id'])->signature ?? "";
                                    $this->insertQRCodeIntoPDF($fileUrl, $qrCode, $booking, $doctorName, $doctorSignature);
                                }
                            }

                        } else if ($result['file_urls']) {
                            // If file input is not set, use the existing value with file_urls
                            $fileUrl = $booking->extend['booking_results'][$index]['url'] ?? $result['file_urls'] ?? '';
                        }

                        $bookingResult = [
                            'type' => $result['select'],
                            'url' => $fileUrl,
                            'doctor_id' => $result['doctor_id'],
                        ];

                        $bookingResults[$index] = $bookingResult;
                    }
                }

                $extendData = $booking->extend ?? [];

                $extendData['booking_results'] = array_values($bookingResults);
                $booking->extend = $extendData;
            }elseif ($status == BookingStatus::COMPLETE){
                $user = User::find($booking->user_id);
                $clinic = Clinic::find($booking->clinic_id);
                $specialist = Department::find($booking->department_id);
                $doctor = User::find($booking->doctor_id);
//                $this->sendZaloMessageBookingComplete($booking,$user,$clinic,$specialist->name,$doctor);
            }

            // Check if the status has changed
            if ($booking->status != $status || $isChange) {
                // Status has changed, send zalo OA msg to customer
                $isSendOaToUser = true;
            }

            $booking->doctor_id = $request->input('doctor_id')??$booking->doctor_id;
            $booking->type = $request->input('type');
            $booking->is_result = $is_result;
            $booking->status = $status;
            $booking->department_id = $request->get('departments_id')??$booking->department_id;

            $reason = $request->input('reason_text');

            if ($status == BookingStatus::CANCEL) {
                $booking->reason_cancel = $reason;
            }

            $success = $booking->save();

            $medicines = $request->get('medicines');
            if (isset($medicines) && count($medicines)>0){
                $dataUser = User::find($booking->user_id);
                $prescription_result = PrescriptionResults::where('booking_id', $booking->id)->first();

                if ($prescription_result) {
                    $existingPrescriptions = json_decode($prescription_result->prescriptions, true);
                    if (!is_array($existingPrescriptions)) {
                        $existingPrescriptions = [];
                    }
                    if (is_array($medicines)) {
                        $mergedPrescriptions = array_merge($existingPrescriptions, $medicines);
                    } else {
                        $mergedPrescriptions = $existingPrescriptions;
                    }
                    $prescription_result->prescriptions = json_encode($mergedPrescriptions);
                    $prescription_result->created_by = Auth::id();
                    $prescription_result->save();
                } else {
                    $prescription_result = new PrescriptionResults();
                    $prescription_result->full_name = $dataUser->username;
                    $prescription_result->email = $dataUser->email ?? '';
                    $prescription_result->user_id = $dataUser->id;
                    $prescription_result->created_by = Auth::id();
                    $prescription_result->prescriptions = json_encode($medicines);
                    $prescription_result->booking_id = $booking->id;
                    $prescription_result->save();
                }
            }

            if ($success) {
                if ($isSendOaToUser) {
                    //Queue on change booking status notifications
                    if ($status == 'PENDING'){
                        $nameStatus = 'chờ xác nhận';
                        $routerName= '/med-appointment-screen';
                    }elseif ($status == 'APPROVED'){
                        $nameStatus = 'xác nhận';
                        $routerName= '/med-appointment-screen';
                    }elseif ($status == 'COMPLETE'){
                        $nameStatus = 'hoàn thành';
                        $routerName= '/completed-appointment-screen';
                    }else{
                        $nameStatus = 'hủy';
                        $routerName= '/review-med-screen';
                    }
                    $notifi = Notification::create([
                        'title' => 'Thông báo đặt lịch khám',
                        'sender_id' => $booking->user_id,
                        'follower' => $booking->user_id,
                        'target_url' => route('web.users.my.bookings.detail', ['id' => $booking->id]),
                        'description' => 'Trạng thái lịch khám của bạn đã được '.$nameStatus.'. Vui lòng đến kiểm tra!',
                        'booking_id' => $booking->id
                    ]);
                    $notifi->save();

                    $options = array(
                        'cluster' => 'ap1',
                        'encrypted' => true
                    );

                    $PUSHER_APP_KEY = '3ac4f810445d089829e8';
                    $PUSHER_APP_SECRET = 'c6cafb046a45494f80b2';
                    $PUSHER_APP_ID = '1714303';

                    $pusher = new Pusher($PUSHER_APP_KEY, $PUSHER_APP_SECRET, $PUSHER_APP_ID, $options);

                    $requestData = [
                        'user_id' => $booking->user_id,
                        'title' => 'Trạng thái booking đã thay đổi',
                    ];

                    $pusher->trigger('noti-events', 'noti-events', $requestData);
                    $userToken = User::find($booking->user_id)->token_firebase ?? "";

                    $dataSend = $this->sendBookingNotifications( $userToken, $notifi,$booking->id,$routerName);
                    ChangeBookingStatus::dispatch($booking);
                }
                alert('Update success');
                return back()->with('success', 'Đặt lịch thành công');
            }

            return response()->json(['error' => 0, 'data' => $booking]);
        } catch (\Exception $e) {
            return response(['error' => -1, 'message' => $e->getMessage()], 400);
        }
    }

    private function sendBookingNotifications($userToken = null, $notification,$arrayBooking,$routerName)
    {
        if ($userToken) {
            $notificationWithSender = Notification::with('senders')->find($notification->id);

            // Prepare notification payload
            $notificationPayload = [
                'title' => $notificationWithSender->title ?? 'Thông báo mới',
                'body' => $notificationWithSender->description ?? 'Bạn có một thông báo mới.',
            ];

            $data = [
                'title' => $notificationWithSender->title ?? "",
                'sender' => $notificationWithSender->senders->avt ?? "",
                'url' => $notificationWithSender->target_url ?? "#",
                'description' => $notificationWithSender->description ?? "",
                'id' => (string) $notificationWithSender->id,
                'routeKey'=>$routerName,
                'arguments'=>json_encode($arrayBooking),
            ];

            $androidPayload = [
                'notification' => [
                    'icon' => 'ic_launcher',
                    'channel_id' => 'default_channel_id',
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                    'sound' => 'default',
                ],
            ];

            $iosPayload = [
                'aps' => [
                    'sound' => 'default',
                    'badge' => 1,
                ],
            ];

            $payload = [
                'token' => $userToken,
                'notification' => $notificationPayload,
                'data' => array_merge($data, [
                    'channel_id' => 'default_channel_id',
                ]),
            ];

            $platform = $notification->platform ?? 'ANDROID';

            if ($platform === 'ANDROID') {
                $payload['android'] = $androidPayload;
            } elseif ($platform === 'IOS') {
                $payload['apns'] = ['payload' => $iosPayload];
            }

            return FcmService::init()->request($payload);
        }
        return true;
    }

    public function delete($id)
    {
        try {
            $booking = Booking::find($id);
            if (!$booking || $booking->status == BookingStatus::DELETE) {
                return back();
            }

            if ($booking->status == BookingStatus::COMPLETE) {
                alert()->error('Không thể xóa khi đã hoàn thành!');
                return back();
            }

            $booking->status = BookingStatus::DELETE;
            $success = $booking->save();
            if ($success) {
                alert()->success('Delete success!');
                return back();
            }
            return response('Delete error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function create()
    {
        $reflector = new \ReflectionClass('App\Enums\ReasonCancel');
        $reasons = $reflector->getConstants();
        $userData = Auth::user();
        if ($userData->member == "HOSPITALS"){
            $list_doctor = User::where('member','DOCTORS')->where('manager_id',$userData->id)->get();
        }else{
            $list_doctor = User::where('member','DOCTORS')->get();
        }

        return view('admin.booking.tab-create-booking', compact( 'reasons','list_doctor','userData'));
    }

    public function store(Request $request)
    {
        try {
            $extend['isReminded'] = 0;
            $filePath = null;
            if ($request->hasFile('prescription_file')) {
                $file = $request->file('prescription_file');
                $extension = $file->getClientOriginalExtension();

                $originalFilePath = 'prescriptions/' . time() . '.' . $extension;
                Storage::disk('public')->put($originalFilePath, File::get($file));

                if (in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'png', 'jpg', 'jpeg'])) {
                    $pdfFileName =  time() . '.pdf';
                    $pdfPath = 'prescriptions';
                    $pdfUrl = 'storage/' . $pdfPath . '/' . $pdfFileName;
                    $pdfFullPath = storage_path('app/public/' . $pdfPath . '/' . $pdfFileName);

                    $pdfContent = $this->convertToPDF(Storage::disk('public')->path($originalFilePath), $extension);

                    Storage::disk('public')->put($pdfPath . '/' . $pdfFileName, $pdfContent);

                    Storage::disk('public')->delete($originalFilePath);

                    $filePath = $pdfUrl;
                } else {
                    $filePath = $originalFilePath;
                }
            }

                $booking = new Booking([
                'user_id' => $request->user_id,
                'clinic_id' => $request->clinic_id,
                'department_id' => $request->department_id,
                'check_in' => $request->check_in,
                'check_out'=>$request->check_out,
                'doctor_id'=>$request->doctor_id,
                'status'=>$request->status,
                'service'=>3,
                'prescription_file'=>$filePath,
                    'type' => $request->input('type'),
                'extend'=>$extend,
            ]);
            $booking->save();

            $is_result = $request->input('is_result');
            if (!$is_result) {
                $is_result = 0;
            }

            $bookingResults = $booking->extend['booking_results'] ?? [];

            $bookingResultList = $request->booking_result_list;

            //Check booking files changes
            $isChange = false;

            foreach ($bookingResults as $oldItem) {
                $valueChange = true;

                foreach ($bookingResultList as $newItem) {
                    if (
                        $oldItem['type'] === $newItem['select']
                        && $oldItem['doctor_id'] === $newItem['doctors_id']
                        && $oldItem['url'] === $newItem['file_urls']
                    ) {
                        $valueChange = false;
                        break;
                    }
                }

                if ($valueChange) {
                    $isChange = true;
                    break;
                }
            }

            if (!$isChange && count($bookingResults) !== count($bookingResultList)) {
                $isChange = true;
            }

            if ($request->status == BookingStatus::COMPLETE && $is_result == 1) {
                foreach ($bookingResultList as $index => $result) {
                    if (isset($result['select']) && isset($result['doctors_id']) && (isset($result['file_urls']) || isset($result['file']))) {
                        $validator = Validator::make($result, [
                            'file.*' => 'mimes:pdf,jpg,jpeg,png,gif',
                        ]);

                        if ($validator->fails()) {
                            alert('Error', 'Tài liệu phải là định dạng PDF hoặc ảnh (jpg, jpeg, png, gif)', 'error');
                            return redirect()->back()->withErrors($validator)->withInput();
                        }

                        // Remove the old file if it exists new file
                        if (isset($bookingResults[$index]['url']) && Storage::exists(str_replace('/storage', 'public', $bookingResults[$index]['url'])) && isset($result['file'])) {
                            Storage::delete(str_replace('/storage', 'public', $bookingResults[$index]['url']));
                        }

                        // Handle the new file input
                        if (isset($result['file']) && $result['file']) {
                            $itemPath = $result['file']->store('bookings_result', 'public');
                            $fileUrl = asset('storage/' . $itemPath);
                            $fileExtension = $result['file']->getClientOriginalExtension();

                            if ($fileExtension === 'pdf') {
                                $qrCode = null;
                                if (isset($result['doctors_id']) && $result['doctors_id']) {
                                    $url = route('qr.code.show.doctor.info', $result['doctors_id']);
                                    $qrCode = QrCode::format('png')->size(150)->generate($url);
                                    $doctorName        = User::find($result['doctors_id'])->name ?? "";
                                    $doctorSignature   = User::find($result['doctors_id'])->signature ?? "";
                                    $this->insertQRCodeIntoPDF($fileUrl, $qrCode, $booking, $doctorName, $doctorSignature);
                                }
                            }
                        } else if ($result['file_urls']) {
                            // If file input is not set, use the existing value with file_urls
                            $fileUrl = $booking->extend['booking_results'][$index]['url'] ?? $result['file_urls'] ?? '';
                        }

                        $bookingResult = [
                            'type' => $result['select'],
                            'url' => $fileUrl,
                            'doctor_id' => $result['doctors_id'],
                        ];

                        $bookingResults[$index] = $bookingResult;
                    }
                }

                $extendData = $booking->extend ?? [];

                $extendData['booking_results'] = array_values($bookingResults);
                $booking->extend = $extendData;
            }

            $booking->is_result = $is_result;

            $reason = $request->input('reason_text');

            if ($request->status == BookingStatus::CANCEL) {
                $booking->reason_cancel = $reason;
            }

            $success = $booking->save();

            $medicines = $request->get('medicines');
            $dataUser = User::find($booking->user_id);
            $prescription_result = new PrescriptionResults();
            $prescription_result->full_name = $dataUser->username;
            $prescription_result->email = $dataUser->email??'';
            $prescription_result->user_id = $dataUser->id;
            $prescription_result->created_by = Auth::id();
            $prescription_result->prescriptions = json_encode($medicines);
            $prescription_result->booking_id = $booking->id;
            $prescription_result->save();

            if ($success) {
                alert('Create success');
                $user_id = Auth::id();
                $role = RoleUser::where('user_id',$user_id)->first();
                if ($booking->status == 'PENDING'){
                    $nameStatus = 'chờ xác nhận';
                    $routerName= '/med-appointment-screen';
                }elseif ($booking->status == 'APPROVED'){
                    $nameStatus = 'xác nhận';
                    $routerName= '/med-appointment-screen';
                }elseif ($booking->status == 'COMPLETE'){
                    $nameStatus = 'hoàn thành';
                    $routerName= '/completed-appointment-screen';
                }else{
                    $nameStatus = 'hủy';
                    $routerName= '/review-med-screen';
                }
                $notifi = Notification::create([
                    'title' => 'Thông báo đặt lịch khám',
                    'sender_id' => $booking->user_id,
                    'follower' => $booking->user_id,
                    'target_url' => route('web.users.my.bookings.detail', ['id' => $booking->id]),
                    'description' => 'Trạng thái lịch khám của bạn đã được '.$nameStatus.'. Vui lòng đến kiểm tra!',
                    'booking_id' => $booking->id
                ]);
                $notifi->save();

                $options = array(
                    'cluster' => 'ap1',
                    'encrypted' => true
                );

                $PUSHER_APP_KEY = '3ac4f810445d089829e8';
                $PUSHER_APP_SECRET = 'c6cafb046a45494f80b2';
                $PUSHER_APP_ID = '1714303';

                $pusher = new Pusher($PUSHER_APP_KEY, $PUSHER_APP_SECRET, $PUSHER_APP_ID, $options);

                $requestData = [
                    'user_id' => $booking->user_id,
                    'title' => 'Trạng thái booking đã thay đổi',
                ];

                $pusher->trigger('noti-events', 'noti-events', $requestData);
                $userToken = User::find($booking->user_id)->token_firebase ?? "";

                $dataSend = $this->sendBookingNotifications( $userToken, $notifi,$booking->id,$routerName);
                ChangeBookingStatus::dispatch($booking);
                if ($role->role_id == 39){
                    if ($booking->type == 0){
                        return Redirect::route('homeAdmin.list.booking.doctor')->with('success', 'Trả kết quả thành công');
                    }else{
                        return Redirect::route('homeAdmin.list.booking.direct.doctor')->with('success', 'Trả kết quả thành công');
                    }
                }else{
                    if ($booking->type == 0){
                        return Redirect::route('homeAdmin.list.booking')->with('success', 'Trả kết quả thành công');
                    }else{
                        return Redirect::route('homeAdmin.list.booking.direct')->with('success', 'Trả kết quả thành công');
                    }
                }
            }
            return response()->json(['error' => 0, 'data' => $booking]);
        } catch (\Exception $e) {
            return response(['error' => -1, 'message' => $e->getMessage()], 400);
        }
    }

    public function createItem($id)
    {
        $bookings_edit = Booking::find($id);
        $owner = $bookings_edit->clinic->user_id;
        $isAdmin = (new MainController())->checkAdmin();
        $role_id = RoleUser::where('user_id',Auth::id())->first();
        $role_name = Role::find($role_id->role_id);
        $isDoctor = $role_name->name == 'DOCTORS';
        $userName = User::find($bookings_edit->user_id)->name;
        $clinicName = Clinic::find($bookings_edit->clinic_id)->name;
        $userData = Auth::user();

        $doctor_id = null;
        $doctor_name = null;

        if (isset($bookings_edit->doctor_id) && $bookings_edit->doctor_id) {
            $doctor = User::find($bookings_edit->doctor_id);
            $doctor_id = $bookings_edit->doctor_id;
            $doctor_name = $doctor->name;
        }


        $reflector = new \ReflectionClass('App\Enums\ReasonCancel');
        $reasons = $reflector->getConstants();


        if ($role_name->name == 'HOSPITALS'){
            $list_doctor = User::where('manager_id',$role_id->user_id)->orWhere('id',$bookings_edit->doctor_id)->get();
        }else{
            $list_doctor = User::where('department_id',$bookings_edit->department_id)->orWhere('id',$bookings_edit->doctor_id)->get();
        }

        $departments = Department::where('status','ACTIVE')->get();

        if ($owner == Auth::id() || $isAdmin || $isDoctor) {
            return view('admin.booking.tab-create-item-booking', compact('bookings_edit', 'isAdmin', 'reasons', 'doctor_id', 'doctor_name','list_doctor','isDoctor','departments','userName','clinicName','userData'));
        } else {
            session()->flash('error', 'You do not have permission.');
            return \redirect()->back();
        }
    }

    private function convertToPDF($filePath, $extension)
    {
        $content = '';

        switch ($extension) {
            case 'doc':
            case 'docx':
                $phpWord = \PhpOffice\PhpWord\IOFactory::load($filePath);
                $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
                ob_start();
                $htmlWriter->save('php://output');
                $content = ob_get_clean();
                break;

            case 'xls':
            case 'xlsx':
                $spreadsheet = SpreadsheetIOFactory::load($filePath);
                $htmlWriter = new HtmlWriter($spreadsheet);
                ob_start();
                $htmlWriter->save('php://output');
                $content = ob_get_clean();
                break;

            case 'png':
            case 'jpg':
            case 'jpeg':
                $image = file_get_contents($filePath);
                $base64Image = base64_encode($image);
                $content = "<img src='data:image/{$extension};base64,{$base64Image}' />";
                break;
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($content);

        return $pdf->output();
    }

    public function sendMessageToUserOnBookingCreated($booking)
    {
        try {
            $clinicAccessToken = $booking->clinic->users->extend['access_token_zalo'] ?? "";
            if (!$clinicAccessToken) {
                return;
            }
            $zaloFollower = new ZaloFollowerController();
            $bookedUser = $zaloFollower->show($booking->user_id)->getData();
            $zalo = new ZaloController($clinicAccessToken);

            $additionalParams = [
                'user_id' => $bookedUser->user->user_id,
                'booking_clinic' => $booking->clinic->name,
                'booking_clinic_id' => $booking->clinic_id,
                'user_name' => $booking->user->name . ' ' . $booking->user->last_name,
                'booking_status' => $booking->status,
                'booking_cancel_reason' => $booking->reason_cancel ?? '',
                'booking_clinic_checkin' => date('d/m/Y h:i A', strtotime($booking->check_in))
            ];
            $request = new Request();
            $bookingRequest = $request->duplicate()->merge($additionalParams);
            $zalo->sendBookingMessage($bookingRequest);
        } catch (\Exception $e) {
            dd('An error occurred while sending a message to the user: ' . $e->getMessage());
        }
    }

    public function sendOAMessageFromAdminToClinic($booking)
    {
        try {
            $clinicAccessToken = $booking->clinic->users->extend['access_token_zalo'] ?? "";
            if (!$clinicAccessToken) {
                return;
            }
            $admin = User::whereHas('roles', function ($query) {
                $query->where('name', 'ADMIN');
            })
                ->whereNotNull('extend->access_token_zalo')
                ->first();
            $adminAccessToken = $admin->extend['access_token_zalo'];
            $zalo = new ZaloController($adminAccessToken);
            $additionalParams = [
                'user_id' => $clinicAccessToken,
                'booking_clinic' => $booking->clinic->name,
                'booking_clinic_id' => $booking->clinic_id,
                'user_name' => $booking->user->name . ' ' . $booking->user->last_name,
                'booking_clinic_checkin' => date('d/m/Y h:i A', strtotime($booking->check_in))
            ];
            $request = new Request();
            $bookingRequest = $request->duplicate()->merge($additionalParams);
            $zalo->sendBookingMessage($bookingRequest, true);
        } catch (\Exception $e) {
            dd('An error occurred while sending an OA message from admin to clinic: ' . $e->getMessage());
        }
    }

    public function insertQRCodeIntoPDF($pdfPath, $qrCode, $booking, $doctorName, $doctorSignature)
    {
        $filePath = $pdfPath;

        $outputDirectory = public_path('storage/bookings_result');
        if (!is_dir($outputDirectory)) {
            mkdir($outputDirectory, 0755, true);
        }

        $outputFilePath = $outputDirectory . '/' . basename($filePath);

        $this->fillPdfFile(public_path($filePath), $outputFilePath, $qrCode, $booking, $doctorName, $doctorSignature);

        return response()->json(['message' => 'QR code inserted into PDF successfully.']);
    }

    public function fillPdfFile($file, $outputFilePath, $qrCode, $booking, $doctorName, $doctorSignature)
    {
        try {
            $fpdi = new Fpdi();
            $pageCount = $fpdi->setSourceFile($file);

            // Save the PNG image to a temporary file
            if ($qrCode) {
                $imageDirectory = public_path('storage/doctor_qr');
                if (!is_dir($imageDirectory)) {
                    mkdir($imageDirectory, 0755, true);
                }
                // Save the PNG image to a temporary file
                $imagePath = $imageDirectory . '/qr_code.png';
                file_put_contents($imagePath, $qrCode);
            }

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $template = $fpdi->importPage($pageNo);
                $size = $fpdi->getTemplateSize($template);
                $fpdi->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $fpdi->useTemplate($template);

                // Chỉ chèn mã QR và các thông tin khác vào trang cuối cùng
                if ($pageNo == $pageCount) {
                    $right = $size['width'] - 10; // Vị trí bên phải
                    $bottom = $size['height'] - 10; // Vị trí dưới cùng

                    $fpdi->AddFont('arial-unicode-ms', '', 'arial-unicode-ms.php', public_path('fonts'));
                    $fpdi->SetFont('arial-unicode-ms', '', 10, '', true);
                    $fpdi->SetTextColor(0, 0, 0);

                    $dateString = $booking->check_out;
                    $timestamp = strtotime($dateString);

                    $day = date("d", $timestamp);
                    $month = date("m", $timestamp);
                    $year = date("Y", $timestamp);

                    // Chèn thông tin ngày tháng
                    $textLine1 = iconv('UTF-8', 'cp1258', 'Ngày ' . $day . ' tháng ' . $month . ' Năm ' . $year);
                    $fpdi->SetXY($right - $fpdi->GetStringWidth($textLine1), $bottom - 38);
                    $fpdi->Cell(0, 0, $textLine1, 0, 0, 'C');

                    // Chèn tên bác sĩ và chữ ký nếu có
                    if ($doctorName) {
                        $textLine2 = iconv('UTF-8', 'cp1258', 'Bác sỹ kết luận');
                        $fpdi->SetXY($right - $fpdi->GetStringWidth($textLine2) - 20, $bottom - 33);
                        $fpdi->Cell(0, 0, $textLine2, 0, 0, 'C');

                        $textLine3 = iconv('UTF-8', 'cp1258', $doctorName);
                        $fpdi->SetFont('arial-unicode-ms', '', 9, '', true);
                        $fpdi->SetXY($right - $fpdi->GetStringWidth($textLine3) - 33, $bottom - 27);
                        $fpdi->Cell(0, 0, $textLine3, 0, 0, 'C');

                        if ($doctorSignature) {
                            $signaturePath = public_path($doctorSignature);
                            $signatureWidth = 60;
                            $signatureHeight = 20;
                            $signatureX = $right - $signatureWidth;
                            $signatureY = $bottom - 20;
                            $fpdi->Image($signaturePath, $signatureX, $signatureY, $signatureWidth, $signatureHeight);
                        }
                    }

                    // Chèn mã QR vào trang cuối cùng
                    if ($qrCode) {
                        $imageWidth = 30;
                        $imageHeight = 30;
                        $fpdi->Image($imagePath, 10, $bottom - $imageHeight, $imageWidth, $imageHeight);
                    }
                }
            }

            $fpdi->Output($outputFilePath, 'F');
        } catch (Exception $e) {
            // Handle any errors that occur during the PDF generation
            dd($e->getMessage());
        }
    }
}
