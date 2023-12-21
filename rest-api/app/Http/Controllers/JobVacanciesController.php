<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobVacanciesController extends Controller
{
    public function index(Request $request)
    {
        $society = DB::table("societies")->where("login_tokens", $request->input("token"));

        if (empty($request->input("token")) || $society->count() == 0) {
            return response()->json([
                "message" => "Unauthorized user"
            ], 401);
        }

        $validations = DB::table("validations")->where("society_id", $society->value("id"))->where("status", "accepted")->get("job_category_id");
        $job_vacancies = DB::table("job_vacancies")->where("job_category_id", $validations->value("job_category_id"))->get("*");

        $data = [];

        foreach ($job_vacancies as $job_raw) {
            $job = get_object_vars($job_raw);

            $job_category = DB::table("job_categories")->where("id", $job["job_category_id"])->first();
            $available_positions = DB::table("available_positions")->select(["position", "capacity", "apply_capacity"])->where("job_vacancy_id", $job["id"])->get();

            $job_apply_position = DB::table("job_apply_positions")->where("job_vacancy_id", $job["id"])->where("society_id", $society->value("id"));

            $data[] = [
                "id" => $job['id'],
                "category" => $job_category,
                "company" => $job["company"],
                "address" => $job["address"],
                "description" => $job["description"],
                "available_position" => $available_positions,
                "applied_by_user" => $job_apply_position->count() > 0,
            ];
        }

        return response()->json([
            "vacancies" => $data
        ], 200);
    }

    public function detail(Request $request, $id)
    {
        $society = DB::table("societies")->where("login_tokens", $request->input("token"));

        if (empty($request->input("token")) || $society->count() == 0) {
            return response()->json([
                "message" => "Unauthorized user"
            ], 401);
        }

        $job_vacancies = DB::table("job_vacancies")->where("id", $id)->get();

        $job_category = DB::table("job_categories")->where("id", $job_vacancies->value("job_category_id"))->first();
        $available_positions = DB::table("available_positions")->select(["id", "position", "capacity", "apply_capacity"])->where("job_vacancy_id", $job_vacancies->value("id"))->get();

        return response()->json([
            "vacancy" => [
                "id" => $job_vacancies->value('id'),
                "category" => $job_category,
                "company" => $job_vacancies->value("company"),
                "address" => $job_vacancies->value("address"),
                "description" => $job_vacancies->value("description"),
                "available_position" => array_map(function ($position) use ($job_vacancies) {
                    $job_apply = DB::table("job_apply_positions")->where("position_id", get_object_vars($position)["id"])->where("job_vacancy_id", $job_vacancies->value("id"));
                    return get_object_vars($position) + ["apply_count" => $job_apply->count()];
                }, $available_positions->toArray()),
            ]
        ], 200);
    }
}
