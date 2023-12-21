<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $societies = DB::table('societies')
            ->where('id_card_number', $request->post('id_card_number'))
            ->where("password", $request->post('password'));
        $regional = DB::table('regionals')
            ->where('id', $societies->value('regional_id'));

        $passwordHash = md5($societies->value("id_card_number"));

        DB::table("societies")
            ->where('id_card_number', $request->post('id_card_number'))
            ->update(["login_tokens" => $passwordHash]);

        if ($regional->count() > 0) {
            return response()->json([
                "name" => $societies->value("name"),
                "born_date" => $societies->value("born_date"),
                "gender" => $societies->value("gender"),
                "address" => $societies->value("address"),
                "token" => $passwordHash,
                "regional" => [
                    "id" => $regional->value("id"),
                    "province" => $regional->value("province"),
                    "district" => $regional->value("district"),
                ]
            ], 200);
        } else {
            return response()->json([
                "message" => "ID Card Number or Password incorrect",
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        $societies = DB::table('societies')
            ->where('login_tokens', $request->input("token"));

        if ($societies->count() > 0 && !empty($request->input("token"))) {
            DB::table("societies")
                ->where('login_tokens', $request->input('token'))
                ->update(["login_tokens" => NULL]);

            return response()->json([
                "message" => "Logout success",
            ], 200);
        } else {
            return response()->json([
                "message" => "Invalid token",
            ], 401);
        }
    }
}
