<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class AddAddress
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
        $user->address()->create([
            'country' => $args['country'],
            'phone' => $args['phone'],
            'adress' => $args['adress'],
            'Postal_Code' => $args['Postal_Code'],
            'state' => $args['state'],
        ]);
        return $user;
    }
}
