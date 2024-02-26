<?php

namespace App\Http\Controllers;

use App\Enums\ShortVideoStatus;
use App\Enums\TopicVideoStatus;
use App\Models\ShortVideo;
use App\Models\TopicVideo;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ShortVideoController extends Controller
{
    public function showVideo()
    {
        $videos = DB::table('short_videos')
            ->join('users', 'users.id', '=', 'short_videos.user_id')
            ->where('short_videos.status', ShortVideoStatus::ACTIVE)
            ->orderBy('short_videos.id', 'desc')
            ->select('short_videos.*', 'users.username', 'users.name', 'users.avt')
            ->paginate(3);
        $topics = TopicVideo::where('status', TopicVideoStatus::ACTIVE)->get();
        return view('short-video.list-video', compact('videos', 'topics'));
    }

    public function detail($id)
    {
        $video = ShortVideo::find($id);
        return view('short-video.detail-video', compact('video'));
    }

    public function create()
    {
        $topics = TopicVideo::where('status', TopicVideoStatus::ACTIVE)->get();
        return view('short-video.create-video', compact('topics'));
    }

    /* Admin Manager short video */
    public function getList()
    {
        return view('admin.short-videos.list');
    }

    public function getById($id)
    {
        $video = ShortVideo::find($id);
        $user = User::find($video->user_id);
        $topics = TopicVideo::where('status', TopicVideoStatus::ACTIVE)->get();
        return view('admin.short-videos.detail', compact('video', 'user', 'topics'));
    }
}
