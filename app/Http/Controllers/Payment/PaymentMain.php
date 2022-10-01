<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Services\PaymentService;
use App\Traits\HandelJson;
use Illuminate\Http\Request;


class PaymentMain extends Controller
{
    //
    use HandelJson;
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function stripe_key()
    {
        $stripe_key = env('STRIPE_KEY');
        return $this->send_data('stripe_key', $stripe_key);
    }
    public function Paymentprocess(Request $request)
    {
        $payment = new PaymentService();
        return $payment->MakePayment($request);
    }
}
