<?php

namespace App\Http\Controllers;

use App\Enums\CouponStatus;
use App\Enums\SocialUserStatus;
use App\Enums\TypeCoupon;
use App\Models\Clinic;
use App\Models\Coupon;
use App\Models\CouponApply;
use App\Models\SocialUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WhatFreeToDay extends Controller
{
    public function index()
    {
        $nameSearch = request('search-input');
        $activeCouponsQuery = Coupon::where('status', '=', CouponStatus::ACTIVE);
        $now = now('Asia/Ho_Chi_Minh');
        $coupons = $activeCouponsQuery->whereIn('type', TypeCoupon::getArray())
            ->where('end_evaluate', '>', $now)
            ->orderBy('created_at', 'desc');

        if (!empty($nameSearch)) {
            $coupons->where('title', 'LIKE', '%' . $nameSearch . '%');
        }
        $coupons = $coupons->get();
        $coupons_freeToDay = $coupons->where('type', TypeCoupon::FREE_TODAY)->take(6);
        $coupons_withMission = $coupons->where('type', TypeCoupon::FREE_MISSION)->take(6);
        $coupons_discount = $coupons->where('type', TypeCoupon::DISCOUNT_SERVICE)->take(6);

        return view('What-free.what-free', compact('coupons_freeToDay', 'coupons_withMission', 'coupons_discount', 'nameSearch'));
    }

    public function toDay()
    {
        return view('What-free.tab-free-today');
    }

    public function withMission()
    {
        return view('What-free.tab-with-mission');
    }

    public function discountedSevice()
    {
        return view('What-free.tab-discounted-sevice');
    }

    public function detail($id)
    {
        $coupon = Coupon::where('id', $id)->first();
        $coupon->views = $coupon->views + 1;
        $coupon->save();
        $user_id = $coupon->user_id;
        $clinic = Clinic::where('user_id', $user_id)->first();
        if (Auth::check()) {
            $socials = SocialUser::where('user_id', Auth::user()->id)->where('status',
                SocialUserStatus::ACTIVE)->first();
        } else {
            $socials = '';
        }

        return view('What-free.detail-what-free', compact('coupon', 'clinic', 'socials'));
    }

    public function campaign()
    {
        return view('What-free.my-campaign');
    }


    public function seeAll($type)
    {
        $now = now('Asia/Ho_Chi_Minh');
        $coupons = Coupon::where('status', CouponStatus::ACTIVE)->where('type', $type)->where('endDate', '>',
            $now)->latest('created_at')->paginate(15);

        return view('What-free.tab-see-all', compact('coupons'));
    }

    public function replyLink($id)
    {
        return view('What-free.reply-mail-coupon-apply', compact( 'id'));
    }
    public function replyLinkSocial(Request $request, $id)
    {
        $couponApply = CouponApply::find($id);

        if ($couponApply) {
            $link_fb = $request->input('facebook');
            $link_tt = $request->input('tiktok');
            $link_ig = $request->input('instagram');
            $link_yt = $request->input('youtube');
            $link_gg = $request->input('google_review');

            $links = array_filter([$link_fb, $link_tt, $link_ig, $link_yt, $link_gg]);

            $content = implode(', ', $links);

            $couponApply->content = $content;

            $couponApply->save();
            alert()->success('Thành công', 'Cảm ơn bạn đã tham gia chương trình. Chúng tôi sẽ kiểm tra và thông báo kết quả cho bạn trong thời gian sớm nhất');
            return redirect()->route('home');
        } else {
            alert()->error('Lỗi', 'Không tìm thấy thông tin');
            return back();
        }
    }

}
