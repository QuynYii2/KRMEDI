<?php

namespace App\Http\Controllers;

use App\Enums\BookingStatus;
use App\Enums\ClinicStatus;
use App\Enums\DepartmentStatus;
use App\Enums\ReviewStatus;
use App\Enums\ServiceClinicStatus;
use App\Enums\SymptomStatus;
use App\Enums\TypeUser;
use App\Http\Controllers\restapi\BookingApi;
use App\Http\Controllers\restapi\MainApi;
use App\Models\Booking;
use App\Models\Clinic;
use App\Models\Department;
use App\Models\Review;
use App\Models\ServiceClinic;
use App\Models\SurveyAnswerUser;
use App\Models\Symptom;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClinicController extends Controller
{
    public function show($id)
    {
        $clinics = Clinic::find($id);
        if (!$clinics || $clinics->status != ClinicStatus::ACTIVE) {
            return response("Product not found", 404);
        }
        return response()->json($clinics, $id);
    }


    public function showNear()
    {
    }

    public function index()
    {
        if ($this->check_mobile()){
            return view('clinics.listClinicsMobile');
        }else{
            return view('clinics.listClinics');
        }
    }

    public function detail($id)
    {
        $bookings = Clinic::find($id);
        $reviews = Review::where('clinic_id', $id)->where('status', ReviewStatus::APPROVED)->get();
        if (Auth::check()) {
            $userId = Auth::user()->id;
            if (!$bookings || $bookings->status != ClinicStatus::ACTIVE) {
                return response("Product not found", 404);
            }
            if ($userId) {
                $memberFamily = \DB::table('family_management')
                    ->where('user_id', Auth::user()->id)
                    ->get();
                $services = ServiceClinic::where('status', ServiceClinicStatus::ACTIVE)->get();
                return view('clinics.detailClinics', compact(
                    'id',
                    'bookings',
                    'services',
                    'reviews',
                    'memberFamily',
                    'userId'
                ));
            }
        }
        if (!$bookings || $bookings->status != ClinicStatus::ACTIVE) {
            return response("Product not found", 404);
        }

        $questionByDepartment =

            $services = ServiceClinic::where('status', ServiceClinicStatus::ACTIVE)->get();
        return view('clinics.detailClinics', compact('id', 'bookings', 'services', 'reviews'));
    }

    public function create()
    {
        $departments = Department::where('status', DepartmentStatus::ACTIVE)->get();
        $symptoms = Symptom::where('status', SymptomStatus::ACTIVE)->get();
        $services = ServiceClinic::where('status', ServiceClinicStatus::ACTIVE)->get();
        $doctorLists = User::where('member', TypeUser::DOCTORS)->get();
        return view('admin.clinic.tab-create-clinics', compact('services', 'departments', 'symptoms', 'doctorLists'));
    }

    public function edit($id)
    {
        $clinic = Clinic::find($id);
        $reflector = new \ReflectionClass('App\Enums\TypeTimeWork');
        $types = $reflector->getConstants();
        $services = ServiceClinic::where('status', ServiceClinicStatus::ACTIVE)->get();
        $departments = Department::where('status', DepartmentStatus::ACTIVE)->get();
        $symptoms = Symptom::where('status', SymptomStatus::ACTIVE)->get();
        $doctorLists = User::where('member', TypeUser::DOCTORS)->get();

        $address = explode(',', $clinic->address);

        $provinceId = $address[1];
        $districtId = $address[2];
        $communeId = $address[3];
        return view('admin.clinic.tab-edit-clinics', compact('clinic', 'types', 'services', 'departments', 'symptoms', 'doctorLists', 'provinceId', 'districtId', 'communeId'));
    }

    public function booking($id)
    {
        $bookings = Clinic::find($id);
        if (!$bookings || $bookings->status != ClinicStatus::ACTIVE) {
            return response("Product not found", 404);
        }
        return view('component.tab-booking.tab-booking', compact('id', 'bookings'));
    }

    public function bookingService($id)
    {
        $bookingSv = Clinic::find($id);
        if (!$bookingSv || $bookingSv->status != ClinicStatus::ACTIVE) {
            return response("Product not found", 404);
        }
        return view('component.tab-booking.booking-service', compact('id', 'bookingSv'));
    }

    public function selectDate($id)
    {
        $bookingSv = Clinic::find($id);
        if (!$bookingSv || $bookingSv->status != ClinicStatus::ACTIVE) {
            return response("Product not found", 404);
        }
        return view('component.tab-booking.select-date', compact('id', 'bookingSv'));
    }

    public function store(Request $request)
    {
        try {
            if (!Auth::check()) {
                alert()->error('Error', 'Please login to booking.');
                return back();
            } else {
                if ($request->input('member_family_id')) {
                    if ($request->input('member_family_id') == 'family') {
                        alert()->error('Error', 'Bạn chưa chọn thành viên trong gia đình!');
                        return back();
                    } elseif ($request->input('member_family_id') == 'myself') {
                        $request->merge(['member_family_id' => null]);
                    }
                }
                $bookingApi = new BookingApi();
                $requestData = $request->except('_token');
                $request->merge($requestData);
                $user = User::find($request->user_id);
                if (!$user || $user->type == 'MEDICAL' || $user->type == 'BUSINESS') {
                    alert()->error('Error', 'Not permission!');
                    return back();
                }
                $booking = $bookingApi->createBooking($request);
                if ($booking->getStatusCode() == 200) {
                    $data_booking = $booking->getData()->data;
                    $user = User::find($data_booking->user_id);
                    $clinic = Clinic::find($data_booking->clinic_id);
                    $specialist = Department::find($data_booking->department_id);
//                    $this->sendZaloMessageBooking($booking,$user,$clinic,$specialist->name);
                    alert()->success('Success', 'Đặt lịch thành công.');
                    return back()->with('success', 'Đặt lịch thành công');
                }
                alert()->error('Error', json_decode($booking->getContent())->message ?? "Đặt lịch thất bại");
                return back()->with('error', 'Đặt lịch thất bại');
            }
        } catch (\Exception $e) {
            alert()->error('Error', $e->getMessage());
            return back()->with('error', 'Đặt lịch thất bại');
        }
    }

    private function storeAnswerSurveyUser($arrInput, $bookingId)
    {
        $arrInput = json_decode($arrInput);
        if (is_array($arrInput) || is_object($arrInput)) {
            foreach ($arrInput as $item) {
                $answerSurveyUser = new SurveyAnswerUser();
                $answerSurveyUser->result = $item;
                $answerSurveyUser->booking_id = $bookingId;
                $answerSurveyUser->user_id = Auth::id();
                $answerSurveyUser->save();
            }
        }
    }
}
