<?php

namespace App\Http\Controllers;

use App\Enums\FamilyManagementEnum;
use App\Enums\Role;
use App\Enums\UserStatus;
use App\Models\FamilyManagement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class FamilyManagementController extends Controller
{
    public function index()
    {
        $family_members = FamilyManagement::where('user_id', auth()->user()->id)->get();
        session()->forget('previous_url');
        return view('admin.family_management.index', compact('family_members'));
    }


    public function create()
    {
        return view('admin.family_management.create_family');
    }

    public function addMember()
    {
        $thisFamily = FamilyManagement::where('user_id', auth()->user()->id)->first();
        if (!$thisFamily) {
            return response()->json([
                'message' => 'Bạn chưa có thông tin gia đình',
            ], 400);
        }

        return view('admin.family_management.add_member');
    }

    public function store(Request $request, $type)
    {
        $family = null;
        switch ($type) {
            case FamilyManagementEnum::CREATE_FAMILY:
                $family = FamilyManagement::where('user_id', auth()->user()->id)->first();

                if ($family) {
                    return response()->json([
                        'message' => 'Bạn đã có thông tin gia đình',
                    ], 400);
                }

                $family = new FamilyManagement();
                $family->family_code = (new MainController())->generateRandomString(10);
                $family->user_id = auth()->user()->id;
                break;
            case FamilyManagementEnum::ADD_MEMBER_FAMILY:
                $family = FamilyManagement::where('user_id', auth()->user()->id)->first();
                if (!$family) {
                    return response()->json([
                        'message' => 'Bạn chưa có thông tin gia đình',
                    ], 400);
                }
                $family_code = $family->family_code;

                $family = new FamilyManagement();
                $family->family_code = $family_code;
                $family->user_id = auth()->user()->id;

                break;
        }

        if (!$family) {
            return redirect()->back()->with('error', 'Không tìm thấy thông tin gia đình');
        }

        try {
            $this->validParam($request);
        } catch (ValidationException $exception) {
            return response()->json(['errors' => $exception->errors()], 400);
        }

        if ($request->hasFile('avatar')) {
            $oldAvatarPath = $family->avatar;
            if ($oldAvatarPath) {
                $oldAvatarPath = str_replace(asset('storage/'), '', $oldAvatarPath);
                Storage::disk('public')->delete($oldAvatarPath);
            }

            $item = $request->file('avatar');
            $itemPath = $item->store('family_avatar', 'public');
            $avatar = asset('storage/' . $itemPath);
            $family->avatar = $avatar;
        }

        // Handle insurance files
        if ($request->hasFile('health_insurance_front')) {
            $oldFrontPath = $family->health_insurance_front;
            if ($oldFrontPath) {
                $oldFrontPath = str_replace(asset('storage/'), '', $oldFrontPath);
                Storage::disk('public')->delete($oldFrontPath);
            }

            $item = $request->file('health_insurance_front');
            $itemPath = $item->store('health_insurance', 'public');
            $healthInsuranceFront = asset('storage/' . $itemPath);
            $family->health_insurance_front = $healthInsuranceFront;
        }

        if ($request->hasFile('health_insurance_back')) {
            $oldBackPath = $family->health_insurance_back;
            if ($oldBackPath) {
                $oldBackPath = str_replace(asset('storage/'), '', $oldBackPath);
                Storage::disk('public')->delete($oldBackPath);
            }

            $item = $request->file('health_insurance_back');
            $itemPath = $item->store('health_insurance', 'public');
            $healthInsuranceBack = asset('storage/' . $itemPath);
            $family->health_insurance_back = $healthInsuranceBack;
        }

        $params = $request->only('relationship', 'name', 'date_of_birth', 'number_phone', 'email', 'sex', 'province_id',
            'district_id', 'ward_id', 'detail_address', 'insurance_id', 'insurance_date');
        $family->fill($params);
        $family->save();
        $previousUrl = session('previous_url');
        session()->forget('previous_url');
        if ($previousUrl) {
            return response()->json([
                'message' => 'Thêm thông tin gia đình thành công',
                'url'=>$previousUrl,
                'type' => 1,
            ], 200);
        }else{
            return response()->json([
                'message' => 'Thêm thông tin gia đình thành công',
                'type'=>0,
                'url'=>null,
            ], 200);
        }
    }

    public function edit($id)
    {
        $member = FamilyManagement::where('id', $id)->first();

        if (!$member) {
            $member = null;
        }

        return view('admin.family_management.edit', compact('member', 'id'));
    }

    public function update(Request $request, $id)
    {
        $member = FamilyManagement::where('id', $id)->first();

        if (!$member) {
            return response()->json([
                'message' => 'Không tìm thấy thông tin gia đình',
            ], 400);
        }

        try {
            $this->validParam($request, $id);
        } catch (ValidationException $exception) {
            return response()->json(['errors' => $exception->errors()], 400);
        }

        if ($request->hasFile('avatar')) {
            $oldAvatarPath = $member->avatar;
            if ($oldAvatarPath) {
                $oldAvatarPath = str_replace(asset('storage/'), '', $oldAvatarPath);
                Storage::disk('public')->delete($oldAvatarPath);
            }

            $item = $request->file('avatar');
            $itemPath = $item->store('family_avatar', 'public');
            $avatar = asset('storage/' . $itemPath);
            $member->avatar = $avatar;
        }

// Handle insurance files
        if ($request->hasFile('health_insurance_front')) {
            $oldFrontPath = $member->health_insurance_front;
            if ($oldFrontPath) {
                $oldFrontPath = str_replace(asset('storage/'), '', $oldFrontPath);
                Storage::disk('public')->delete($oldFrontPath);
            }

            $item = $request->file('health_insurance_front');
            $itemPath = $item->store('health_insurance', 'public');
            $healthInsuranceFront = asset('storage/' . $itemPath);
            $member->health_insurance_front = $healthInsuranceFront;
        }

        if ($request->hasFile('health_insurance_back')) {
            $oldBackPath = $member->health_insurance_back;
            if ($oldBackPath) {
                $oldBackPath = str_replace(asset('storage/'), '', $oldBackPath);
                Storage::disk('public')->delete($oldBackPath);
            }

            $item = $request->file('health_insurance_back');
            $itemPath = $item->store('health_insurance', 'public');
            $healthInsuranceBack = asset('storage/' . $itemPath);
            $member->health_insurance_back = $healthInsuranceBack;
        }
        $params = $request->only('relationship', 'name', 'date_of_birth', 'number_phone', 'email', 'sex',
            'province_id', 'district_id', 'ward_id', 'detail_address', 'insurance_id', 'insurance_date');
        $member->fill($params);
        $member->save();
        $previousUrl = session('previous_url');
        session()->forget('previous_url');
        if ($previousUrl) {
            return response()->json([
                'message' => 'Cập nhật thông tin gia đình thành công',
                'url'=>$previousUrl,
                'type' => 1,
            ], 200);
        }else{
            return response()->json([
                'message' => 'Cập nhật thông tin gia đình thành công',
                'type'=>0,
                'url'=>null,
            ], 200);
        }

    }

    public function destroy($id)
    {
        $member = FamilyManagement::where('id', $id)->first();

        if (!$member) {
            return response()->json([
                'message' => 'Không tìm thấy thông tin gia đình',
            ], 400);
        }

        $member->delete();

        return redirect()->back();
    }


    public function indexApi($current_user_id)
    {
        $user = User::where('id', $current_user_id)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Không tìm thấy người dùng',
            ], 400);
        }

        $family_members = FamilyManagement::where('user_id', $current_user_id)->get();

        if (!$family_members) {
            return response()->json([
                'message' => 'Nguời dùng chưa có thông tin gia đình',
            ], 400);
        }

        return response()->json($family_members, 200);
    }


    // tạo mới gia đình
    public function createApi(Request $request, $current_user_id)
    {

        $family = FamilyManagement::where('user_id', $current_user_id)->first();

        if ($family) {
            return response()->json([
                'message' => 'Bạn đã có thông tin gia đình',
            ], 400);
        }

        try {
            $this->validParam($request);
        } catch (ValidationException $exception) {
            return response()->json(['errors' => $exception->errors()], 400);
        }

        $family = new FamilyManagement();
        $family->user_id = $current_user_id;
        $family->family_code = (new MainController())->generateRandomString(10);

        $params = $request->only('relationship', 'name', 'date_of_birth', 'number_phone', 'email', 'sex', 'province_id',
            'district_id', 'ward_id', 'detail_address');
        $family->fill($params);

        if ($request->hasFile('avatar')) {
            $item = $request->file('avatar');
            $itemPath = $item->store('family_avatar', 'public');
            $avatar = asset('storage/' . $itemPath);
            $family->avatar = $avatar;
        }

        if ($request->hasFile('insurance_card_front')) {
            $item = $request->file('insurance_card_front');
            $itemPath = $item->store('family_avatar', 'public');
            $insurance_card_front = asset('storage/' . $itemPath);
            $family->health_insurance_front = $insurance_card_front;
        }
        if ($request->hasFile('insurance_card_back')) {
            $item = $request->file('insurance_card_back');
            $itemPath = $item->store('family_avatar', 'public');
            $insurance_card_back = asset('storage/' . $itemPath);
            $family->health_insurance_back = $insurance_card_back;
        }
        if ($request->has('insurance_code')) {
            $family->insurance_id = $request->input('insurance_code');
        }
        if ($request->has('insurance_period')) {
            $family->insurance_date = $request->input('insurance_period');
        }

        $success = $family->save();

        if ($success) {
            return response()->json([
                'message' => 'Tạo thông tin gia đình thành công',
            ], 200);
        }
        return response()->json([
            'message' => 'Tạo thông tin gia đình thất bại',
        ], 400);
    }

    private function validParam($request, $id = null)
    {
        $request->validate([
            'email' => [
                'string',
                'email',
                'max:255',
                Rule::unique('family_management', 'email')->ignore($id),
            ],
            'number_phone' => [
                'numeric',
                'digits_between:8,12',
                Rule::unique('family_management', 'number_phone')->ignore($id),
            ],
        ]);
    }


    // tạo mới thành viên gia đình
    public function storeApi(Request $request, $current_user_id)
    {

        $user = User::where('id', $current_user_id)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Không tìm thấy người dùng',
            ], 400);
        }

        $hasFamily = FamilyManagement::where('user_id', $current_user_id)->first();

        if (!$hasFamily) {
            return response()->json([
                'message' => 'Cần tạo gia đình trước',
            ], 400);
        }

        try {
            $this->validParam($request);
        } catch (ValidationException $exception) {
            return response()->json(['errors' => $exception->errors()], 400);
        }

        $family = new FamilyManagement();

        if ($request->hasFile('avatar')) {
            $item = $request->file('avatar');
            $itemPath = $item->store('family_avatar', 'public');
            $avatar = asset('storage/' . $itemPath);
            $family->avatar = $avatar;
        }

        $family->family_code = $hasFamily->family_code;

        $family->user_id = $current_user_id;

        $params = $request->only('relationship', 'name', 'date_of_birth', 'number_phone', 'email', 'sex', 'province_id',
            'district_id', 'ward_id', 'detail_address');
        $family->fill($params);

        $success = $family->save();

        if ($success) {
            return response()->json([
                'message' => 'Thêm thông tin gia đình thành công',
            ], 200);
        }
        return response()->json([
            'message' => 'Thêm thông tin gia đình thất bại',
        ], 400);

    }


    // cập nhật thông tin gia đình
    public function updateApi(Request $request, $id)
    {

        $family = FamilyManagement::where('id', $id)->first();

        if (!$family) {
            return response()->json([
                'message' => 'Không tìm thấy thông tin gia đình',
            ], 400);
        }

        try {
            $this->validParam($request, $family->id);
        } catch (ValidationException $exception) {
            return response()->json(['errors' => $exception->errors()], 400);
        }

        $family = FamilyManagement::where('id', $id)->first();
        if ($request->hasFile('avatar')) {
            $oldAvatarPath = $family->avatar;
            if ($oldAvatarPath) {
                $oldAvatarPath = str_replace(asset('storage/'), '', $oldAvatarPath);
                Storage::disk('public')->delete($oldAvatarPath);
            }

            $item = $request->file('avatar');
            $itemPath = $item->store('family_avatar', 'public');
            $avatar = asset('storage/' . $itemPath);
            $family->avatar = $avatar;
        }

        if ($request->hasFile('insurance_card_front')) {
            $insurance_front = $family->health_insurance_front;
            if ($insurance_front) {
                $insurance_front = str_replace(asset('storage/'), '', $insurance_front);
                Storage::disk('public')->delete($insurance_front);
            }

            $item = $request->file('insurance_card_front');
            $itemPath = $item->store('family_avatar', 'public');
            $insurance_card_front = asset('storage/' . $itemPath);
            $family->health_insurance_front = $insurance_card_front;
        }
        if ($request->hasFile('insurance_card_back')) {
            $insurance_back = $family->health_insurance_back;
            if ($insurance_back) {
                $insurance_back = str_replace(asset('storage/'), '', $insurance_back);
                Storage::disk('public')->delete($insurance_back);
            }

            $item = $request->file('insurance_card_back');
            $itemPath = $item->store('family_avatar', 'public');
            $insurance_card_back = asset('storage/' . $itemPath);
            $family->health_insurance_back = $insurance_card_back;
        }
        if ($request->has('insurance_code')) {
            $family->insurance_id = $request->input('insurance_code');
        }
        if ($request->has('insurance_period')) {
            $family->insurance_date = $request->input('insurance_period');
        }

        $params = $request->only('relationship', 'name', 'date_of_birth', 'number_phone', 'email', 'sex', 'province_id',
            'district_id', 'ward_id', 'detail_address');
        $family->fill($params);

        $success = $family->save();

        if ($success) {
            return response()->json([
                'message' => 'Cập nhật thông tin gia đình thành công',
            ], 200);
        }

        return response()->json([
            'message' => 'Cập nhật thông tin gia đình thất bại',
        ], 400);
    }

    public function listMemberAPI($userID) {
        $listMember = FamilyManagement::where('user_id', $userID) ->get();

        if ($listMember) {
            return response()->json($listMember);
        }

        return response()->json([
            'message' => 'Chưa có thành viên khác trong gia điình.',
        ], 404);
    }

    public function destroyApi($id)
    {

        $family = FamilyManagement::where('id', $id)->first();

        if (!$family) {
            return response()->json([
                'message' => 'Không tìm thấy thông tin gia đình',
            ], 400);
        }

        $success = $family->delete();

        if ($success) {
            return response()->json([
                'message' => 'Xóa thông tin gia đình thành công',
            ], 200);
        }

        return response()->json([
            'message' => 'Xóa thông tin gia đình thất bại',
        ], 400);
    }

}
