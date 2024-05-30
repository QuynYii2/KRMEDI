<?php

namespace App\Http\Controllers;

use App\Enums\BookingStatus;
use App\Enums\ClinicStatus;
use App\Enums\CouponApplyStatus;
use App\Enums\CouponStatus;
use App\Enums\MessageStatus;
use App\Enums\NewEventStatus;
use App\Enums\online_medicine\OnlineMedicineStatus;
use App\Enums\ProductStatus;
use App\Enums\ReviewStatus;
use App\Enums\QuestionStatus;
use App\Enums\SettingStatus;
use App\Enums\UserStatus;
use App\ExportExcel\BookingDoctorExport;
use App\Http\Controllers\Api\NotificationController;
use App\Models\Booking;
use App\Models\Chat;
use App\Models\Clinic;
use App\Models\Coupon;
use App\Models\CouponApply;
use App\Models\Department;
use App\Models\FamilyManagement;
use App\Models\NewEvent;
use App\Models\online_medicine\ProductMedicine;
use App\Models\ProductInfo;
use App\Models\Question;
use App\Models\Review;
use App\Models\ServiceClinic;
use App\Models\Setting;
use App\Models\User;

//use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use ReflectionClass;

class HomeController extends Controller
{

    public function index()
    {
        if (!Auth::check()) {
            setCookie('accessToken', null);
        }
        $coupons = Coupon::where('status', CouponStatus::ACTIVE)->paginate(6);
        $products = ProductMedicine::where('status', OnlineMedicineStatus::APPROVED)->orderBy(
            'id',
            'desc'
        )->paginate(4);
        $productsFlea = ProductInfo::where('status', ProductStatus::ACTIVE)->get();
        $medicines = ProductMedicine::where('product_medicines.status', OnlineMedicineStatus::APPROVED)
            ->leftJoin('users', 'product_medicines.user_id', '=', 'users.id')
            ->leftJoin('provinces', 'provinces.id', '=', 'users.province_id')
            ->select('product_medicines.*', 'provinces.name as location_name')
            ->paginate(15);

        $questions = Question::withCount('answers')->where('status', QuestionStatus::APPROVED)->orderBy(
            'answers_count',
            'desc'
        ) // Order by answer_count in descending order
            ->take(5)->get();
        $newEvens = NewEvent::where('status', NewEventStatus::ACTIVE)->orderBy('id', 'desc')->limit(4)->get();
        return view('home', compact('coupons', 'products', 'medicines', 'productsFlea', 'questions', 'newEvens'));
    }

    public function specialist()
    {
        $departments = \App\Models\Department::where('status', \App\Enums\DepartmentStatus::ACTIVE)->where('isFilter', 1)->get();
        return view('chuyen-khoa.tab-chuyen-khoa-newHome', compact('departments'));
    }

    public function specialistDepartment($id)
    {
        $q = request()->query('q');

        $doctorsSpecial = \App\Models\User::where('department_id', $id)
            ->where('status', \App\Enums\UserStatus::ACTIVE);

        if ($q) {
            $doctorsSpecial->where(function ($query) use ($q) {
                $query->where('name', 'LIKE', "%$q%")
                    ->orWhere('last_name', 'LIKE', "%$q%")
                    ->orWhere('email', 'LIKE', "%$q%")
                    ->orWhere('username', 'LIKE', "%$q%");
            });
        }

        $doctorsSpecial = $doctorsSpecial->paginate(12);

        $clinics = \App\Models\Clinic::whereRaw("FIND_IN_SET('$id', department)")
            ->where('type', \App\Enums\TypeBusiness::HOSPITALS)
            ->where('status', \App\Enums\ClinicStatus::ACTIVE);

        if ($q) {
            $clinics->where(function ($query) use ($q) {
                $query->where('name', 'LIKE', "%$q%")
                    ->orWhere('name_en', 'LIKE', "%$q%");
            });
        }

        $clinics = $clinics->get();

        $pharmacies = \App\Models\Clinic::whereRaw("FIND_IN_SET('$id', department)")
            ->where('type', \App\Enums\TypeBusiness::CLINICS)
            ->where('status', \App\Enums\ClinicStatus::ACTIVE);

        if ($q) {
            $pharmacies->where(function ($query) use ($q) {
                $query->where('name', 'LIKE', "%$q%")
                    ->orWhere('name_en', 'LIKE', "%$q%");
            });
        }

        $pharmacies = $pharmacies->get();
        if ($this->check_mobile()){
            return view('chuyen-khoa.danh-sach-theo-chuyen-khoa-mobile', compact('id', 'doctorsSpecial', 'clinics', 'pharmacies'));
        }else{
            return view('chuyen-khoa.danh-sach-theo-chuyen-khoa', compact('id', 'doctorsSpecial', 'clinics', 'pharmacies'));
        }
    }

    public function specialistDetail($id)
    {
        $clinicDetail = \App\Models\Clinic::where('id', $id)->first();
        return view('chuyen-khoa.detail-clinic-pharmacies', compact('clinicDetail', 'id'));
    }

