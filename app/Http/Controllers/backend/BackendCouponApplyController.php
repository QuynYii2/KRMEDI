<?php

namespace App\Http\Controllers\backend;

use App\Enums\CouponApplyStatus;
use App\Enums\CouponStatus;
use App\Enums\SocialUserStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Http\Controllers\restapi\MainApi;
use App\Models\Coupon;
use App\Models\CouponApply;
use App\Models\SocialUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class BackendCouponApplyController extends Controller
{
    public function getAll(Request $request)
    {
        $status = $request->input('status');
        if ($status) {
            $couponApplies = CouponApply::where('status', $status)->get();
        } else {
            $couponApplies = CouponApply::where('status', '!=', CouponApplyStatus::DELETED)->get();
        }
        return response()->json($couponApplies);
    }

    public function getAllByUser(Request $request, $id)
    {
        $status = $request->input('status');
        if ($status) {
            $couponApplies = CouponApply::where('status', $status)->where('user_id', $id)->get();
        } else {
            $couponApplies = CouponApply::where('status', '!=', CouponApplyStatus::DELETED)->where('user_id',
                $id)->get();
        }

        $infoCoupon = [];

        foreach ($couponApplies as $couponApply) {
            $coupon = Coupon::where('id', $couponApply->coupon_id)->select('title', 'views', 'registered', 'max_register', 'thumbnail')->first();
            array_push($infoCoupon, $coupon);
        }

        $data = [
            'couponApplies' => $couponApplies,
            'infoCoupon' => $infoCoupon
        ];

        return response()->json($data);
    }

    public function listMyCoupons(Request $request)
    {
        $id = $request->input('user_id') ?? Auth::user()->id;
        $status = $request->input('status');
        if ($status) {
            $couponApplies = DB::table('coupon_applies')
                ->where('status', $status)
                ->where('user_id', $id)
                ->orderByDesc('id')
                ->cursor()
                ->map(function ($couponApply) {
                    $item = (array)$couponApply;
                    $coupon = Coupon::find($couponApply->coupon_id);
                    $item['coupon_info'] = $coupon;
                    return $item;
                });
        } else {
            $couponApplies = DB::table('coupon_applies')
                ->where('status', '!=', CouponApplyStatus::DELETED)
                ->where('user_id', $id)
                ->orderByDesc('id')
                ->cursor()
                ->map(function ($couponApply) {
                    $item = (array)$couponApply;
                    $coupon = Coupon::find($couponApply->coupon_id);
                    $item['coupon_info'] = $coupon;
                    return $item;
                });
        }


        return response()->json($couponApplies);
    }

    public function detail($id)
    {
        $couponApply = CouponApply::find($id);
        if (!$couponApply || $couponApply->status == CouponApplyStatus::DELETED) {
            return response('Not found', 404);
        }
        return response()->json($couponApply);
    }

    public function create(Request $request)
    {
        try {
            $couponApply = new CouponApply();

            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $content = $request->input('content');
            $user_id = $request->input('user_id');
            $coupon_id = $request->input('coupon_id');

            $SocialUser = SocialUser::where('user_id', $user_id)
                ->where('status', SocialUserStatus::ACTIVE)
                ->first();

            $my_array = null;
            $instagram = $SocialUser->instagram ? $my_array[] = 'instagram' : 0;
            $facebook = $SocialUser->facebook ? $my_array[] = 'facebook' : 0;
            $tiktok = $SocialUser->tiktok ? $my_array[] = 'tiktok' : 0;
            $youtube = $SocialUser->youtube ? $my_array[] = 'youtube' : 0;
            $google = $SocialUser->google_review ? $my_array[] = 'google_review' : 0;

            $coupon = Coupon::find($coupon_id);

            $your_array = null;
            $instagram = $coupon->is_instagram == 1 ? $your_array[] = 'instagram' : 0;
            $facebook = $coupon->is_facebook == 1 ? $your_array[] = 'facebook' : 0;
            $tiktok = $coupon->is_tiktok == 1 ? $your_array[] = 'tiktok' : 0;
            $youtube = $coupon->is_youtube == 1 ? $your_array[] = 'youtube' : 0;
            $google = $coupon->is_google == 1 ? $your_array[] = 'google_review' : 0;
            //check sns option not null
            $text = null;
            $is_valid = true;
            foreach ($your_array as $item) {
                if (!in_array($item, $my_array)) {
                    $is_valid = false;
                    $text = $item;
                    break;
                }
            }

            if (!$is_valid) {
                return response((new MainApi())->returnMessage('link social ' . $text . ' not empty'), 400);
            }

            // kiểm tra name, email, phone, content not null
            if (!$name || !$email || !$phone) {
                return response((new MainApi())->returnMessage('invalid email or name or phone'), 400);
            }
            foreach ($your_array as $item) {
                $link = SocialUser::where('user_id', $user_id)->value($item); // Assuming you want to get the value of the field
                if ($link) {
                    $your_links[] = $link;
                }
                $your_string = implode(', ', $your_array);
            }
//            $link = SocialUser::where('user_id', $user_id)->first();

            $couponApply->name = $name;
            $couponApply->email = $email;
            $couponApply->phone = $phone;
//            $couponApply->content = $content;
            $couponApply->user_id = $user_id;
            $couponApply->coupon_id = $coupon_id;
            $couponApply->sns_option = $your_string;
            $couponApply->link_ = implode(', ', $your_links);
            $couponApply->status = CouponApplyStatus::PENDING;
            if (!$coupon || $coupon->status != CouponStatus::ACTIVE) {
                return response((new MainApi())->returnMessage('Coupon not found!'), 404);
            }

            $coupon->registered = $coupon->registered + 1;

            $success = $couponApply->save();

            (new MailController())->sendEmail($email, 'support.il.vietnam@gmail.com', 'Register success',
                'Thank you for taking the time to consider our services');

            if ($success) {
                $coupon->save();
                return response()->json($couponApply);
            }
            return response('Create error!', 400);
        } catch (Exception $exception) {
            return response($exception, 400);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $couponApply = CouponApply::find($id);
            if (!$couponApply || $couponApply->status == CouponApplyStatus::DELETED) {
                return response('Not found', 404);
            }

            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $content = $request->input('content');
            $user_id = $request->input('user_id');
            $coupon_id = $request->input('coupon_id');

            $newCheck = false;
            if ($coupon_id == $couponApply->coupon_id) {
                $newCheck = true;
            }

            $couponApply->name = $name;
            $couponApply->email = $email;
            $couponApply->phone = $phone;
//            $couponApply->content = $content;
            $couponApply->user_id = $user_id;

            if ($newCheck == false) {
                $couponApply->coupon_id = $coupon_id;

                $coupon = Coupon::find($coupon_id);
                if (!$coupon || $coupon->status != CouponStatus::ACTIVE) {
                    return response('Coupon not found!', 404);
                }

                if ($coupon->max_register == 0) {
                    return response('The number of subscribers has reached the maximum!', 400);
                }

                if ($coupon->endDate > Carbon::now()->addHours(7) && $coupon->startDate < Carbon::now()->addHours(7)) {
                    $coupon->registered = $coupon->registered + 1;
                    $coupon->max_register = $coupon->max_register - 1;

                    if ($coupon->max_register == 0) {
                        $coupon->status = CouponStatus::INACTIVE;
                    }

                    $success = $couponApply->save();

                    if ($success) {
                        $coupon->save();
                        return response()->json($couponApply);
                    }
                    return response('Update error!', 400);
                }
                return response('Coupon not active!', 400);
            }

            $success = $couponApply->save();
            if ($success) {
                return response()->json($couponApply);
            }
            return response('Update error!', 400);
        } catch (Exception $exception) {
            return response($exception, 400);
        }
    }

    public function delete($id)
    {
        try {
            $couponApply = CouponApply::find($id);
            if (!$couponApply || $couponApply->status == CouponApplyStatus::DELETED) {
                return response('Not found', 404);
            }

            $couponApply->status = CouponApplyStatus::DELETED;

            $coupon = Coupon::find($couponApply->coupon_id);

            if ($coupon->endDate > Carbon::now()->addHours(7) && $coupon->startDate < Carbon::now()->addHours(7)) {
                $coupon->registered = $coupon->registered - 1;
                $coupon->max_register = $coupon->max_register + 1;
                $coupon->save();
            }

            $success = $couponApply->save();
            if ($success) {
                return response('Delete success!', 200);
            }
            return response('Delete error!', 400);
        } catch (Exception $exception) {
            return response($exception, 400);
        }
    }

    public function updateStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');

        $couponApply = CouponApply::find($id);
        if (!$couponApply) {
            return response('Not found', 404);
        }

        if ($couponApply->status == CouponApplyStatus::REWARDED) {
            return response('Không thể thay đổi trạng thái của bài đã trao giải', 400);
        }
        if ($couponApply->status == CouponApplyStatus::PENDING || $couponApply->status == CouponApplyStatus::INVALID) {
            $this->sendMailWhenValid($couponApply);
        }

        if ($status == CouponApplyStatus::REWARDED) {
            if ($couponApply->status == CouponApplyStatus::VALID) {
                $isMaxReward = $this->checkMaxRewardCoupon($couponApply->coupon_id);
                if ($isMaxReward) {
                    return response('Đã đủ số lượng trúng thưởng', 400);
                }
                $couponApply->status = CouponApplyStatus::REWARDED;
                $this->sendMailWhenReward($couponApply);
            } else {
                return response('Không thể trao giải cho bài không hợp lệ', 400);
            }
        } else {
            $couponApply->status = $status;
        }
        $couponApply->save();
        return response('Thay đổi thành công', 200);
    }

    public function checkMaxRewardCoupon($coupon_id)
    {
        $coupon = Coupon::find($coupon_id);
        $maxReward = $coupon->max_register;

        $couponApply = CouponApply::where('coupon_id', $coupon_id)->where('status', CouponApplyStatus::REWARDED)->count();
        if ($couponApply >= $maxReward) {
            return true;
        }
        return false;

    }

    public function sendMailWhenValid($couponApply)
    {
        $coupon = Coupon::where('id', $couponApply->coupon_id)->first();
        $donViPhatHanh = $coupon->user_id;

        $emailNguoiDungApply = $couponApply->email ?? '';
        $emailDonViPhatHanh = User::where('id', $donViPhatHanh)->first()->email ?? '';
        $emailAdmin = '';

        $emailFrom = 'support.il.vietnam@gmail.com';
        $title = 'Thông báo ứng tuyển thành công';
        $content = 'Chúc mừng bạn đã ứng tuyển thành công.
Yêu cầu bạn nhập link trong khung thời gian đăng bài để được đánh giá :
' . Url::signedRoute('what.free.reply.link', ['id' => $couponApply->id]);

        $listEmail = [];
        array_push($listEmail, $emailNguoiDungApply);
        array_push($listEmail, $emailDonViPhatHanh);
        array_push($listEmail, $emailAdmin);

        $mailController = new MailController();
        foreach ($listEmail as $email) {
            if ($email) {
                $mailController->sendEmail($email, $emailFrom, $title, $content);
            }
        }
    }
    public function sendMailWhenReward($couponApply)
    {
        $coupon = Coupon::where('id', $couponApply->coupon_id)->first();
        $donViPhatHanh = $coupon->user_id;

        $emailNguoiDungApply = $couponApply->email ?? '';
        $emailDonViPhatHanh = User::where('id', $donViPhatHanh)->first()->email ?? '';
        $emailAdmin = '';

        $emailFrom = 'support.il.vietnam@gmail.com';
        $title = 'Thông báo trúng thưởng';
        $content = 'Chúc mừng bạn đã trúng thưởng';

        $listEmail = [];
        array_push($listEmail, $emailNguoiDungApply);
        array_push($listEmail, $emailDonViPhatHanh);
        array_push($listEmail, $emailAdmin);

        $mailController = new MailController();
        foreach ($listEmail as $email) {
            if ($email) {
                $mailController->sendEmail($email, $emailFrom, $title, $content);
            }
        }
    }

}
