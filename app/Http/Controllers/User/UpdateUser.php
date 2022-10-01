<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserDataResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Traits\HandelJson;
use Illuminate\Support\Facades\Hash;

class UpdateUser extends Controller
{
    //
    use HandelJson;

    public function __construct()
    {
        $this->middleware('auth:api',);
    }
    public function updaetuser(Request $request)
    {

        $userId = Auth::id();
        $user = User::findOrFail($userId);
        $rules = [
            'name' => 'required',
            'email'    =>  [
                Rule::unique('users')->ignore($user->id), 'required'
            ],
            'phone' => 'required'
        ];
        $input = $request->only('name', 'email', 'phone');
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return $this->send_error(101, $this->get_array_of_message_error($validator));
        }
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $user->save();
        if ($request->filled('oldpassword')) {
            if ($request->filled('oldpassword') && $request->filled('newpassword')) {
                if (Hash::check($request->input('oldpassword'), $user->password)) {
                    $user->password = Hash::make($request->newpassword);
                    $user->save();
                } else {
                    return $this->send_error(101, ['old password is wrong']);
                }
            } else {
                return $this->send_error(101, ['new password required']);
            }
        }
        return $this->send_data('data' ,(new UserDataResource($user)));
    }
}
