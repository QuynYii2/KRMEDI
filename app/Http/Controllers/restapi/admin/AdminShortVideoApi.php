<?php

namespace App\Http\Controllers\restapi\admin;

use App\Enums\ShortVideoStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TranslateController;
use App\Models\ShortVideo;
use Illuminate\Http\Request;

class AdminShortVideoApi extends Controller
{
    public function getAll(Request $request)
    {
        $status = $request->input('status');
        if ($status) {
            $videos = ShortVideo::where('status', $status)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $videos = ShortVideo::where('status', '!=', ShortVideoStatus::DELETED)
                ->orderBy('id', 'desc')
                ->get();
        }
        return response($videos);
    }

    public function getAllByUserID(Request $request, $id)
    {
        $status = $request->input('status');
        if ($status) {
            $videos = ShortVideo::where('status', $status)
                ->where('user_id', $id)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $videos = ShortVideo::where('status', '!=', ShortVideoStatus::DELETED)
                ->where('user_id', $id)
                ->orderBy('id', 'desc')
                ->get();
        }
        return response($videos);
    }

    public function getAllByTopicID(Request $request, $id)
    {
        $status = $request->input('status');
        if ($status) {
            $videos = ShortVideo::where('status', $status)
                ->where('topic_id', $id)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $videos = ShortVideo::where('status', '!=', ShortVideoStatus::DELETED)
                ->where('topic_id', $id)
                ->orderBy('id', 'desc')
                ->get();
        }
        return response($videos);
    }

    public function detail($id)
    {
        $video = ShortVideo::find($id);
        if (!$video || $video->status == ShortVideoStatus::DELETED) {
            return response('Not found!', 404);
        }
        return response($video);
    }

    public function search(Request $request)
    {

    }

    public function create(Request $request)
    {
        try {
            $video = new ShortVideo();

            $title = $request->input('title');
            $title_en = $title;
            $title_laos = $title;

            $topic = $request->input('topic_id');

            $user_id = $request->input('user_id');

            if ($request->hasFile('file_videos')) {

                $fileSize = $request->file('file_videos')->getSize();
                if ($fileSize > 31457280) {
                    return response()->json(['error' => 'File size exceeds the limit of 30MB.'], 400);
                }

                $item = $request->file('file_videos');
                $itemPath = $item->store('short_video', 'public');
                $file = asset('storage/' . $itemPath);
            } else {
                return response('Please upload video!', 400);
            }

            $video->title = $title;
            $video->title_en = $title_en;
            $video->title_laos = $title_laos;

            $video->user_id = $user_id;
            $video->topic_id = $topic;

            $video->status = ShortVideoStatus::ACTIVE;

            $video->file = $file;

            $views = 0;
            $shares = 0;
            $reactions = 0;

            $video->views = $views;
            $video->shares = $shares;
            $video->reactions = $reactions;

            $success = $video->save();
            if ($success) {
                return response()->json($video);
            }
            return response('Upload error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $translate = new TranslateController();

            $video = ShortVideo::find($id);
            if (!$video || $video->status == ShortVideoStatus::DELETED) {
                return response('Not found!', 404);
            }

            $title = $request->input('title');

            $title_en = $translate->translateText($title, 'en');
            $title_laos = $translate->translateText($title, 'lo');

            $views = $request->input('views');
            $shares = $request->input('shares');
            $reactions = $request->input('reactions');

            $topic = $request->input('topic_id');
            $status = $request->input('status');

            $video->title = $title;
            $video->title_en = $title_en;
            $video->title_laos = $title_laos;

            $video->topic_id = $topic;
            $video->status = $status;

            $video->views = $views;
            $video->shares = $shares;
            $video->reactions = $reactions;

            if ($request->hasFile('file_videos')) {

                $fileSize = $request->file('file_videos')->getSize();
                if ($fileSize > 31457280) {
                    return response()->json(['error' => 'File size exceeds the limit of 30MB.'], 400);
                }

                $item = $request->file('file_videos');
                $itemPath = $item->store('short_video', 'public');
                $file = asset('storage/' . $itemPath);
                $video->file = $file;
            }

            $success = $video->save();
            if ($success) {
                return response()->json($video);
            }
            return response('Edit error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function changeStatus($id)
    {
        try {
            $video = ShortVideo::find($id);
            if (!$video || $video->status == ShortVideoStatus::DELETED) {
                return response('Not found!', 404);
            }

            if ($video->status == ShortVideoStatus::ACTIVE) {
                $video->status = ShortVideoStatus::INACTIVE;
            } else {
                $video->status = ShortVideoStatus::ACTIVE;
            }

            $success = $video->save();
            if ($success) {
                return response()->json($video);
            }
            return response('Edit error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function delete($id)
    {
        try {
            $video = ShortVideo::find($id);
            if (!$video || $video->status == ShortVideoStatus::DELETED) {
                return response('Not found!', 404);
            }

            $video->status = ShortVideoStatus::DELETED;

            $success = $video->save();
            if ($success) {
                return response('Delete success!', 200);
            }
            return response('Delete error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }
}
