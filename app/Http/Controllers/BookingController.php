<?php

namespace App\Http\Controllers;

use App\Enums\BookingStatus;
use App\Enums\ServiceClinicStatus;
use App\Enums\SurveyType;
use App\Enums\TypeProductCart;
use App\Http\Controllers\restapi\MainApi;
use App\Models\Booking;
use App\Models\BookingResult;
use App\Models\Clinic;
use App\Models\ServiceClinic;
use App\Models\SurveyAnswer;
use App\Models\SurveyAnswerUser;
use App\Models\SurveyQuestion;
use App\Models\WishList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\ZaloController;
use App\Jobs\booking\ChangeBookingStatus;
use App\Models\User;
use App\Models\ZaloFollower;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use setasign\Fpdi\Fpdi;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $bookings_edit = Booking::find($id);
        $owner = $bookings_edit->clinic->user_id;
        $serviceID = $bookings_edit->service;
        $arrayService = explode(',', $serviceID);
        $services = ServiceClinic::where('status', ServiceClinicStatus::ACTIVE)->get();
        $isAdmin = (new MainController())->checkAdmin();

        $userId = $bookings_edit->user_id;
        $userFollower = ZaloFollower::where('extend->user_id', $userId)->first();
        $user_zalo_id = $userFollower->user_id ?? 0;

        $doctor_id = null;
        $doctor_name = null;

        if (isset($bookings_edit->doctor_id) && $bookings_edit->doctor_id) {
            $doctor = User::find($bookings_edit->doctor_id);
            $doctor_id = $bookings_edit->doctor_id;
            $doctor_name = $doctor->name;
        }


        $reflector = new \ReflectionClass('App\Enums\ReasonCancel');
        $reasons = $reflector->getConstants();

        $repeaterItems = [];

        if (isset($bookings_edit->extend['booking_results'])) {
            foreach ($bookings_edit->extend['booking_results'] as $bookingResult) {
                $selectValue = $bookingResult['type'];
                $fileUrl = $bookingResult['url'];
                $doctorId = $bookingResult['doctor_id'];
                $doctorName = User::find($doctorId)->name;

                // Create a new repeater item array
                $item = [
                    'selectValue' => $selectValue,
                    'fileUrl' => $fileUrl,
                    'doctorId' => $doctorId,
                    'doctorName' => $doctorName,
                ];

                // Add the repeater item to the array
                $repeaterItems[] = $item;
            }
        }

        if ($owner == Auth::id() || $isAdmin) {
            return view('admin.booking.tab-edit-booking', compact('bookings_edit', 'isAdmin', 'services', 'reasons', 'repeaterItems', 'user_zalo_id', 'doctor_id', 'doctor_name'));
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
                alert('Booking success');
                return back()->with('success', 'Booking success');
            }
            alert('Booking error');
            return back('Create error',);
        } catch (\Exception $exception) {
            alert('Booking error');
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

            $bookingResults = $booking->extend['booking_results'] ?? [];

            $bookingResultList = $request->booking_result_list;

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
                            'file.*' => 'mimes:pdf',
                        ]);

                        if ($validator->fails()) {
                            alert('Error', 'Tài liệu phải là định dạng PDF', 'error');
                            return redirect()->back()->withErrors($validator)->withInput();
                        }

                        // Remove the old file if it exists new file
                        if (isset($bookingResults[$index]['url']) && Storage::exists(str_replace('/storage', 'public', $bookingResults[$index]['url'])) && isset($result['file'])) {
                            Storage::delete(str_replace('/storage', 'public', $bookingResults[$index]['url']));
                        }

                        // Handle the new file input
                        if (isset($result['file']) && $result['file']) {
                            $qrCode = null;
                            if (isset($result['doctor_id']) && $result['doctor_id']) {
                                $url = route('qr.code.show.doctor.info', $result['doctor_id']);
                                $qrCode = QrCode::format('png')->size(150)->generate($url);
                            }
                            $itemPath = $result['file']->store('bookings_result', 'public');
                            $fileUrl = asset('storage/' . $itemPath);

                            if ($fileUrl) {
                                $doctorName = User::find($result['doctor_id'])->name ?? "";
                                $this->insertQRCodeIntoPDF($fileUrl, $qrCode, $booking, $doctorName);
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
            }

            // Check if the status has changed
            if ($booking->status != $status || $isChange) {
                // Status has changed, send zalo OA msg to customer
                $isSendOaToUser = true;
            }

            // $booking->doctor_id = $doctor_id;
            $booking->is_result = $is_result;
            $booking->status = $status;

            $reason = $request->input('reason_text');

            if ($status == BookingStatus::CANCEL) {
                $booking->reason_cancel = $reason;
            }

            $success = $booking->save();
            if ($success) {
                if ($isSendOaToUser) {
                    //Queue on change booking status notifications
                    ChangeBookingStatus::dispatch($booking);
                }

                alert('Update success');
                return Redirect::route('api.backend.booking.edit', ['id' => $id])->with('success', 'Booking success');
            }
            return response()->json(['error' => 0, 'data' => $booking]);
        } catch (\Exception $e) {
            return response(['error' => -1, 'message' => $e->getMessage()], 400);
        }
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

    public function insertQRCodeIntoPDF($pdfPath, $qrCode, $booking, $doctorName)
    {
        $filePath = $pdfPath;

        $outputDirectory = public_path('storage/bookings_result');
        if (!is_dir($outputDirectory)) {
            mkdir($outputDirectory, 0755, true);
        }

        $outputFilePath = $outputDirectory . '/' . basename($filePath);

        $this->fillPdfFile(public_path($filePath), $outputFilePath, $qrCode, $booking, $doctorName);

        return response()->json(['message' => 'QR code inserted into PDF successfully.']);
    }

    public function fillPdfFile($file, $outputFilePath, $qrCode, $booking, $doctorName)
    {
        try {
            $fpdi = new Fpdi();
            $count = $fpdi->setSourceFile($file);

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

            $template = $fpdi->importPage($count);
            $size = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);

            $right = $size['width'] - 10; // Right position
            $bottom = $size['height'] - 10; // Bottom position

            $fpdi->AddFont('arial-unicode-ms', '', 'arial-unicode-ms.php', public_path('fonts'));

            $fpdi->SetFont('arial-unicode-ms', '', 10, '', true);
            $fpdi->SetTextColor(0, 0, 0);

            $dateString = $booking->check_out;
            $timestamp = strtotime($dateString);

            $day = date("d", $timestamp);
            $month = date("m", $timestamp);
            $year = date("Y", $timestamp);

            // Text
            $textLine1 = iconv('UTF-8', 'cp1258', 'Ngày ' . $day . ' tháng ' . $month . ' Năm ' . $year);
            $fpdi->SetXY($right - $fpdi->GetStringWidth($textLine1), $bottom - 38);
            $fpdi->Cell(0, 0, $textLine1, 0, 0, 'C');

            if ($doctorName) {
                $textLine2 = iconv('UTF-8', 'cp1258', 'Bác sỹ kết luận');
                $fpdi->SetXY($right - $fpdi->GetStringWidth($textLine2) - 20, $bottom - 33);
                $fpdi->Cell(0, 0, $textLine2, 0, 0, 'C');

                $textLine3 = iconv('UTF-8', 'cp1258', $doctorName);
                $fpdi->SetFont('arial-unicode-ms', '', 9, '', true);
                $fpdi->SetXY($right - $fpdi->GetStringWidth($textLine3) - 19, $bottom - 27);
                $fpdi->Cell(0, 0, $textLine3, 0, 0, 'C');
            }

            if ($qrCode) {
                $imageWidth = 30;
                $imageHeight = 30;
                $fpdi->Image($imagePath, 10, $bottom - $imageHeight, $imageWidth, $imageHeight);
            }

            $fpdi->Output($outputFilePath, 'F');
        } catch (Exception $e) {
            // Handle any errors that occur during the PDF generation
            dd($e->getMessage());
        }
    }
}
