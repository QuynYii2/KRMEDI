<?php

namespace App\Http\Controllers\restapi\admin;

use App\Enums\TopicVideoStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TranslateController;
use App\Models\TopicVideo;
use Illuminate\Http\Request;

class AdminTopicVideoApi extends Controller
{
    public function getAll(Request $request)
    {
        $status = $request->input('status');
        if ($status) {
            $topics = TopicVideo::where('status', $status)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $topics = TopicVideo::where('status', '!=', TopicVideoStatus::DELETED)
                ->orderBy('id', 'desc')
                ->get();
        }
        return response()->json($topics);
    }

    public function getAllByUserID($id, Request $request)
    {
        $status = $request->input('status');
        if ($status) {
            $topics = TopicVideo::where('status', $status)
                ->where('user_id', $id)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $topics = TopicVideo::where('status', '!=', TopicVideoStatus::DELETED)
                ->where('user_id', $id)
                ->orderBy('id', 'desc')
                ->get();
        }
        return response()->json($topics);
    }

    public function detail($id)
    {
        $topic = TopicVideo::find($id);
        if (!$topic || $topic->status == TopicVideoStatus::DELETED) {
            return response('Not found!', 404);
        }
        return response()->json($topic);
    }

    public function create(Request $request)
    {
        try {
            $topic = new TopicVideo();
            $topic = $this->saveTopic($request, $topic);
            $parent = $topic->parent_id;
            if ($parent) {
                $topic_parent = TopicVideo::find($parent);
                if (!$topic_parent) {
                    return response('Topic parent not found!', 400);
                }
            }
            $success = $topic->save();
            if ($success) {
                return response()->json($topic);
            }
            return response('Create error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    private function saveTopic($request, $topicVideo)
    {
        $name = $request->input('name');

        $translate = new TranslateController();

        $name_en = $translate->translateText($name, 'en');
        $name_laos = $translate->translateText($name, 'lo');

        if ($request->hasFile('thumbnail')) {
            $item = $request->file('thumbnail');
            $itemPath = $item->store('topic-video/', 'public');
            $file = asset('storage/' . $itemPath);
        } else {
            $file = $topicVideo->thumbnail;
        }

        $parent_id = $request->input('parent_id');
        if ($parent_id) {
            $topicVideo->parent_id = $parent_id;
        }

        $user_id = $request->input('user_id');
        $status = $request->input('status');

        $topicVideo->name = $name;
        $topicVideo->name_en = $name_en;
        $topicVideo->name_laos = $name_laos;
        $topicVideo->thumbnail = $file;
        $topicVideo->user_id = $user_id;
        $topicVideo->status = $status;

        return $topicVideo;
    }

    public function update(Request $request, $id)
    {
        try {
            $topic = TopicVideo::find($id);
            if (!$topic || $topic->status == TopicVideoStatus::DELETED) {
                return response('Not found!', 404);
            }

            $topic = $this->saveTopic($request, $topic);

            $parent = $topic->parent_id;
            if ($parent) {
                if ($parent == $id) {
                    return response('Topic parent invalid!', 400);
                }

                $topic_parent = TopicVideo::find($parent);
                if (!$topic_parent) {
                    return response('Topic parent not found!', 400);
                }
            }

            $success = $topic->save();
            if ($success) {
                return response()->json($topic);
            }
            return response('Update error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function delete($id)
    {
        try {
            $topic = TopicVideo::find($id);
            if (!$topic || $topic->status == TopicVideoStatus::DELETED) {
                return response('Not found!', 404);
            }

            $topic->status = TopicVideoStatus::DELETED;
            $success = $topic->save();
            if ($success) {
                return response('Delete success!', 200);
            }
            return response('Delete error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }
}
