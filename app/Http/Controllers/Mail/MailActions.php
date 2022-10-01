<?php
/*
this class to make all action done when user visited links
which related mail system

*/

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\HandelJson;
use App\Traits\RedirectFront;
use Illuminate\Http\Request;


class MailActions extends Controller
{
    //
    use RedirectFront, HandelJson;
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['verify_email']]);
    }

    public function verify_email($id, Request $request)
    {
        // check the sign link
        if (!$request->hasValidSignature()) {
            //return 'end time';
            return $this->error_front('the time of this link to verify you email is end sorry !', 'try to generate another link !', 'send_email');
        } else {
            // if link is valid change the verified column to time now
            $user = User::find($id);
            $date = date("Y-m-d g:i:s");
            $user->email_verified_at = $date;
            $user->save();
            return $this->go_front('about');

        }
    }

    public function generate_other_link()
    {
        MailSystem::SendVerifie(auth()->guard('api')->user());
        return $this->send_succ();
    }

}
