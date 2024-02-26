<?php

namespace App\Http\Controllers;

use App\Enums\CouponApplyStatus;
use App\Enums\CouponStatus;
use App\Enums\TypeUser;
use App\Models\Coupon;
use App\Models\CouponApply;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\SocialUser;
use App\Models\User;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;

class MainController extends Controller
{
    public function checkAdmin()
    {
        $adminRole = ['ADMIN'];
        return $this->checkRoles($adminRole);
    }

    private function checkRoles($roleNames)
    {
        $hasRole = false;
        if (Auth::check()) {
            $user = Auth::user();
            $role_user = DB::table('role_users')->where('user_id', $user->id)->first();
            $userRoleNames = Role::where('id', $role_user->role_id)->pluck('name');

            foreach ($roleNames as $roleName) {
                if ($userRoleNames->contains($roleName)) {
                    $hasRole = true;
                    break;
                }
            }
        }
        return $hasRole;
    }


    function vn_to_str($str)
    {

        $unicode = array(

            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',

            'd' => 'đ',

            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',

            'i' => 'í|ì|ỉ|ĩ|ị',

            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',

            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',

            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',

            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

            'D' => 'Đ',

            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',

            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',

        );

        foreach ($unicode as $nonUnicode => $uni) {

            $str = preg_replace("/($uni)/i", $nonUnicode, $str);

        }
        $str = str_replace(' ', '_', $str);

        return $str;

    }

    public function checkBusiness()
    {
        $businessRoles = [
            'PHARMACEUTICAL COMPANIES',
            'HOSPITALS',
            'CLINICS',
            'PHARMACIES',
            'SPAS',
            'OTHERS',
            'ADMIN'
        ];

        return $this->checkRoles($businessRoles);
    }

    public function checkMedical()
    {
        $medicalRoles = [
            'DOCTORS',
            'PHAMACISTS',
            'THERAPISTS',
            'ESTHETICIANS',
            'NURSES',
            'PHARMACEUTICAL COMPANIES',
            'HOSPITALS',
            'CLINICS',
            'PHARMACIES',
            'SPAS',
            'OTHERS',
            'ADMIN'
        ];

        return $this->checkRoles($medicalRoles);
    }

    public function switchMember($member)
    {
        switch ($member) {
            case 'PHARMACEUTICAL_COMPANIES':
                $role = Role::where('name', \App\Enums\Role::PHARMACEUTICAL_COMPANIES)->first();
                $type = TypeUser::PHARMACEUTICAL_COMPANIES;
                break;
            case 'HOSPITALS':
                $role = Role::where('name', \App\Enums\Role::HOSPITALS)->first();
                $type = TypeUser::HOSPITALS;
                break;
            case 'CLINICS':
                $role = Role::where('name', \App\Enums\Role::CLINICS)->first();
                $type = TypeUser::CLINICS;
                break;
            case 'PHARMACIES':
                $role = Role::where('name', \App\Enums\Role::PHARMACIES)->first();
                $type = TypeUser::PHARMACIES;
                break;
            case 'SPAS':
                $role = Role::where('name', \App\Enums\Role::SPAS)->first();
                $type = TypeUser::SPAS;
                break;
            default:
                $role = Role::where('name', \App\Enums\Role::OTHERS)->first();
                $type = TypeUser::OTHERS;
                break;
        }

        return [$role, $type];
    }

    public function createRoleUser($member, $username)
    {
        $role = Role::where('name', $member)->first();
        $newUser = User::where('username', $username)->first();
        if ($role) {
            RoleUser::create([
                'role_id' => $role->id,
                'user_id' => $newUser->id
            ]);
        } else {
            $roleNormal = Role::where('name', \App\Enums\Role::PAITENTS)->first();
            RoleUser::create([
                'role_id' => $roleNormal->id,
                'user_id' => $newUser->id
            ]);
        }
    }

    public function setLanguage(Request $request, $locale)
    {
        switch ($locale) {
            case 'vi':
                $lang = 'vi';
                break;
            case 'laos':
                $lang = 'laos';
                break;
            default:
                $lang = 'en';
                break;
        }
        Session::put('locale', $lang);
        return redirect()->back();
    }

    public function generateRandomString($length)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function generateRandomNumber($length)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function removeCouponExpiredAndAddCouponActive()
    {
        $nowTime = Carbon::now()->addHours(7);
        Coupon::where('end_evaluate', '<=', $nowTime)
            ->where('status', CouponStatus::ACTIVE)
            ->update(['status' => CouponStatus::DELETED]);
        Coupon::where('end_evaluate', '>', $nowTime)
            ->where('startDate', '<=', $nowTime)
            ->update(['status' => CouponStatus::ACTIVE]);
    }

    public function parsedToken($token)
    {
//        $parsedToken = JWTAuth::setToken($token)->parseToken();
//        if ($parsedToken->check()) {
//            try {
//                JWTAuth::invalidate($token);
//            } catch (Exception $exception){
//
//            }
//        }
    }

    public function setCouponForUser($userID)
    {
        $user = User::find($userID);
        $coupon = Coupon::where('status', CouponStatus::ACTIVE)
            ->where('user_id', '!=', $userID)
            ->inRandomOrder()
            ->first();

        if ($user && $coupon) {
            $name = $user->username;
            $email = $user->email;
            $phone = $user->phone;
            $content = '';
            $user_id = $userID;
            $coupon_id = $coupon->id;

            $social = SocialUser::where('user_id', $userID)->first();
            if ($social) {
                $sns_option = $social->facebook ?? $social->youtube ?? $social->tiktok ?? $social->instagram;

                $couponApply = new CouponApply();

                $couponApply->name = $name;
                $couponApply->email = $email;
                $couponApply->phone = $phone;
                $couponApply->content = $content;
                $couponApply->user_id = $user_id;
                $couponApply->coupon_id = $coupon_id;
                $couponApply->sns_option = $sns_option;
                $couponApply->link_ = $social->facebook ?? $social->youtube ?? $social->tiktok ?? $social->instagram;
                $couponApply->status = CouponApplyStatus::VALID;
                $couponApply->is_apply = false;

                $old_coupon = CouponApply::where('user_id', $user_id)
                    ->where('status', CouponApplyStatus::VALID)
                    ->where('is_apply', false)
                    ->first();
                if (!$old_coupon) {
                    $couponApply->save();
                }
            }
        }
    }
}
