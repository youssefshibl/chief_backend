<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Mail\MailSystem;
use App\Models\Tokenpassword;
use App\Models\User;
use App\Traits\HandelJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ResetPassword extends Controller
{
    //
    use HandelJson;
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['send_mail_reset', 'check_token_reset_password']]);
    }
    public function send_mail_reset(Request $request)
    {
        $rules = [
            'email'    => 'exists:users|required',
        ];
        $input     = $request->only('email');
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return $this->send_error('102', $this->get_array_of_message_error($validator));
        }
        $user = User::where('email', $request->input('email'))->first();
        $token = Str::random(32);

        MailSystem::SendResetPassword($user, $token);
        Tokenpassword::updateOrCreate(['user_id' => $user->id], ['token' => $token]);
        return $this->send_succ();
    }
    public function check_token_reset_password(Request $request)
    {
        $token = $request->token;
        if (Tokenpassword::where('token', $token)->first()) {
            return $this->send_succ();
        } else {
            return $this->send_error(110, 'the token is not valid');
        }
    }
    public function changepassword(Request $request)
    {
        $token = $request->token;
        $password = $request->password;
        $token = Tokenpassword::where('token', $token)->first();
        if ($token) {
            $user = $token->user;
            $user->password = Hash::make($password);
            $user->save();
            $general_token = Auth::guard('api')->login($user);
            return $this->send_data('token', $general_token);
        }
        return $this->send_error(111, 'token to valid');
    }
}
