<?php

namespace App\Http\Controllers;

use App\Models\Society;
use Illuminate\Http\Request;

class SocietyLoginController extends Controller
{
    public function login(Request $request)
    {
        if (!$request->id_card_number || !$request->password) {
            return $this->fail(["message" => "ID Card Number or Password incorrect"]);
        }

        Society::where("id_card_number", $request->id_card_number)->update([
            "login_tokens" => md5($request->id_card_number)
        ]);

        $society = Society::where("id_card_number", $request->id_card_number)
            ->where("password", $request->password)
            ->get(["*", "login_tokens as token"])
            ->first();

        if (!$society) {
            return $this->fail(["message" => "ID Card Number or Password incorrect"]);
        } else {
            return $this->ok($society);
        }
    }

    public function logout(Request $request)
    {
        if (!$request->token) {
            return $this->fail(["message" => "Invalid Token"]);
        }

        $society = Society::where("login_tokens", $request->token)->first();
        if (!$society) {
            return $this->fail(["message" => "Invalid Token"]);
        }

        Society::where("login_tokens", $request->token)->update([
            "login_tokens" => NULL
        ]);

        return $this->ok(["message" => "Logout success"]);
    }
}
