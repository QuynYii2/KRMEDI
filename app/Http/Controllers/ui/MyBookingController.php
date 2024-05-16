<?php

namespace App\Http\Controllers\ui;

use App\Enums\BookingResultStatus;
use App\Enums\BookingStatus;
use App\Enums\ServiceClinicStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\restapi\BookingResultApi;
use App\Models\Booking;
use App\Models\BookingResult;
use App\Models\Department;
use App\Models\ServiceClinic;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MyBookingController extends Controller
{
    public function listBooking(Request $request, $status)
    {
        $bookings = Booking::where('status', '!=', BookingStatus::DELETE)
            ->where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc');
        if ($status && $status !== 'all') {
            $bookings = $bookings->where('department_id', $status);
        }
        $bookings = $bookings->paginate(20);
        $department_id = Booking::where('status', '!=', BookingStatus::DELETE)
            ->where('user_id', Auth::user()->id)->distinct('department_id')->pluck('department_id')->toArray();
        $department = Department::whereIn('id', $department_id)->get();

        return view('ui.my-bookings.list-booking', compact('bookings', 'department', 'status'));
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
}
