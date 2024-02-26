<?php

namespace App\Http\Controllers;

use App\Models\TopicVideo;

class TopicVideoController extends Controller
{
    public function getList()
    {
        return view('admin.topic-video.list');
    }

    public function detail($id)
    {
        $topicVideo = TopicVideo::find($id);
        return view('admin.topic-video.detail', compact('topicVideo'));
    }

    public function create()
    {
        return view('admin.topic-video.create');
    }
}
