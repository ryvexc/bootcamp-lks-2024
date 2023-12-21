<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $society = DB::table("societies")->where("login_tokens", $request->input("token"));

        if (empty($request->input("token")) || $society->count() == 0) {
            return response()->json([
                "message" => "Unauthorized user"
            ], 401);
        }

        if (empty($request->positions) || empty($request->vacancy_id)) {
            return response()->json([
                "message" => "Invalid field",
                "errors" => [
                    "vacancy_id" => [
                        "The vacancy id field is required."
                    ],
                    "positions" => [
                        "The positions field is required."
                    ]
                ]
            ], 401);
        }

        if (DB::table("validations")->where("society_id", $society->value("id"))->where("status", "accepted")->count() == 0) {
            return response()->json([
                "message" => "Your data validator must be accepted by validator before"
            ], 401);
        }

        if (
            DB::table("job_apply_positions")
            ->where("society_id", $society->value("id"))
            ->where("job_vacancy_id", $request->vacancy_id)
            ->count() > 0
        ) {
            return response()->json([
                "message" => "Application for a job can only be once"
            ]);
        }

        $inserted_job_apply_societies_id = DB::table("job_apply_societies")->insertGetId([
            "notes" => $request->notes,
            "date" => Carbon::now(),
            "society_id" => $society->value("id"),
            "job_vacancy_id" => $request->vacancy_id
        ]);

        DB::table("job_apply_positions")->insert([
            "date" => Carbon::now(),
            "society_id" => $society->value("id"),
            "job_vacancy_id" => $request->vacancy_id,
            "position_id" => $request->positions,
            "job_apply_societies_id" => $inserted_job_apply_societies_id,
            "status" => "pending"
        ]);

        return response()->json(["message" => "applying for job successful"], 200);
    }

    public function show(Request $request)
    {
        $society = DB::table("societies")->where("login_tokens", $request->input("token"));

        if (empty($request->input("token")) || $society->count() == 0) {
            return response()->json([
                "message" => "Unauthorized user"
            ], 401);
        }
        $data = [];

        $job_apply_positions = DB::table("job_apply_positions")->where("society_id", $society->value("id"))->get();

        foreach ($job_apply_positions as $job_application_raw) {
            $job_application = get_object_vars($job_application_raw);

            $job_vacancy = DB::table("job_vacancies")->where("id", $job_application["job_vacancy_id"]);
            $job_category = DB::table("job_categories")->where("id", $job_vacancy->value("job_category_id"))->first();
            $job_position = DB::table("available_positions")->select("position", "id")->where("id", $job_application["position_id"]);

            $data[] = [
                "id" => $job_vacancy->value("id"),
                "category" => $job_category,
                "company" => $job_vacancy->value("company"),
                "address" => $job_vacancy->value("address"),
                "apply_date" => date("F d, Y", strtotime($job_apply_positions->value("date"))),
                "notes" => DB::table("job_apply_societies")->select("notes")->where("id", $job_application["job_apply_societies_id"])->value("notes"),
                "position" => array_map(function ($position) use ($society, $job_vacancy) {
                    $job_apply = DB::table("job_apply_positions")
                        ->select("status")
                        ->where("position_id", get_object_vars($position)["id"])
                        ->where("society_id", $society->value("id"))
                        ->where("job_vacancy_id", $job_vacancy->value("id"));
                    return [
                        "position" => get_object_vars($position)["position"],
                        "apply_status" => $job_apply->value("status"),
                    ];
                }, $job_position->get()->toArray()),
            ];
        }


        return response()->json([
            "vacancies" => $data
        ], 200);
    }
}
