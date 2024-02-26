<?php

namespace App\Http\Controllers\restapi\admin;

use App\Enums\NewEventStatus;
use App\Http\Controllers\Controller;
use App\Models\NewEvent;
use Illuminate\Http\Request;

class AdminNewsApi extends Controller
{
    public function getAll(Request $request)
    {
        $status = $request->input('status');
        $type = $request->input('type');
        if ($status) {
            if ($type) {
                $news = NewEvent::where('status', $status)
                    ->where('type', $type)
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                $news = NewEvent::where('status', $status)->orderBy('id', 'desc')->get();
            }
        } else {
            if ($type) {
                $news = NewEvent::where('status', '!=', NewEventStatus::DELETED)
                    ->where('type', $type)
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                $news = NewEvent::where('status', '!=', NewEventStatus::DELETED)
                    ->orderBy('id', 'desc')
                    ->get();
            }
        }
        return response()->json($news);
    }

    public function getAllByUserID(Request $request, $id)
    {
        $status = $request->input('status');
        if ($status) {
            $news = NewEvent::where('user_id', $id)
                ->where('status', $status)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $news = NewEvent::where('user_id', $id)
                ->where('status', '!=', NewEventStatus::DELETED)
                ->orderBy('id', 'desc')
                ->get();
        }
        return response()->json($news);
    }

    public function detail(Request $request, $id)
    {
        $news = NewEvent::find($id);
        if (!$news || $news->status == NewEventStatus::DELETED) {
            return response('Not found!', 404);
        }
        return response()->json($news);
    }
}
