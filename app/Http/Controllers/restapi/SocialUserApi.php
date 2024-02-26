<?php

namespace App\Http\Controllers\restapi;

use App\Enums\SocialUserStatus;
use App\Http\Controllers\Controller;
use App\Models\SocialUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialUserApi extends Controller
{
    public function getAll(Request $request)
    {
        $socialUsers = SocialUser::where('status', SocialUserStatus::ACTIVE)->get();
        return response()->json($socialUsers);
    }

    public function getById(Request $request, $id)
    {
        $socialUser = SocialUser::find($id);
        if (!$socialUser || $socialUser->status != SocialUserStatus::ACTIVE) {
            return response('Not found', 404);
        }
        return response()->json($socialUser);
    }

    public function getByUserId(Request $request, $userID)
    {
        $socialUser = SocialUser::where('user_id', $userID)->first();
        if (!$socialUser || $socialUser->status != SocialUserStatus::ACTIVE) {
            return response('Not found', 404);
        }
        return response()->json($socialUser);
    }

    public function create(Request $request)
    {
        try {
            $socialUser = new SocialUser();

            $userID = $request->input('user_id');

            $user = User::find($userID);
            if (!$user) {
                return response('User not found', 404);
            }

            $socialUser = $this->processSave($socialUser, $request);

            $success = $socialUser->save();
            if ($success) {
                return response()->json($socialUser);
            }
            return response('Create error', 400);
        } catch (Exception $exception) {
            return response($exception, 400);
        }
    }

    private function processSave($socialUser, Request $request)
    {
        $userID = $request->input('user_id');

        $socialUser->user_id = $userID;
        $linkChecks = [
            'instagram' => '/^(https?:\/\/)?(www\.)?instagram\.com\/.*$/',
            'facebook' => '/^(https?:\/\/)?(www\.)?facebook\.com\/.*$/',
            'tiktok' => '/^(https?:\/\/)?(www\.)?tiktok\.com\/.*$/',
            'youtube' => '/^(https?:\/\/)?(www\.)?youtube\.com\/.*$/',
            'google_review' => '/^(https?:\/\/)?(www\.)?google\.com\/.*$/',
        ];

        $socialUser->facebook = $request->input('facebook');
        $socialUser->instagram = $request->input('instagram');

        $socialUser->youtube = $request->input('youtube');
        $socialUser->tiktok = $request->input('tiktok');

        $socialUser->google_review = $request->input('google_review');

        $socialUser->other = $request->input('other');

        $socialUser->status = SocialUserStatus::ACTIVE;

        return $socialUser;
    }

    public function update(Request $request, $id)
    {
        try {
            $socialUser = SocialUser::find($id);
            if (!$socialUser || $socialUser->status != SocialUserStatus::ACTIVE) {
                return response('Not found', 404);
            }

            $userID = $request->input('user_id');
            $user = User::find($userID);
            if (!$user) {
                return response('User not found', 404);
            }

            $socialUser = $this->processSave($socialUser, $request);

            $success = $socialUser->save();
            if ($success) {
                return response()->json($socialUser);
            }
            return response('Update error', 400);
        } catch (Exception $exception) {
            return response($exception, 400);
        }
    }

    public function delete($id)
    {
        try {
            $socialUser = SocialUser::find($id);
            if (!$socialUser || $socialUser->status != SocialUserStatus::ACTIVE) {
                return response('Not found', 404);
            }

            $socialUser->status = SocialUserStatus::DELETED;

            $success = $socialUser->save();
            if ($success) {
                return response()->json($socialUser);
            }
            return response('Delete error', 400);
        } catch (Exception $exception) {
            return response($exception, 400);
        }
    }

    public function createOrEdit(Request $request)
    {
        try {
            $socialUser = SocialUser::where('user_id', Auth::user()->id)->first();
            if (!$socialUser || $socialUser->status != SocialUserStatus::ACTIVE) {
                $socialUser = new SocialUser();
            }

            $socialUser = $this->processSave($socialUser, $request);

            $success = $socialUser->save();
            if ($success) {
                return response()->json($socialUser);
            }
            return response('Update error', 400);
        } catch (Exception $exception) {
            return response($exception, 400);
        }
    }

    public function getSocialByUserId($userId)
    {
        $data = SocialUser::where('user_id', $userId)->get();

        return response()->json($data);
    }
}
