<?php

namespace App\Http\Controllers\ui;

use App\Enums\BookingResultStatus;
use App\Enums\BookingStatus;
use App\Enums\CartStatus;
use App\Enums\ServiceClinicStatus;
use App\ExportExcel\BookingExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\restapi\BookingResultApi;
use App\Models\Booking;
use App\Models\BookingResult;
use App\Models\Cart;
use App\Models\Clinic;
use App\Models\Commune;
use App\Models\Department;
use App\Models\District;
use App\Models\FamilyManagement;
use App\Models\PrescriptionResults;
use App\Models\Province;
use App\Models\ServiceClinic;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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

        if ($request->filled('insurance')) {
            if ($request->input('insurance') == 'no') {
                $query->where(function ($query) {
                    $query->where('bookings.insurance_use', 'no')
                        ->orWhereNull('bookings.insurance_use');
                });
            } else {
                $query->where('bookings.insurance_use', $request->input('insurance'));
            }
        }

        if ($request->excel == 2) {
            $bookings = $query->get();
            foreach ($bookings as $item){
                $insurance = '';
                if($item->insurance_use == 'no' || is_null($item->insurance_use)){
                    $insurance = "Không sử dụng bảo hiểm";
                }else if($item->insurance_use == 'yes' && is_null($item->member_family_id)){
                    $insurance = Auth::user()->insurance_id;
                }else if($item->insurance_use == 'yes' && $item->member_family_id !== null){
                    $insurance = $item->insurance_family_id;

                }

                $familyMember = FamilyManagement::find($item->member_family_id)->name ?? '';
                if(is_null($item->member_family_id)){
                    $bookingFor = 'Bản thân';
                }else{
                    $bookingFor = 'Người nhà: ' . $familyMember;
                }

                $user = User::find($item->user_id);
                $district = District::find($user->district_id)->full_name??'';
                $province = Province::find($user->province_id)->full_name??'';
                $communes = Commune::find($user->commune_id)->full_name??'';
                $detail_address = $user->detail_address??'';
                $item->name_clinic = Clinic::where('id',$item->clinic_id)->pluck('name')->first();
                $service_name = explode(',', $item->service);
                $services = ServiceClinic::whereIn('id', $service_name)->get();
                $service_names = $services->pluck('name')->implode(', ');
                $item->service_names = $service_names;
                $item->phone = $user->phone;
                $item->address = $detail_address.', '.$communes.', '.$district.', '.$province;
                $item->booking_for = $bookingFor;
                $item->insurance = $insurance;
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

    public function listBookingApi($userId){
        $user = User::find($userId);

        // Check if the user exists and if is_check_medical_history is true
        if (!$user || !$user->is_check_medical_history) {
            return response()->json([]);
        }

        $bookings = Booking::where('bookings.status', '!=', BookingStatus::DELETE)
            ->where('bookings.user_id', ($userId))
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
        $data_product = [];
        $prescription_result = PrescriptionResults::where('booking_id',$id)->first();
        if (isset($prescription_result)){
            $data_product = json_decode($prescription_result->prescriptions, true);
        }
        return view('ui.my-bookings.detail-booking', compact('booking','data_product'));
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

    public function addCart(Request $request,$id){
        try{
            $booking = Booking::find($id);
            $medicines = $request->get('medicines');
            if (isset($medicines) && count($medicines)>0){
                $dataUser = User::find($booking->user_id);
                foreach ($medicines as $val){
                    Cart::create([
                        'product_id' => $val['medicine_id_hidden'],
                        'quantity' => $val['quantity'],
                        'user_id' => $dataUser->id,
                        'type_product' => 'MEDICINE',
                        'status' => CartStatus::PENDING,
                        'note' => $val['detail_value'] ?? "",
                        'treatment_days' => $val['treatment_days'] ?? 0,
                        'remind_remain' => $val['treatment_days'] ?? 0,
                        'doctor_id' =>  $booking->doctor_id??$booking->clinic_id,
                        'prescription_id'=>$id
                    ]);
                }
            }

            return redirect()->route('user.checkout.index', ['prescription_id' => $id]);
        }catch (\Exception $e){
            dd($e->getMessage());
        }
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
    public function downloadPDF($id)
    {
        $data_prescription = PrescriptionResults::where('booking_id',$id)->first();

        if (!$data_prescription) {
            return redirect()->back()->withErrors('Đơn thuốc không tồn tại.');
        }

        $doctor_name = User::find($data_prescription->created_by);
        $user_name = User::find($data_prescription->user_id);
        $pdf = Pdf::loadView('components.head.pdf',['doctor' => $doctor_name->name,
                    'data' => json_decode($data_prescription->prescriptions, true),
                    'user_name' => $user_name->name,]);

        return $pdf->download('donthuoc.pdf');
    }
}
