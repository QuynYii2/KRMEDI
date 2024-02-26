<?php

namespace App\Http\Controllers\restapi;

use App\Enums\ShortVideoStatus;
use App\Http\Controllers\Controller;
use App\Models\ShortVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShortVideoApi extends Controller
{
    public function getAll()
    {
        $videos = DB::table('short_videos')
            ->join('users', 'users.id', '=', 'short_videos.user_id')
            ->where('short_videos.status', ShortVideoStatus::ACTIVE)
            ->orderBy('short_videos.id', 'desc')
            ->select('short_videos.*', 'users.username', 'users.name', 'users.avt')
            ->get();
        return response($videos);
    }

    public function getAllByUserID($id)
    {
        $videos = DB::table('short_videos')
            ->join('users', 'users.id', '=', 'short_videos.user_id')
            ->where('short_videos.status', ShortVideoStatus::ACTIVE)
            ->where('short_videos.user_id', $id)
            ->orderBy('short_videos.id', 'desc')
            ->select('short_videos.*', 'users.username', 'users.name', 'users.avt')
            ->get();
        return response($videos);
    }

    public function getAllByTopic($id)
    {
        $videos = DB::table('short_videos')
            ->join('users', 'users.id', '=', 'short_videos.user_id')
            ->where('short_videos.status', ShortVideoStatus::ACTIVE)
            ->where('short_videos.topic_id', $id)
            ->orderBy('short_videos.id', 'desc')
            ->select('short_videos.*', 'users.username', 'users.name', 'users.avt')
            ->get();
        return response($videos);
    }

    public function search(Request $request)
    {

    }

    public function detail($id)
    {
        $video = DB::table('short_videos')
            ->join('users', 'users.id', '=', 'short_videos.user_id')
            ->where('short_videos.status', ShortVideoStatus::ACTIVE)
            ->where('short_videos.id', $id)
            ->orderBy('short_videos.id', 'desc')
            ->select('short_videos.*', 'users.username', 'users.name', 'users.avt')
            ->get();
        if (!$video) {
            return response('Not found!', 404);
        }
        return response($video);
    }


}
