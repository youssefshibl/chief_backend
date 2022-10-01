<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPassword;
use App\Http\Controllers\Auth\SocialAuthLogin;
use App\Http\Controllers\Mail\MailActions;
use App\Http\Controllers\Payment\PaymentMain;
use App\Http\Controllers\User\UpdateUser;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserResourceCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/test', function () {
    $user = auth()->guard('api')->user()->orders;
    $order = $user->where('id', 20)->first();
    return $order;
})->middleware('auth:api');

// Route::get('/test', function () {

//     //$data =  UserResource::collection(User::all());
//     $data = new UserResourceCollection(User::all());
//     return $data;
// });

Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    // if auth api middleware is failded go to this
    Route::get('authfiled', [AuthController::class, 'failed'])->name('authfailed');
    Route::get('check', [AuthController::class, 'check_auth']);
    // send another link to verifiy email , past link is expired
    Route::get('send_mail_verify_again', [MailActions::class, 'generate_other_link']);
    // reset password "send mail token "
    Route::post('resetpassword', [ResetPassword::class, 'send_mail_reset']);
    // check if the token reset password is valid
    Route::post('checkresetpasswordtoken', [ResetPassword::class, 'check_token_reset_password']);
    // reset password
    Route::post('resetpassword/new', [ResetPassword::class, 'changepassword']);
    Route::post('updateuser', [UpdateUser::class, 'updaetuser']);
});

Route::group(['prefix' => 'payment'], function () {
    Route::get('stripe_key', [PaymentMain::class, 'stripe_key']);
    Route::post('payment_process', [PaymentMain::class, 'Paymentprocess']);
});
Route::get('lol', function () {
    return Hash::make("123456");
});
