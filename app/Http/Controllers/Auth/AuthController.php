<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Mail\MailSystem;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HandelJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use HandelJson;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'failed', 'check_auth']]);
    }

    public function register(Request $request)
    {

        $rules = [
            'name' => 'unique:users|required',
            'email'    => 'unique:users|required',
            'password' => 'required',
        ];


        $input     = $request->only('name', 'email', 'password');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return $this->send_error(101, $this->get_array_of_message_error($validator));
        }
        $name = $request->name;
        $email    = $request->email;
        $password = $request->password;
        $user     = User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password)]);
        $token = Auth::guard('api')->login($user);
        MailSystem::SendVerifie($user);
        $handledata = (new UserResource($user));
        return $this->send_data('data', [
            'token' => $token,
            'user' => $handledata
        ]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->send_error(101, $this->get_array_of_message_error($validator));
        }
        $credentials = request(['email', 'password']);

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            //return response()->json(['error' => 'Unauthorized'], 401);
            return $this->send_error('101', 'Unauthenticated');
        }
        $user = User::where('email', $request->input('email'))->first();

        $handledata = (new UserResource($user));
        return $this->send_data('data', [
            'token' => $token,
            'user' => $handledata
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return $this->send_succ();
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
    public function failed()
    {
        return $this->send_error('101', 'Unauthenticated');
    }

    public function check_auth(Request $request)
    {

        if (auth()->guard('api')->check()) {
            if ($request->has('withdata')) {
                $verified = auth()->guard('api')->user()->email_verified_at;
                $handledata = (new UserResource(auth()->guard('api')->user()));
                return $this->send_data('data', [
                    'verified' => $verified,
                    'user' => $handledata
                ]);
            }
            $verified = auth()->guard('api')->user()->email_verified_at;
            return $this->send_data('verified', $verified);
        } else {
            return $this->send_error('101', 'Unauthenticated');
        }
    }
}
