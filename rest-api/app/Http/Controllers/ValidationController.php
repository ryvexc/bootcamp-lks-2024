<?php

namespace App\Http\Controllers;

use App\Models\Validations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValidationController extends Controller
{
    public function index(Request $request)
    {
        $society = DB::table("societies")->where("login_tokens", $request->input("token"));
        if (empty($request->input("token")) || $society->count() == 0) {
            return response()->json([
                "message" => "Unauthorized user"
            ], 401);
        }

        $validation = DB::table("validations")
            ->where('society_id', $society->value("id"))
            ->get(["id", "status", "work_experience", "job_category_id", "job_position", "reason_accepted", "validator_notes", "validator_id"]);

        if ($validation->count() == 0) return response()->json([
            "validation" => []
        ]);

        return response()->json([
            "validation" => array_map(function ($v) {
                $_validation = get_object_vars($v);

                $validator = DB::table("validators")->where("id", $_validation["validator_id"])->get("name");
                $job_category = DB::table("job_categories")->where("id", $_validation["job_category_id"])->first();

                return $_validation + ["validator" => $validator->value("name"), "job_category" => $job_category];
            }, $validation->toArray())
        ], 200);
    }

    public function store(Request $request)
    {
        $token = $request->input("token");

        $society = DB::table("societies")->where("login_tokens", $token);

        if ($society->count() > 0 && !empty($request->input("token"))) {
            DB::table("validations")
                ->insert([
                    "work_experience" => $request->post("work_experience"),
                    "job_category_id" => $request->post("job_category_id"),
                    "job_position" => $request->post("job_position"),
                    "reason_accepted" => $request->post("reason_accepted"),
                    "society_id" => $society->value("id")
                ]);

            return response()->json([
                "message" => "Request data validation sent successful",
            ], 200);
        } else {
            return response()->json([
                "message" => "Unauthorized user",
            ], 401);
        }
    }
}