    public function bookingDetailSpecialist($id)
    {
        $clinicDetail = Clinic::where('id', $id)->first();
        $arrayService = explode(',', $clinicDetail->service_id);
        $services = ServiceClinic::whereIn('id', $arrayService)->get();
        if (Auth::check()) {
            $userId = Auth::user()->id;
            if (!$clinicDetail || $clinicDetail->status != ClinicStatus::ACTIVE) {
                return response("Product not found", 404);
            }
            if ($userId) {
                $memberFamilys = FamilyManagement::with('users')
                    ->where('user_id', Auth::user()->id)
                    ->get();
            } else {
                $memberFamilys = null;
            }
            return view('clinics.booking-clinic-page', compact('clinicDetail', 'id', 'services', 'memberFamilys'));
        }
        alert('Bạn cần đăng nhập để đặt lịch khám');
        return redirect(route('home'));
    }

    public function specialistReview(Request $request, $id)
    {
        $clinic = Clinic::find($id);
        $cmt_review = $request->input('cmt_review');
        $star_number = $request->input('star_number');
        $cmt_store = new Review();
        $cmt_store->star = $star_number;
        $cmt_store->content = $cmt_review;
        $cmt_store->clinic_id = $id;
        $cmt_store->status = ReviewStatus::APPROVED;
        if (!Auth::user() == null) {
            $cmt_store->user_id = auth()->user()->id;
            $cmt_store->name = $clinic->name;
            $cmt_store->address = $clinic->address;
            $cmt_store->phone = $clinic->phone;
            $cmt_store->email = $clinic->email;
            $cmt_store->save();
            alert()->success('Đánh giá thành công');
            return redirect()->route('home.specialist.detail', $id);
        } else {
            alert()->error('Bạn cần đăng nhập để đánh giá');
            return redirect()->route('home.specialist.detail', $id);
        }
    }

    public function admin()
    {
        $productMedicines = ProductMedicine::where('status', OnlineMedicineStatus::PENDING)->get();
        $number = count($productMedicines);
        $isAdmin = (new MainController())->checkAdmin();
        return view('admin.home-admin', compact('number', 'isAdmin'));
    }

    public function listMessageUnseen()
    {
        // lấy tất cả tin nhắn chua doc cua user hien tai
        $messages = Chat::where([
            ['to_user_id', Auth::id()],
            ['message_status', MessageStatus::UNSEEN]
        ])->orderBy('created_at', 'desc')->get();
        $messages->map(function ($message) use ($messages) {

            $message->name_from = User::getNameByID($message->from_user_id);
            $message->avt = User::getAvtByID($message->from_user_id);
            $message->chat_message = $this->limitText($message->chat_message);
            $message->timeAgo = $this->textTimeAgo($message->created_at);
            $message->total = $messages->count();
        });

        return response()->json([
            'messages' => $messages,
        ]);
    }

    public function listChatUnseen()
    {
        $notificationController = app()->make(NotificationController::class);

        $request = new Request();
        $request->merge(['limit' => 4, 'user_id' => Auth::user()->id]);

        $notifications = $notificationController->index($request);

        $notificationData = json_decode($notifications->getContent())->data ?? [];

        $unseenNoti = json_decode($notifications->getContent())->unseenNoti ?? 0;
        $data_noti = [
            'notifications'=>$notificationData,
            'unseenNoti'=>$unseenNoti
        ];

        return response()->json([
            'data' => $data_noti,
        ]);
    }

    private function limitText($text, $maxLength = 255, $ellipsis = '...')
    {
        if (strlen($text) <= $maxLength) {
            return $text;
        } else {
            return substr($text, 0, $maxLength) . $ellipsis;
        }
    }

    private function textTimeAgo($createdAt)
    {
        $now = now();
        $timeDifference = $now->diffInMinutes($createdAt);

        if ($timeDifference < 60) {
            // Nếu thời gian nhỏ hơn 1 giờ
            $timeAgo = $timeDifference . ' phút trước';
        } elseif ($timeDifference >= 60 && $timeDifference < 1440) {
            // Nếu thời gian từ 1 giờ đến 24 giờ
            $hours = floor($timeDifference / 60);
            $timeAgo = $hours . ' giờ trước';
        } else {
            // Nếu thời gian sau 24 giờ
            $days = floor($timeDifference / 1440);
            $timeAgo = $days . ' ngày trước';
        }
        return $timeAgo;
    }

    public function userOnlineStatus()
    {
        if (!Auth::check()) {
            return null;
        }

        $users = User::where('id', '!=', Auth::id())->get();
        $listUserOnline = [];
        foreach ($users as $user) {
            if (Cache::has('user-is-online|' . $user->id)) {
                array_push($listUserOnline, $user);
            }
        }
        return $listUserOnline;
    }

    public function listProduct()
    {
        return view('admin.product.list-product');
    }

    public function listClinics()
    {
        $reflector = new ReflectionClass('App\Enums\TypeBusiness');
        $types = $reflector->getConstants();
        return view('admin.clinic.list-clinics', compact('types'));
    }

