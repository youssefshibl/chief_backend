<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Mail\SendTokenResetPassword;
use App\Mail\SendVerifie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MailSystem extends Controller
{
    //
    static function SendVerifie(User $user)
    {
        $email = $user->email;

        Mail::to($email)->send(new SendVerifie($user));
    }
    static function SendResetPassword(User $user , $token)
    {
        $email = $user->email;
        Mail::to($email)->send(new SendTokenResetPassword($token));
    }
}
