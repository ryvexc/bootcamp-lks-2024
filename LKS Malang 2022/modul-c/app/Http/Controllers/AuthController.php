<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            "email" => "required",
            "password" => "required"
        ]);

        $identified = User::all()->where("status", 1)->where("email", $request->email)->where("password", md5($request->password))->first();

        if ($identified) {
            return redirect("/dashboard")->withCookie(cookie()->forever('name', $identified->name));
        } else {
            return redirect()->back();
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => md5($request->password),
            'is_admin' => 0,
            'status' => 1
        ]);
        return redirect("/form");
    }

    public function external_login(Request $request)
    {
        $request->validate([
            "email" => "required",
            "password" => "required"
        ]);

        $identified = User::all()->where("status", 1)->where('is_admin', 0)->where("email", $request->email)->where("password", md5($request->password))->first();

        if ($identified) {
            return response()->json(["authenticated" => true], 200);
        } else {
            return response()->json(["authenticated" => false], 401);
        }
    }

    public function external_register(Request $request)
    {
        try {
            $request->validate([
                "email" => "required",
                "name" => "required",
                "password" => "required"
            ]);

            $user = new User();
            $user->email = $request->email;
            $user->password = $request->password;
            $user->name = $request->name;
            $user->is_admin = 0;
            $user->status = 1;
            $user->save();

            return response()->json(["registered" => true]);
        } catch (ValidationException $e) {
            return response()->json(["registered" => false], 401);
        }
    }

    public function logout()
    {
        return redirect("/")->withCookie(cookie()->forget("name"));
    }
}
