<?php

namespace App\Http\Controllers\ui;

use App\Enums\BookingResultStatus;
use App\Enums\BookingStatus;
use App\Enums\ServiceClinicStatus;
use App\ExportExcel\BookingExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\restapi\BookingResultApi;
use App\Models\Booking;
use App\Models\BookingResult;
use App\Models\Clinic;
use App\Models\Department;
use App\Models\ServiceClinic;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MyBookingController extends Controller
{
    public function listBooking(Request $request)
    {
        $query = Booking::where('bookings.status', '!=', BookingStatus::DELETE)
            ->where('bookings.user_id', Auth::user()->id)
            ->orderBy('bookings.id', 'desc');
        if ($request->filled('key_search')) {
            $key_search = $request->input('key_search');
            $query->join('clinics', 'bookings.clinic_id', '=', 'clinics.id')
                ->select('bookings.*', 'clinics.name as clinic_name')
                ->where('clinics.name', 'LIKE', "%$key_search%");
        }

        if ($request->filled('date_range')) {
            $dates = explode(' - ', $request->input('date_range'));
            $start_date = $dates[0];
            $end_date = $dates[1];
            $query->whereDate('bookings.check_in', '>=', $start_date)
                ->whereDate('bookings.check_in', '<=', $end_date);
        }

        if ($request->filled('specialist')) {
            $query->where('bookings.department_id', $request->input('specialist'));
        }

        if ($request->filled('service')) {
            $serviceId = $request->input('service');
            $query->whereRaw("FIND_IN_SET(?, bookings.service)", [$serviceId]);
        }

        if ($request->filled('status')) {
            $query->where('bookings.status', $request->input('status'));
        }

        if ($request->excel == 2) {
            $bookings = $query->get();
            foreach ($bookings as $item){
                $item->name_clinic = Clinic::where('id',$item->clinic_id)->pluck('name')->first();
                $service_name = explode(',', $item->service);
                $services = ServiceClinic::whereIn('id', $service_name)->get();
                $service_names = $services->pluck('name')->implode(', ');
                $item->service_names = $service_names;
            }
            return Excel::download(new BookingExport($bookings), 'lichsukham.xlsx');
        } else {
            $bookings = $query->paginate(20);
        }
        $department_id = Booking::where('status', '!=', BookingStatus::DELETE)
            ->where('user_id', Auth::user()->id)->distinct('department_id')->pluck('department_id')->toArray();
        $department = Department::whereIn('id',$department_id)->get();
        $service = ServiceClinic::all();

        return view('ui.my-bookings.list-booking', compact('bookings','department','service'));
    }

    public function listBookingApi(Request $request){
        $bookings = Booking::where('bookings.status', '!=', BookingStatus::DELETE)
            ->where('bookings.user_id', ($request->user_id))
            ->orderBy('bookings.id', 'desc')->get();

        foreach ($bookings as $item){
            $item->name_clinic = Clinic::where('id',$item->clinic_id)->pluck('name')->first();
            $service_name = explode(',', $item->service);
            $services = ServiceClinic::whereIn('id', $service_name)->get();
            $service_names = $services->pluck('name')->implode(', ');
            $item->service_names = $service_names;
        }
        return response()->json($bookings);
    }

    public function detailBooking(Request $request, $id)
    {
        $booking = Booking::find($id);
        if (!$booking || $booking->status == BookingStatus::DELETE) {
            alert()->warning('Not found booking!');
            return back();
        }
        return view('ui.my-bookings.detail-booking', compact('booking'));
    }

    public function bookingResult(Request $request, $id)
    {
        $result = BookingResult::where('booking_id', $id)->first();
        if (!$result || $result->status == BookingResultStatus::DELETED) {
            alert()->warning('Not found result!');
            return back();
        }
        $services = ServiceClinic::where('status', ServiceClinicStatus::ACTIVE)->get();

        $value_result = '[' . $result->result . ']';
        $array_result = json_decode($value_result, true);
        return view('ui.my-bookings.result', compact('result', 'array_result', 'services', 'result'));
    }

    public function listProductResult(Request $request, $id)
    {
        $result = BookingResult::where('booking_id', $id)->first();
        if (!$result || $result->status == BookingResultStatus::DELETED) {
            alert()->warning('Not found result!');
            return back();
        }

        $file_excel = $result->prescriptions;

        if (!$file_excel) {
            alert()->warning('No prescriptions and products!');
            return back();
        }
        $products = (new BookingResultApi())->getListProductFromExcel($file_excel);
        return view('ui.my-bookings.list-products', compact('products'));
    }

    public function showBookingQr($id)
    {
        $booking = Booking::find($id);
        if (!$booking || $booking->status == BookingStatus::DELETE) {
            alert()->warning('Not found booking!');
            return back();
        }
        return view('ui.my-bookings.show-booking', compact('booking'));
    }

    public function generateQrCode($id)
    {
        $url = route('web.users.my.bookings.show', $id);
        $qrCodes = QrCode::size(300)->generate($url);
        return view('ui.my-bookings.qr-booking', compact('qrCodes', 'id'));
    }

    public function downloadQrCode($id)
    {
        $url = route('web.users.my.bookings.show', $id);
        $qrCode = QrCode::size(300)
            ->errorCorrection('H')
            ->generate($url);
        $filename = 'img/qr-code/qrcode-default.png';
        $path = public_path($filename);

        file_put_contents($path, $qrCode);

        return Response::download($path, 'my-qrcode.jpg');
    }

    public function fileBookingResult($id)
    {
        try {
            $booking = Booking::findOrFail($id);

            $bookingFiles = $booking->extend['booking_results'] ?? [];

            if (empty($bookingFiles)) {
                return response()->json(['error' => -1, 'message' => 'An error occurred while getting booking files.']);
            }

            return view('ui.my-bookings.file-booking-result', compact('bookingFiles'));
        } catch (Throwable $e) {
            return response()->json(['error' => -1, 'message' => $e->getMessage()]);
        }
    }

    public function medicalHistoryApi($id)
    {
        $user = User::find($id);

        if ($user) {
            return response()->json($user->is_check_medical_history);
        } else {
            return response()->json(['message' => 'User not found.'], 404);
        }
    }

    public function updateMedicalHistoryApi(Request $request, $id)
    {
        $validated = $request->validate([
            'is_check_medical_history' => 'required',
        ]);

        $user = User::find($id);

        if ($user) {
            $user->is_check_medical_history = $validated['is_check_medical_history'];
            $user->save();

            return response()->json(['message' => 'Medical history updated successfully.']);
        } else {
            return response()->json(['message' => 'User not found.'], 404);
        }
    }
//    public function getToken(Request $request)
//    {
//        return response()->json(['csrfToken' => csrf_token()]);
//    }
}
