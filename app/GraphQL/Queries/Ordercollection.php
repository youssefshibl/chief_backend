<?php

namespace App\GraphQL\Queries;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class Ordercollection
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {

        $id = Auth::guard('api')->user()->id;
        $orderscollections = User::find($id)->ordercollections()->where('completed', 0)->orderBy('created_at', 'DESC')->get();
        return $orderscollections;
    }
}
