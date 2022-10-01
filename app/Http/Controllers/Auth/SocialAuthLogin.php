<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\RedirectFront;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthLogin extends Controller
{
    //
    use RedirectFront;
    public function redirect($serv)
    {

        //
        return Socialite::driver($serv)->redirect();
    }
    public function callback($serv)
    {
        //

        //    $user = Socialite::with($serv)->user();
        //    dd($user);
        $githubUser = Socialite::driver($serv)->user();
        //dd($githubUser);
        $user = User::updateOrCreate([
            'auth_id' => $githubUser->id,
            'auth_type' => $serv,

        ], [
            'name' => $githubUser->name,
            'email' => $githubUser->email,
            'password' => bcrypt($githubUser->id),
            'premium' => 0,
            'email_verified_at' => date("Y-m-d g:i:s"),

        ]);

        $token = Auth::guard('api')->login($user);


        return $this->go_front('multiredirect?function=sociallogin&token=' . $token);
    }
}
