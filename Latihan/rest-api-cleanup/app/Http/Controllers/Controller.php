<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function success($data, $code = 200)
    {
        return response()->json($data, $code);
    }

    public function failed($data, $code = 500)
    {
        return response()->json($data, $code);
    }
}
