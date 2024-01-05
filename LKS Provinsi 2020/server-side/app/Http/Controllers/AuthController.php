<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            "username" => "required|min:4",
            "password" => "required|min:6|max:8"
        ]);

        if (!$validated) return $this->error("Invalid username or password");

        $user = User::where("username", $request->username)->first();
        if (!$user) return $this->error("Invalid username or password");

        if (Hash::check($request->password, $user->password)) {
            return $this->ok(["token" => JWTAuth::fromUser($user)]);
        };

        return $this->error("Invalid username or password");
    }
}
