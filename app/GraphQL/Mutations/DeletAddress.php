<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class DeletAddress
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
        $addrsses =  $user->address()->where('id', $args['address_id'])->first();
        $addrsses->delete();
        return $user;
    }
}
