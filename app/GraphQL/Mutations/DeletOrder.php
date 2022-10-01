<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class DeletOrder
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
        $old_order = $user->orders()->where('menu_id', $args['menu_id'])->where('completed', 0)->first();
        $old_order->delete();
        return $old_order;
    }
}
