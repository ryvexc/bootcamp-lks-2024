<?php

namespace App\Http\Controllers;

use App\Models\Societies;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $societies = Societies
            ::where('id_card_number', $request->id_card_number)
            ->where('password', $request->password)
            ->first(["name", "born_date", "gender", "address", "regional_id"]);

        if (!$societies)
            return $this->failed([
                "message" => "ID Card Number or Password incorrect",
            ], 401);

        $passwordHash = md5($societies->value("id_card_number"));

        Societies::where('id_card_number', $request->id_card_number)
            ->update(["login_tokens" => $passwordHash]);

        $societies["token"] = $passwordHash;

        return $this->success($societies);
    }

    public function logout(Request $request)
    {
        $societies = Societies::where('login_tokens', $request->token)->first();

        if ($societies && $request->token) {
            Societies::where('login_tokens', $request->token)
                ->update(["login_tokens" => NULL]);

            return $this->success(["message" => "Logout success"]);
        } else {
            return $this->failed(["message" => "Invalid token"], 401);
        }
    }
}
