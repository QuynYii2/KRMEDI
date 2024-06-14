<?php

namespace App\Http\Controllers\ui;

use App\Http\Controllers\Controller;
use App\Models\FooterModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function listRatingUser()
    {
        return view('ui.member-ratings.list-member');
    }

    public function updateSignature(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'user_id' => 'required|numeric',
                'signature' => 'required'
            ]);

            if ($validated->fails()) {
                return response()->json(['error' => -1, 'message' => $validated->errors()->first()], 400);
            }

            $validatedData = $validated->validated();

            $user_id = $validatedData['user_id'];
            $signature = $validatedData['signature'];

            $user = User::find($user_id);

            $oldSignature = $user->signature;

            $imageData = str_replace('data:image/png;base64,', '', $signature);

            // Decode the base64 data
            $imageData = base64_decode($imageData);

            // Generate a unique filename for the image
            $filename = uniqid() . '.png';

            // Define the storage path where you want to store the image
            $storagePath = 'signature/';

            // Remove old signature if it exists
            if ($oldSignature && Storage::exists(str_replace('/storage', 'public', $oldSignature))) {
                Storage::delete(str_replace('/storage', 'public', $oldSignature));
            }

            Storage::put('public/' . $storagePath . $filename, $imageData);

            $user->signature = Storage::url($storagePath . $filename);
            $user->save();

            return response()->json(['error' => 0, 'data' => "Success change signature"]);
        } catch (\Exception $e) {
            return response(['error' => -1, 'message' => $e->getMessage()], 400);
        }
    }

    public function support($slug)
    {
        $footer = FooterModel::where('slug',$slug)->first();
        return view('support',compact('footer'));
    }
    public function mailCSKH(Request $request)
    {
        $name_mail = $request->get('email');
        $name = $request->get('user_name');
        $phone = $request->get('phone');
        $content = $request->get('contentes');
        Mail::send('email.index', compact('name','phone','content'),function ($email) use($name,$name_mail){
            $email->subject('Yêu cầu hỗ trợ ');
            $email->to($name_mail, $name);
        });
        return response()->json(['error' => 0, 'data' => "Gửi yêu cầu thành công"]);
    }
}
