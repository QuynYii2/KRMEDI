<?php

namespace App\Http\Controllers;

use App\Enums\SettingStatus;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function create(Request $request)
    {
        try {
            $facebook = $request->input('facebook');
            $twitter = $request->input('twitter');
            $instagram = $request->input('instagram');
            $zalo = $request->input('zalo');
            $kakao = $request->input('kakao');

            $socialLinks = [
                'facebook' => $facebook,
                'twitter' => $twitter,
                'instagram' => $instagram,
                'zalo' => $zalo,
                'kakao' => $kakao,
            ];
            $listSocialLinks = implode(',', $socialLinks);
            if ($request->hasFile('logo')) {
                $logoPaths = array_map(function ($image) {
                    $itemPath = $image->store('logos', 'public');
                    return asset('storage/' . $itemPath);
                }, $request->file('logo'));
                $logo = implode(',', $logoPaths);
            } else {
                $logo = '';
            }

            if ($request->hasFile('ad_banner_position')) {
                $adBannerPaths = array_map(function ($image) {
                    $itemPath = $image->store('ad_banners', 'public');
                    return asset('storage/' . $itemPath);
                }, $request->file('ad_banner_position'));
                $ad_banner_position = implode(',', $adBannerPaths);
            } else {
                $ad_banner_position = '';
            }

            if ($request->hasFile('favicon')) {
                $faviconPaths = array_map(function ($image) {
                    $itemPath = $image->store('favicons', 'public');
                    return asset('storage/' . $itemPath);
                }, $request->file('favicon'));
                $favicon = implode(',', $faviconPaths);
            } else {
                $favicon = '';
            }

            $ad_banner_link = $request->file('ad_banner_link');
            $ad_banner_follow = $request->input('ad_banner_follow');

            $translate = new TranslateController();

            $website_description = $request->input('website_description');

            $website_description_en = $translate->translateText($website_description, 'en');
            $website_description_laos = $translate->translateText($website_description, 'lo');

            $address = $request->input('address');
            $phone = $request->input('phone');
            $email = $request->input('email');

            $setting = new Setting();
            $setting->logo = $logo;
            $setting->ad_banner_position = $ad_banner_position;
            $setting->ad_banner_link = 1;
            $setting->ad_banner_follow = 1;
            $setting->address = $address;
            $setting->phone = $phone;
            $setting->email = $email;
            $setting->social_links = $listSocialLinks;
            $setting->website_description = $website_description;
            $setting->website_description_en = $website_description_en;
            $setting->website_description_laos = $website_description_laos;
            $setting->favicon = $favicon;
            $setting->save();

            alert()->success('Success', 'Create success!');
            return back();
        } catch (\Exception $exception) {
            alert()->error('Error', 'Error, Please try again!');
            return back();
        }
    }

    public function update(Request $request, string $id)
    {
        try {

            $setting = Setting::find($id);
            if (!$setting || $setting->status == SettingStatus::DELETED) {
                return response('Not found', 404);
            }

            $facebook = $request->input('facebook');
            $twitter = $request->input('twitter');
            $instagram = $request->input('instagram');
            $zalo = $request->input('zalo');
            $kakao = $request->input('kakao');

            $socialLinks = [
                'facebook' => $facebook,
                'twitter' => $twitter,
                'instagram' => $instagram,
                'zalo' => $zalo,
                'kakao' => $kakao,
            ];
            $listSocialLinks = implode(',', $socialLinks);

            if ($request->hasFile('logo')) {
                $logoPaths = array_map(function ($image) {
                    $itemPath = $image->store('logos', 'public');
                    return asset('storage/' . $itemPath);
                }, $request->file('logo'));
                $logo = implode(',', $logoPaths);
            } else {
                $logo = $setting->logo;
            }

            if ($request->hasFile('ad_banner_position')) {
                $adBannerPaths = array_map(function ($image) {
                    $itemPath = $image->store('ad_banners', 'public');
                    return asset('storage/' . $itemPath);
                }, $request->file('ad_banner_position'));
                $ad_banner_position = implode(',', $adBannerPaths);
            } else {
                $ad_banner_position = $setting->ad_banner_position;
            }

            if ($request->hasFile('favicon')) {
                $faviconPaths = array_map(function ($image) {
                    $itemPath = $image->store('favicons', 'public');
                    return asset('storage/' . $itemPath);
                }, $request->file('favicon'));
                $favicon = implode(',', $faviconPaths);
            } else {
                $favicon = $setting->favicon;
            }

            $ad_banner_link = $request->input('ad_banner_link');
            $ad_banner_follow = $request->input('ad_banner_follow');

            $translate = new TranslateController();

            $website_description = $request->input('website_description');

            $website_description_en = $translate->translateText($website_description, 'en');
            $website_description_laos = $translate->translateText($website_description, 'lo');

            $address = $request->input('address');
            $phone = $request->input('phone');
            $email = $request->input('email');

            $setting->logo = $logo;
            $setting->ad_banner_position = $ad_banner_position;
            $setting->ad_banner_link = 1;
            $setting->ad_banner_follow = 1;
            $setting->address = $address;
            $setting->phone = $phone;
            $setting->email = $email;
            $setting->social_links = $listSocialLinks;
            $setting->website_description = $website_description;
            $setting->website_description_en = $website_description_en;
            $setting->website_description_laos = $website_description_laos;
            $setting->favicon = $favicon;
            $setting->save();

            alert()->success('Success', 'Update success!');
            return back();
        } catch (\Exception $exception) {
            alert()->error('Error', 'Update error!');
            return back();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try {
            $setting = Setting::find($id);
            if (!$setting || $setting->status == SettingStatus::DELETED) {
                return response('Not found', 404);
            }

            $setting->status = SettingStatus::DELETED;
            $success = $setting->save();
            if ($success) {
                alert()->success('Delete success!');
                return back();
            }
            return response(');Delete error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }
}
