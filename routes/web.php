<?php

use App\Http\Controllers\Auth\SocialAuthLogin;
use App\Http\Controllers\Mail\MailActions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// verifie email when user go to link sent to his email
Route::get('/verfie_emai/{id}', [MailActions::class, 'verify_email'])->name('verifie_email');
// socialmedai login
Route::get('/auth/{serv}/redirect', [SocialAuthLogin::class, 'redirect'])->name('social.redirect');
Route::get('/auth/{serv}/callback', [SocialAuthLogin::class, 'callback'])->name('social.callback');

Route::get('test', function () {
    return view('one');
});


Route::post('get', function (Request $request) {
    if ($request->has('filo')) {

        $file = $request->file('filo');
        $file->storeAs('dogs', $file->getClientOriginalName(), 'ftp');
        return 'yes';
    } else {
        return 'no';
    }
})->name('one');

Route::get('one' , function(){
    $one = ['one' ,'tow'];
    return json_encode($one);
});

Route::get('two' , function(){
    $one = ['one' ,'tow'];
    return $one;
});
