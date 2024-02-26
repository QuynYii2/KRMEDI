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

        $reflector = new \ReflectionClass('App\Enums\ReasonCancel');
        $reasons = $reflector->getConstants();

        if ($owner == Auth::id() || $isAdmin) {
            return view('admin.booking.tab-edit-booking', compact('bookings_edit', 'isAdmin', 'services', 'reasons'));
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
            $booking->status = BookingStatus::PENDING;
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
            return back('Create error', );
        } catch (\Exception $exception) {
            alert('Booking error');
            return back();
        }

    }

    public function update(Request $request, $id)
    {
        try {
            $booking = Booking::find($id);
            $status = $request->input('status');
            $is_result = $request->input('is_result');
            if (!$is_result) {
                $is_result = 0;
            }

            $booking->is_result = $is_result;
            $booking->status = $status;

            $reason = $request->input('reason_text');

            if ($status == BookingStatus::CANCEL) {
                $booking->reason_cancel = $reason;
            }

            $success = $booking->save();
            if ($success) {
                alert('Update success');
                return Redirect::route('homeAdmin.list.booking')->with('success', 'Booking success');
            }
            return response('Update error', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
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
}
