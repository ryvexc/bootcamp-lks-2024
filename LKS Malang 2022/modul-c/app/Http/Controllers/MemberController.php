<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $members = User::all();

        if ($request->search)
            $members = User::where($request->search, "like", "%" . $request->q . "%")->get();

        return view("member", [
            "members" => $members
        ]);
    }

    public function toggleStatus(Request $request)
    {
        $request->validate([
            "id" => "required",
            "status" => "required"
        ]);

        User::find($request->id)->update([
            "status" => !$request->status
        ]);

        return redirect()->back();
    }
}
