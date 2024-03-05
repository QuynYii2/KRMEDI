<?php

namespace App\Http\Controllers\restapi;

use App\Enums\NewEventStatus;
use App\Http\Controllers\Controller;
use App\Models\NewEvent;
use Illuminate\Http\Request;

class NewsApi extends Controller
{
    public function getAll(Request $request)
    {
        $type = $request->input('type');
        if ($type) {
            $news = NewEvent::where('status', NewEventStatus::ACTIVE)
                ->where('type', $type)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $news = NewEvent::where('status', NewEventStatus::ACTIVE)->orderBy('id', 'desc')->get();
        }
        return response()->json($news);
    }

    public function getAllByUserID($id)
    {
        $news = NewEvent::where('user_id', $id)
            ->where('status', NewEventStatus::ACTIVE)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($news);
    }

    public function search(Request $request)
    {

    }

    public function detail($id)
    {
        $news = NewEvent::find($id);
        if (!$news || $news->status != NewEventStatus::ACTIVE) {
            return response('Not found!', 404);
        }
        return response()->json($news);
    }
}
