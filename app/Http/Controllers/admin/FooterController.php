<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\FooterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FooterController extends Controller
{
    public function index()
    {
        $listData = FooterModel::all();

        return view('admin.footer.list', compact('listData'));
    }

    public function create()
    {
        return view('admin.footer.create');
    }

    public function store(Request $request)
    {
        try {
            $footer_title = FooterModel::where('title',$request->get('title'))->first();
            if ($footer_title){
                return back()->with(['error' => 'Tên footer đã tồn tại']);
            }

            $footer = new FooterModel();
            $footer->title = $request->get('title');
            $footer->slug = Str::slug($request->get('title'));
            $footer->content = $request->get('content');
            $footer->save();

            return \redirect()->route('view.admin.footer.index')->with(['success' => 'Thêm mới footer thành công']);

        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    public function delete ($id)
    {
            FooterModel::where('id', $id)->delete();
            return \redirect()->route('view.admin.footer.index')->with(['success' => 'Xóa thông tin thành công']);
    }

    public function edit ($id)
    {
            $footer = FooterModel::find($id);
            return view('admin.footer.edit', compact('footer'));
    }

    public function update ($id, Request $request)
    {
        try{
            $footer = FooterModel::find($id);
            if (empty($footer)){
                return back()->with(['error'=> 'Footer không tồn tại']);
            }

            $footer->title = $request->get('title');
            $footer->slug = Str::slug($request->get('title'));
            $footer->content = $request->get('content');
            $footer->save();
            return \redirect()->route('view.admin.footer.index')->with(['success' => 'Cập nhật thông tin thành công']);
        }catch (\Exception $exception){
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

}
