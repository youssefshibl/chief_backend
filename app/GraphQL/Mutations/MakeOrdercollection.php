<?php

namespace App\GraphQL\Mutations;

use App\Http\Resources\AddressOrderCollection;
use App\Http\Resources\AddressOrderResource;
use App\Http\Resources\AddressResource;
use App\Http\Resources\OrderCollectionTextResource;
use App\Models\Ordercollection;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class MakeOrdercollection
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver

        // $id = Auth::guard('api')->user()->id;
        // $user = User::find($id);
        // $addrss = $user->address()->where('id', $args['address_id'])->first();
        // if (!$addrss) {
        //     return "no address";
        // }
        // $addrss_encoder = json_encode(new AddressOrderResource($addrss));
        // $orders = $user->orders()->where('finished', 0)->get();
        // if ($args['payment_method'] == "inhome") {
        //     $ordercollection = $user->ordercollections()->create([
        //         'address' => $addrss_encoder,
        //         'payment_method' => 'inhome'
        //     ]);
        //     // return $ordercollections;
        // } elseif ($args['payment_method'] == "visa") {

        //     $payment_data = json_decode($args['Payment_data'], true);
        //     $total_price = 0;
        //     foreach ($orders as $order) {
        //         $total_price += ($order->number * $order->menu->price);
        //     }
        //     try {
        //         $payment = $user->charge(
        //             3000,
        //             $payment_data['payment_method_id']
        //         );
        //         $payment = $payment->asStripePaymentIntent();
        //         $ordercollection = $user->ordercollections()->create([
        //             'address' => $addrss_encoder,
        //             'payment_method' => 'visa'
        //         ]);
        //     } catch (\Exception $e) {
        //         return response()->json(['message' => $e->getMessage()], 500);
        //     }
        // }
        // $ordercollection->orders()->attach($orders->pluck('id')->toArray());
        // $order_collection = Ordercollection::find($ordercollection->id);
        // DB::table('orders')->where('user_id', $user->id)->where('finished', 0)->update([
        //     'finished' => 1
        // ]);
        // return $order_collection;
    }
}
