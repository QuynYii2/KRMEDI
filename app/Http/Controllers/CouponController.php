<?php

namespace App\Http\Controllers;

use App\Enums\CouponStatus;
use App\Http\Controllers\restapi\MainApi;
use App\Models\Clinic;
use App\Models\Coupon;
use App\Models\CouponApply;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    public static function checkAndUpdateExpiredStatus()
    {
        $now = Carbon::now();
        $coupons = Coupon::where('end_evaluate', '<', $now)->get();
        foreach ($coupons as $voucher) {
            $voucher->status = CouponStatus::DELETED;
            $voucher->save();
        }
    }

    public static function isWithinTimeRange($start, $end)
    {
        $now = time();
        $currentDateTime = new DateTime();
        $currentDateTimeString = $currentDateTime->format('Y-m-d H:i:s');
        return ($start <= $currentDateTimeString && $currentDateTimeString <= $end);
    }

    public function show($id)
    {
        $coupon = Coupon::find($id);
        if (!$coupon || $coupon->status != CouponStatus::ACTIVE) {
            return response("coupon not found", 404);
        }
        return response()->json($coupon, $id);
    }

    public function index()
    {
        return view('clinics.listClinics');
    }

    public function detail($id)
    {
        return view('clinics.detailClinics', compact('id'));
    }

    public function create()
    {
        return view('admin.coupon.tab-create-coupon');
    }

    public function edit($id)
    {
        $coupon = Coupon::find($id);
        if (!$coupon) {
            return response("coupon not found", 404);
        }
        $isAdmin = $this->isAdmin();
        return view('admin.coupon.tab-edit-coupon', compact('coupon', 'isAdmin'));
    }

    public function isAdmin()
    {
        $role_user = RoleUser::where('user_id', Auth::user()->id)->first();

        $roleNames = Role::where('id', $role_user->role_id)->pluck('name');

        if ($roleNames->contains('ADMIN')) {
            return true;
        } else {
            return false;
        }
    }

    public function getListCoupon($user_id = null, $status = null)
    {
        $isAdmin = User::isAdmin($user_id);

        if ($isAdmin) {
            if ($status) {
                $coupons = Coupon::where('status', $status)->orderBy('id', 'desc')->get();
            } else {
                $coupons = Coupon::where('status', '!=', CouponStatus::DELETED)->orderBy('id', 'desc')->get();
            }

            return response()->json($coupons);

        } else {
            $clinic = Clinic::where('user_id', $user_id)->first();
            // tìm clinic của user nay, nếu có thì lấy ra tất cả các coupon của clinic đó
            if (!$clinic) {
                return response((new MainApi())->returnMessage("Clinic not found"), 404);
            }
            $coupons = Coupon::where('clinic_id', $clinic->id);
        }

        if ($status) {
            $coupons = $coupons->where('status', $status);
        }

        $coupons = $coupons->get();

        return response()->json($coupons);
    }

    public function getListCouponApplied($user_id = null, $status = null)
    {
        if ($user_id) {
            $listCoupon = DB::table('coupon_applies')
                ->where('coupon_applies.user_id', $user_id);
        } else {
            $listCoupon = DB::table('coupon_applies')
                ->where('coupon_applies.user_id', Auth::user()->id);
        }

        if ($status) {
            $listCoupon = $listCoupon->where('coupon_applies.status', $status);
        }

        $listCoupon = $listCoupon->join('coupons', 'coupons.id', '=', 'coupon_applies.coupon_id')
            ->where('coupons.status', '!=', CouponStatus::DELETED)
            ->select('coupon_applies.*');

        $listCoupon = $listCoupon->get();

        return response()->json($listCoupon);
    }

    public function getListUserAppliedCoupon(Request $request)
    {
        $status = $request->status;
        $coupon_id = $request->coupon_id;

        if (!$coupon_id) {
            return response((new MainApi())->returnMessage("Coupon not found"), 404);
        }

        $couponInfo = Coupon::find($coupon_id);

        if (!$couponInfo || !$couponInfo->status || $couponInfo->status == CouponStatus::DELETED) {
            return response((new MainApi())->returnMessage("Coupon đã bị xóa"), 404);
        }

        $listCoupon = CouponApply::where('coupon_id', $coupon_id);

        if ($status) {
            $listCoupon = $listCoupon->where('status', $status);
        }


        $listCoupon = $listCoupon->get();

        return response()->json($listCoupon);
    }

}