    public function listCoupon()
    {
        return view('admin.coupon.list-coupon');
    }

    public function listApplyCoupon($id)
    {
        $applyCoupons = CouponApply::where('coupon_id', $id)
            ->where('status', '!=', CouponApplyStatus::DELETED)
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('admin.coupon.tab-list-apply-coupon', compact('applyCoupons'));
    }

    public function listDoctor()
    {
        $reflector = new ReflectionClass('App\Enums\TypeMedical');
        $types = $reflector->getConstants();
        return view('admin.doctor.list-doctors', compact('types'));
    }

    public function listPhamacitis()
    {
        return view('admin.doctor.list-doctors');
    }

    public function listStaff()
    {
        $users = User::where('manager_id', Auth::id())->where('status', '!=', UserStatus::DELETED)->paginate(20);
        return view('admin.staff.list-staff', compact('users'));
    }

    public function listConfig()
    {
        $settingConfig = Setting::where('status', SettingStatus::ACTIVE)->first();
        return view('admin.setting-config.list-config', compact('settingConfig'));
    }

    public function listBooking(Request $request)
    {
        $isAdmin = (new MainController())->checkAdmin();
        if ($isAdmin) {
            $query = Booking::where('bookings.status', '!=', BookingStatus::DELETE)
                ->orderBy('bookings.created_at', 'desc');
        } else {
            $clinic = Clinic::where('user_id', Auth::user()->id)->first();
            $query = Booking::where('bookings.status', '!=', BookingStatus::DELETE)
                ->where('clinic_id', $clinic ? $clinic->id : '')
                ->orderBy('bookings.created_at', 'desc');
        }
        $id_user = $query->pluck('user_id')->unique()->toArray();
        if ($request->filled('key_search')) {
            $key_search = $request->input('key_search');
            $query->join('clinics', 'bookings.clinic_id', '=', 'clinics.id')
                ->join('users', 'bookings.user_id', '=', 'users.id')
                ->select('bookings.*', 'clinics.name as clinic_name', 'users.name as user_name')
                ->where(function ($q) use ($key_search) {
                    $q->where('clinics.name', 'LIKE', "%$key_search%")
                        ->orWhere('users.name', 'LIKE', "%$key_search%");
                });
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

        if ($request->filled('user_id')) {
            $query->where('bookings.user_id', $request->input('user_id'));
        }

        if ($request->excel == 2) {
            $bookings = $query->get();
            foreach ($bookings as $item) {
                $item->user_name = User::find($item->user_id)->name;
                $item->name_clinic = Clinic::where('id', $item->clinic_id)->pluck('name')->first();
                $item->department = Department::find($item->department_id)->name;
                $item->doctor_name = User::find($item->doctor_id)->username ?? '';
            }
            return Excel::download(new BookingDoctorExport($bookings), 'lichsukham.xlsx');
        } else {
            $bookings = $query->paginate(20);
        }

        $department = Department::all();
        $service = ServiceClinic::all();
        $users = User::whereIn('id',$id_user)->get();

        return view('admin.booking.list-booking', compact('bookings', 'service', 'department','users'));
    }

    public function listBookingDoctor(Request $request)
    {
        $baseQuery = Booking::join('clinics', 'bookings.clinic_id', '=', 'clinics.id')
            ->join('users as users_patient', 'bookings.user_id', '=', 'users_patient.id')
            ->select('bookings.*', 'clinics.name as clinic_name', 'users_patient.name as user_name')
            ->where('bookings.status', '!=', BookingStatus::DELETE);
        $subQuery = Booking::select('user_id')
            ->where('doctor_id', Auth::user()->id)
            ->where('is_check_medical_history', 1)
            ->groupBy('user_id');
        $query = $baseQuery->whereIn('bookings.user_id', $subQuery);
        $id_user = $query->pluck('user_id')->unique()->toArray();

        if ($request->filled('key_search')) {
            $key_search = $request->input('key_search');
            $query->where(function ($q) use ($key_search) {
                    $q->where('clinics.name', 'LIKE', "%$key_search%")
                        ->orWhere('users_patient.name', 'LIKE', "%$key_search%");
                });
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

        if ($request->filled('user_id')) {
            $query->where('bookings.user_id', $request->input('user_id'));
        }

        if ($request->excel == 2) {
            $bookings = $query->orderBy('bookings.created_at','desc')->get();
            foreach ($bookings as $item) {
                $item->user_name = User::find($item->user_id)->name;
                $item->name_clinic = Clinic::where('id', $item->clinic_id)->pluck('name')->first();
                $item->department = Department::find($item->department_id)->name;
                $item->doctor_name = User::find($item->doctor_id)->username ?? '';
            }
            return Excel::download(new BookingDoctorExport($bookings), 'lichsukham.xlsx');
        } else {
            $bookings = $query->orderBy('bookings.created_at','desc')->paginate(20);
        }

        $department = Department::all();
        $service = ServiceClinic::all();
        $users = User::whereIn('id',$id_user)->get();

        return view('admin.booking.list-booking', compact('bookings', 'service', 'department','users'));
    }
}
