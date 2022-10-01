<?php

namespace App\GraphQL\Queries;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class Myorders
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
        $id = Auth::guard('api')->user()->id;
        $orders = User::find($id)->orders()->where('finished', 0)->get();
        return $orders;
    }
}
