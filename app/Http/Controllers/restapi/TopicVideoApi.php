<?php

namespace App\Http\Controllers\restapi;

use App\Enums\TopicVideoStatus;
use App\Http\Controllers\Controller;
use App\Models\TopicVideo;

class TopicVideoApi extends Controller
{
    public function getAll()
    {
        $topics = TopicVideo::where('status', TopicVideoStatus::ACTIVE)->get();

//        $topics = TopicVideo::where('status', TopicVideoStatus::ACTIVE)
//            ->where('parent_id', null)
//            ->orderBy('id', 'desc')
//            ->cursor()
//            ->map(function ($item) {
//                $topicChild = TopicVideo::where('parent_id', $item->id)->get();
//                $topic = (array)$item;
//                $topic['total_childs'] = $topicChild->count();
//                $topic['childs'] = $topicChild->toArray();
//                return $topic;
//            });
        return response()->json($topics);
    }

    public function getAllByUserID($id)
    {
        $topics = TopicVideo::where('status', TopicVideoStatus::ACTIVE)
            ->where('user_id', $id)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($topics);
    }

    public function getAllByParentID($id)
    {
        $topics = TopicVideo::where('status', TopicVideoStatus::ACTIVE)
            ->where('parent_id', $id)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($topics);
    }

    public function detail($id)
    {
        $topic = TopicVideo::find($id);
        if (!$topic || $topic->status != TopicVideoStatus::ACTIVE) {
            return response('Not found!', 404);
        }
        return response()->json($topic);
    }
}
