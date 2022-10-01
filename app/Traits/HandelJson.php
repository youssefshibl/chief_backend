<?php

namespace App\Traits;

use Illuminate\Validation\Validator;

trait HandelJson
{

    public function send_error($number, $message)
    {
        return response()->json([
            'status' => false,
            'number' => $number,
            'message' => $message,
        ]);
    }
    public function send_data($key, $data)
    {
        return response()->json([
            'status' => true,
            $key => $data,
        ]);
    }
    public function send_succ()
    {
        return response()->json([
            'status' => true,
        ]);
    }
    public function get_array_of_message_error(Validator $validator)
    {
        $errors = $validator->errors()->toArray();

        $array_errors = [];
        foreach ($errors as $key => $value) {
            $array_errors[] =  $value[0];
        }
        return $array_errors;
    }
};
