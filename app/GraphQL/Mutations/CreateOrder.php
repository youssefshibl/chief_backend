<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class CreateOrder
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver

        $id = Auth::guard('api')->user()->id;
        $user = User::find($id);
        $old_order = $user->orders()->where('menu_id', $args['menu_id'])->where('finished', 0)->first();
        if ($old_order) {
            $old_order->increment('number', $args['number']);
            return $old_order;
        } else {
            $order = $user->orders()->create(['menu_id' => $args['menu_id'], 'payment_method' => 'no', 'number' => $args['number']]);
            return $order;
        }
    }
}
