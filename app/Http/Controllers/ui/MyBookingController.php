<?php

namespace App\Http\Controllers\ui;

use App\Enums\BookingResultStatus;
use App\Enums\BookingStatus;
use App\Enums\ServiceClinicStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\restapi\BookingResultApi;
use App\Models\Booking;
use App\Models\BookingResult;
use App\Models\ServiceClinic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MyBookingController extends Controller
{
    public function listBooking(Request $request)
    {
        $bookings = Booking::where('status', '!=', BookingStatus::DELETE)
            ->where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->paginate(20);
        return view('ui.my-bookings.list-booking', compact('bookings'));
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
}
