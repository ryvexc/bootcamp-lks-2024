<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function ok($data)
    {
        return response()->json($data);
    }

    public function error($msg)
    {
        return response()->json(["error" => $msg], 422);
    }
}
