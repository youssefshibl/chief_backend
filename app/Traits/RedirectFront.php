<?php

namespace App\Traits;

trait RedirectFront
{
    public function error_front($mess, $solu, $action = '')
    {
        $message = $mess;
        $solution = $solu;
        $front_end = env('FRONT_END_URL') . "errors?message=$message&solution=$solution&action=$action";
        return redirect()->away($front_end);
    }
    public function go_front($path)
    {
        $url = env('FRONT_END_URL') . $path;
        return redirect()->away($url);
    }
}
