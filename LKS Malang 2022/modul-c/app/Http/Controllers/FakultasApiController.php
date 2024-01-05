<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use Illuminate\Http\Request;

class FakultasApiController extends Controller
{
    public function index(Request $request)
    {
        $fakultas = Fakultas::with("jurusan")->where("id", $request->id)->first();
        return response($fakultas, 200);
    }
}
