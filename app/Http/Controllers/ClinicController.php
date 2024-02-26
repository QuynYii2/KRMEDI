<?php

namespace App\Http\Controllers;

use App\Enums\BookingStatus;
use App\Enums\ClinicStatus;
use App\Enums\DepartmentStatus;
use App\Enums\ReviewStatus;
use App\Enums\ServiceClinicStatus;
use App\Enums\SymptomStatus;
use App\Enums\TypeUser;
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
        return view('clinics.listClinics');
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
                return view('clinics.detailClinics', compact('id', 'bookings', 'services',
                    'reviews', 'memberFamily', 'userId'));
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
        return view('admin.clinic.tab-edit-clinics', compact('clinic', 'types', 'services', 'departments', 'symptoms', 'doctorLists'));
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
            if (Auth::user() == null) {
                alert()->error('Error', 'Please login to booking.');
                return back();
            } else {
                $booking = new Booking();

                $booking = $this->createBooking($request, $booking);
                $user = User::find($booking->user_id);
                if (!$user || $user->type == 'MEDICAL' || $user->type == 'BUSINESS') {
                    alert()->error('Error', 'Not permission!');
                    return back();
                }
                $success = $booking->save();

                $bookingId = $booking->id;
                $this->storeAnswerSurveyUser($request->input('survey_text'), $bookingId);
                $this->storeAnswerSurveyUser($request->input('survey_checkbox'), $bookingId);
                $this->storeAnswerSurveyUser($request->input('survey_radio'), $bookingId);

                if ($success) {
                    alert()->success('Success', 'Booking success.');
                    return back()->with('success', 'Booking success');
                }
            }
            alert()->error('Error', 'Booking error.');
            return back()->with('error', 'Booking error');
        } catch (\Exception $exception) {
            alert()->error('Error', 'Please try again');
            return back()->with('error', 'Booking error');
        }
    }

    private function storeAnswerSurveyUser($arrInput, $bookingId)
    {
        $arrInput = json_decode($arrInput);
        foreach ($arrInput as $item) {
            $answerSurveyUser = new SurveyAnswerUser();
            $answerSurveyUser->result = $item;
            $answerSurveyUser->booking_id = $bookingId;
            $answerSurveyUser->user_id = Auth::id();
            $answerSurveyUser->save();
        }
    }

    public function createBooking(Request $request, $booking)
    {
        $userID = $request->input('user_id');
        $clinicID = $request->input('clinic_id');
        $doctor_id = $request->input('doctor_id');
        $department_id = $request->input('department_id');
        $service = $request->input('service') ?? '';
        $memberFamily = $request->input('member_family_id');
        $medical_history = $request->input('medical_history') ?? '';
        $consulting_form = $request->input('consulting_form');

        if (is_array($service)) {
            $servicesAsString = implode(',', $service);
        } else {
            $servicesAsString = $service;
        }

        $booking->doctor_id = $doctor_id;
        $booking->department_id = $department_id;

        if (is_array($medical_history)) {
            $medical_historyAsString = implode('&&', $medical_history);
        } else {
            $medical_historyAsString = $medical_history;
        }

        $time = $request->input('selectedTime');
        $timestamp = Carbon::parse($time);

        $booking->user_id = $userID;
        $booking->clinic_id = $clinicID;
        $booking->check_in = $timestamp;
        $booking->status = BookingStatus::PENDING;
        $booking->service = $servicesAsString;
        $booking->medical_history = $medical_historyAsString;
        $booking->member_family_id = $memberFamily;
        $booking->consulting_form = $consulting_form;

        return $booking;
    }
}
