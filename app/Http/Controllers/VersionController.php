<?php

namespace App\Http\Controllers;

use App\Models\VersionsModel;
use Illuminate\Http\Request;

class VersionController extends Controller
{
    public function index()
    {
        $listData = VersionsModel::orderBy('created_at','desc')->get();

        return view('admin.version.list', compact('listData'));
    }

    public function create()
    {
        return view('admin.version.create');
    }

    public function store(Request $request)
    {
        try {
            $version_current = VersionsModel::where('type',$request->get('type'))->orderBy('created_at','desc')->first();

            $version = new VersionsModel();
            if ($version_current){
                $version->version_current = $version_current->version_update;
            }
            $version->version_update = $request->get('version_update');
            $version->need_update = $request->get('need_update');
            $version->note_update = $request->get('note_update');
            $version->type = $request->get('type');
            $version->save();

            return \redirect()->route('view.admin.version.index')->with(['success' => 'Thêm mới version thành công']);

        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    public function delete ($id)
    {
        VersionsModel::where('id', $id)->delete();
        return \redirect()->route('view.admin.version.index')->with(['success' => 'Xóa thông tin thành công']);
    }

    public function edit ($id)
    {
        $data = VersionsModel::find($id);
        return view('admin.version.edit', compact('data'));
    }

    public function update ($id, Request $request)
    {
        try{
            $version = VersionsModel::find($id);
            if (empty($version)){
                return back()->with(['error'=> 'Version không tồn tại']);
            }
            $version->version_update = $request->get('version_update');
            $version->need_update = $request->get('need_update');
            $version->note_update = $request->get('note_update');
            $version->type = $request->get('type');
            $version->save();
            return \redirect()->route('view.admin.version.index')->with(['success' => 'Cập nhật thông tin thành công']);
        }catch (\Exception $exception){
            return back()->with(['error' => $exception->getMessage()]);
        }
    }
}
