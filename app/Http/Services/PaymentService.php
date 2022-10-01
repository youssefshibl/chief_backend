<?php

namespace App\Http\Services;

use App\Http\Resources\AddressOrderResource;
use App\Models\Ordercollection;
use App\Models\User;
use App\Traits\HandelJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PaymentService
{
    use HandelJson;
    public function MakePayment(Request $request)
    {
        // make validation
        $rules = [
            'address_id' => 'required',
            'payment_method'    => 'required',
        ];
        $input     = $request->only('address_id', 'payment_method');
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return $this->send_error(101, $this->get_array_of_message_error($validator));
        }
        // get $id of auth
        $id = Auth::guard('api')->user()->id;
        $user = User::find($id);
        // get address
        $addrss = $user->address()->where('id', $request->input('address_id'))->first();
        if (!$addrss) {
            return $this->send_error(109, 'the address is require');
        }
        $addrss_encoder = json_encode(new AddressOrderResource($addrss));
        // get orders
        $orders = $user->orders()->where('finished', 0)->get();
        if ($orders->isEmpty()) {
            return $this->send_error(109, 'you dont have orders');
        }
        // calc the total price
        $total_price = 0;
        foreach ($orders as $order) {
            $total_price += ($order->number * $order->menu->price);
        }
        if ($total_price == 0) {
            return $this->send_error(109, 'sorry some thing is error');
        }
        // method of payment action
        if ($request->input('payment_method') == "inhome") {
            $payment =  $user->payments()->create([
                'payment_method' => 'inhome',
                'value' => sprintf("%.2f", $total_price),
            ]);
            $ordercollection = $user->ordercollections()->create([
                'address' => $addrss_encoder,
                'payment_method' => 'inhome',
                'payment_id' => $payment->id
            ]);
            // return $ordercollections;
        } elseif ($request->input('payment_method') == "visa") {
            $payment_method_id =  $request->input('payment_method_id');
            if (!$payment_method_id) {
                return $this->send_error(109, 'payment method id is required');
            }
            try {
                $payment_method = $user->charge(
                    $total_price * 100,
                    $payment_method_id
                );
                $payment_method = $payment_method->asStripePaymentIntent();
                $payment =  $user->payments()->create([
                    'payment_method' => 'visa',
                    'value' => sprintf("%.2f", $payment_method->charges->data[0]->amount / 100),
                    'status' => 1,
                    'transaction_id' => $payment_method->charges->data[0]->id
                ]);
                $ordercollection = $user->ordercollections()->create([
                    'address' => $addrss_encoder,
                    'payment_method' => 'visa',
                    'payment_id' => $payment->id
                ]);
            } catch (\Exception $e) {
                return $this->send_error(110, $e->getMessage());
                //return response()->json(['message' => $e->getMessage()], 500);
            }
        }
        $ordercollection->orders()->attach($orders->pluck('id')->toArray());
        $order_collection = Ordercollection::find($ordercollection->id);
        DB::table('orders')->where('user_id', $user->id)->where('finished', 0)->update([
            'finished' => 1
        ]);
        return $this->send_succ();
    }
}
