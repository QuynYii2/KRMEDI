<?php

namespace App\Http\Controllers\backend;

use App\Enums\NewEventStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use App\Http\Controllers\TranslateController;
use App\Models\NewEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BackendNewEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $isAdmin = (new MainController())->checkAdmin();
        if ($isAdmin) {
            $listNewEvent = NewEvent::where('status', '!=', NewEventStatus::DELETED)
                ->orderByDesc('id')
                ->paginate(20);
        } else {
            $listNewEvent = NewEvent::where('status', '!=', NewEventStatus::DELETED)
                ->where('user_id', Auth::user()->id)
                ->orderByDesc('id')
                ->paginate(20);
        }
        return view('admin.new_event.index', compact('listNewEvent'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.new_event.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $newEvent = NewEvent::find($id);
        return view('admin.new_event.edit', compact('newEvent'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $newEvent = NewEvent::find($id);
        // nếu tìm thấy, thì sửa status = DELETED và thông báo
        if ($newEvent) {
            $newEvent->status = NewEventStatus::DELETED;
            $success = $newEvent->update();
            if ($success) {
                return response('Xóa sự kiện thành công !!!', 200);
            } else {
                return response('Xóa sự kiện thất bại !!!', 400);
            }
        } else {
            return response('Không tìm thấy sự kiện !!!', 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $params = $request->only('title', 'status', 'type', 'short_description', 'description');

        /* kiểm tra 1 trong những title, title_en, title_laos phải khác null */
        if ($params['title'] == null) {
            return response('Vui lòng nhập tiêu đề !!!', 400);
        }
        /* kiểm tra 1 trong những short_description phải khác null */
        if ($params['short_description'] == null) {
            return response('Vui lòng nhập mô tả ngắn !!!', 400);
        }
        /* kiểm tra 1 trong những description phải khác null */
        if ($params['description'] == null) {
            return response('Vui lòng nhập nội dung !!!', 400);
        }

        $translate = new TranslateController();
        $params['title_en'] = $translate->translateText($params['title'], 'en');
        $params['title_laos'] = $translate->translateText($params['title'], 'lo');

        $params['short_description_en'] = $translate->translateText($params['short_description'], 'en');
        $params['short_description_laos'] = $translate->translateText($params['short_description'], 'lo');

        $params['description_en'] = $translate->translateText($params['description'], 'en');
        $params['description_laos'] = $translate->translateText($params['description'], 'lo');

        if ($request->hasFile('thumbnail')) {
            $item = $request->file('thumbnail');
            $itemPath = $item->store('new_event', 'public');
            $thumbnail = asset('storage/' . $itemPath);
            $params['thumbnail'] = $thumbnail;
        }

        $newEvent = NewEvent::find($request->input('id'));
        $newEvent->fill($params);

        $success = $newEvent->update();

        if ($success) {
            return response('Cập nhật sự kiện thành công !!!', 200);
        } else {
            return response('Cập nhật sự kiện thất bại !!!', 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $params = $request->only('title', 'status', 'type',
            'short_description', 'description');

        $translate = new TranslateController();
        $params['title_en'] = $translate->translateText($params['title'], 'en');
        $params['title_laos'] = $translate->translateText($params['title'], 'lo');

        $params['short_description_en'] = $translate->translateText($params['short_description'], 'en');
        $params['short_description_laos'] = $translate->translateText($params['short_description'], 'lo');

        $params['description_en'] = $translate->translateText($params['description'], 'en');
        $params['description_laos'] = $translate->translateText($params['description'], 'lo');

        /* kiểm tra 1 trong những title, title_en, title_laos phải khác null */
        if ($params['title'] == null || $params['title_en'] == null || $params['title_laos'] == null) {
            return response('Vui lòng nhập tiêu đề !!!', 400);
        }
        /* kiểm tra 1 trong những short_description phải khác null */
        if ($params['short_description'] == null || $params['short_description_en'] == null || $params['short_description_laos'] == null) {
            return response('Vui lòng nhập mô tả ngắn !!!', 400);
        }
        /* kiểm tra 1 trong những description phải khác null */
        if ($params['description'] == null || $params['description_en'] == null || $params['description_laos'] == null) {
            return response('Vui lòng nhập nội dung !!!', 400);
        }

        $newEvent = new NewEvent();
        $newEvent->fill($params);

        if ($request->hasFile('thumbnail')) {
            $item = $request->file('thumbnail');
            $itemPath = $item->store('new_event', 'public');
            $thumbnail = asset('storage/' . $itemPath);
        } else {
            return response('Vui lòng thêm ảnh !!!', 400);
        }
        $newEvent->thumbnail = $thumbnail;

        $success = $newEvent->save();

        if ($success) {
            return response()->json('Thêm sự kiện thành công !!!');
        } else {
            return response('Thêm sự kiện thất bại !!!', 400);
        }
    }
}
