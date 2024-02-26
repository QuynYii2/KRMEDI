<?php

namespace App\Http\Controllers\backend;

use App\Enums\CouponStatus;
use App\Enums\TypeCoupon;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use App\Models\Clinic;
use App\Models\Coupon;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BackendCouponController extends Controller
{

    public function getAll($type = null)
    {
        if ($this->isAdmin()) {
            $coupons = Coupon::where('status', '!=', CouponStatus::DELETED)
                ->orderBy('created_at', 'desc');
        } else {
            if (Auth::user()->manager_id) {
                $clinic_id = Clinic::where('user_id', Auth::user()->manager_id)->pluck('id');
            } else {
                $clinic_id = Clinic::where('user_id', Auth::user()->id)->pluck('id');
            }
            $coupons = Coupon::whereIn('clinic_id', $clinic_id)
                ->where('status', '!=', CouponStatus::DELETED)
                ->orderBy('created_at', 'desc');
        }

        if ($type) {
            $coupons = $coupons->where('type', $type);
        }

        $coupons = $coupons->get();

        return response()->json($coupons);
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

    public function getListCouponForUser(Request $request)
    {
        $type = $request->input('type');
        if ($type) {
            $coupons = Coupon::where('status', '=', CouponStatus::ACTIVE)
                ->where('type', $type)
                ->get();
        } else {
            $coupons = Coupon::where('status', '=', CouponStatus::ACTIVE)->get();
        }
        return response()->json($coupons);
    }

    public function getAllByUserID(Request $request, $id)
    {
        $status = $request->input('status');
        if ($status) {
            $coupons = Coupon::where('status', $status)->where('user_id', $id)->get();
        } else {
            $coupons = Coupon::where('status', '!=', CouponStatus::DELETED)->where('user_id', $id)->get();
        }
        return response()->json($coupons);
    }

    public function getByCode($code)
    {
        $coupon = Coupon::where('code', 'like', '%' . $code . '%')->first();
        if (!$coupon || $coupon->status == CouponStatus::DELETED) {
            return response('Not found', 404);
        }
        return response()->json($coupon);
    }

    public function search(Request $request)
    {
        $title = $request->input('title');
        $code = $request->input('code');
        $user_id = $request->input('user_id');
        $status = $request->input('status');

        $query = [];

        if ($title) {
            $str = ['title', 'like', '%' . $title . '%'];
            array_push($query, $str);
        }
        if ($status) {
            $str = ['status', '=', $status];
            array_push($query, $str);
        }

        if ($code) {
            $str = ['code', 'like', '%' . $code . '%'];
            array_push($query, $str);
        }

        if ($user_id) {
            $str = ['user_id', '=', $user_id];
            array_push($query, $str);
        }

        if (!$title && !$status && !$code && !$user_id) {
            $coupons = Coupon::where('status', '!=', CouponStatus::DELETED)->get();
        } else {
            $coupons = Coupon::where($query)->get();
        }

        return response()->json($coupons);
    }

    public function detail($id)
    {
        $coupon = Coupon::find($id);
        if (!$coupon || $coupon->status == CouponStatus::DELETED) {
            return response('Coupon đã bị xóa', 404);
        }
        $coupon->views = $coupon->views + 1;
        $coupon->save();
        return response()->json($coupon);
    }

    public function create(Request $request)
    {
        try {

            /* admin làm tất :v */
            if ($this->isAdmin()) {
                $coupon = new Coupon();
                $this->saveCoupon($coupon, $request);
            } else {
                return response('You do not have permission to create a coupon!', 400);
            }

            /* phân quyền  user nào được đăng coupon */
//            $type = $request->input('type');
//            $user_id = $request->input('user_id');
//            $user = User::find($user_id);
//            $exitCoupons = Coupon::where('user_id', $user_id)->where('status',CouponStatus::ACTIVE)->get();
//            if ($this->isAdmin()) {
//                foreach ($exitCoupons as $exitCoupon) {
//                    if ($type == $exitCoupon->type && $type== TypeCoupon::FREE_MISSION) {
//                        return response('You have an FREE MISSION coupon!', 400);
//                    }
//                    elseif ($type == $exitCoupon->type && $type== TypeCoupon::FREE_TODAY) {
//
//                        return response('You have an FREE TODAY coupon!', 400);
//                    }
//                    elseif ($type == $exitCoupon->type && $type== TypeCoupon::DISCOUNT_SERVICE) {
//                        return response('You have an DISCOUNT SERVICE coupon!', 400);
//                    }
//                }
//            }
//            $coupon = new Coupon();
//            if ($this->isAdmin() || $user->member == 'HOSPITALS' || $user->member == 'PHARMACIES'
//                || $user->member == 'CLINICS') {
//                $this->saveCoupon($coupon, $request);
//            }


            return response()->json($coupon);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    private function saveCoupon($coupon, $request)
    {
        $title = $request->input('title');
        $description = $request->input('description');
        $short_description = $request->input('short_description');
        $condition = $request->input('condition');
        $conduct = $request->input('conduct');
        $instruction = $request->input('instruction');
        $website = $request->input('website');


        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $start_selective = $request->input('start_selective');
        $end_selective = $request->input('end_selective');
        $start_post = $request->input('start_post');
        $end_post = $request->input('end_post');
        $start_evaluate = $request->input('start_evaluate');
        $end_evaluate = $request->input('end_evaluate');

        $is_tiktok = $request->input('is_tiktok');
        $is_facebook = $request->input('is_facebook');
        $is_google = $request->input('is_google');
        $is_youtube = $request->input('is_youtube');
        $is_instagram = $request->input('is_instagram');

        $max_register = $request->input('max_register');

        $user_id = $request->input('user_id');

        $clinic_id = $request->input('clinic_id');
        $type = $request->input('type');

        $status = $request->input('status');
        if (!$status) {
            if ($this->isAdmin()) {
                $status = CouponStatus::ACTIVE;
            } else {
                $status = CouponStatus::PENDING;
            }
        }

        $code = 'CP' . $user_id . (new MainController())->generateRandomString(8);

        if ($request->hasFile('thumbnail')) {
            $item = $request->file('thumbnail');
            $itemPath = $item->store('coupon', 'public');
            $thumbnail = asset('storage/' . $itemPath);
        } else {
            $thumbnail = $coupon->thumbnail;
        }


        $coupon->title = $title;
        $coupon->condition = $condition;
        $coupon->conduct = $conduct;
        $coupon->description = $description;
        $coupon->short_description = $short_description;
        $coupon->instruction = $instruction;
        $coupon->website = $website;


        $coupon->startDate = $startDate;
        $coupon->endDate = $endDate;
        $coupon->start_selective = $start_selective;
        $coupon->end_selective = $end_selective;
        $coupon->start_post = $start_post;
        $coupon->end_post = $end_post;
        $coupon->start_evaluate = $start_evaluate;
        $coupon->end_evaluate = $end_evaluate;

        $coupon->is_tiktok = $is_tiktok ? 1 : 0;
        $coupon->is_facebook = $is_facebook ? 1 : 0;
        $coupon->is_google = $is_google ? 1 : 0;
        $coupon->is_youtube = $is_youtube ? 1 : 0;
        $coupon->is_instagram = $is_instagram ? 1 : 0;


        $coupon->max_register = $max_register;
        $coupon->type = $type;

        $coupon->user_id = $user_id;

        $coupon->status = $status;
        $coupon->code = $code;
        $coupon->thumbnail = $thumbnail;
        $coupon->clinic_id = $clinic_id;


        $success = $coupon->save();
    }

    public function update(Request $request, $id)
    {
        try {
            if (!$this->isAdmin()) {
                return response('You do not have permission to update a coupon!', 400);
            }
            $coupon = Coupon::find($id);
            if (!$coupon) {
                return response('Not found!', 404);
            }

            $this->saveCoupon($coupon, $request);

            return response()->json($coupon);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function delete($id)
    {
        try {
            $coupon = Coupon::find($id);
            if (!$coupon || $coupon->status == CouponStatus::DELETED) {
                return response('Not found', 404);
            }

            $coupon->status = CouponStatus::DELETED;
            $success = $coupon->save();
            if ($success) {
                return response('Delete success!', 200);
            }
            return response('Delete error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }
}
