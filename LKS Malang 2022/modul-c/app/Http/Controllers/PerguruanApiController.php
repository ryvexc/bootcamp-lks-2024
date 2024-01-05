<?php

namespace App\Http\Controllers;

use App\Models\Perguruan;
use Illuminate\Http\Request;

class PerguruanApiController extends Controller
{
    public function index()
    {
        $perguruan = Perguruan::all();
        return response()->json($perguruan, 200);
    }

    public function detail(Request $request)
    {
        $perguruan = Perguruan::find($request->id);
        return response()->json($perguruan, 200);
    }
}
