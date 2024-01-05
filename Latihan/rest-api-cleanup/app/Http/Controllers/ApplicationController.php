<?php

namespace App\Http\Controllers;

use App\Models\JobApplyPositions;
use App\Models\JobApplySocietes;
use App\Models\Societies;
use App\Models\Validations;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        try {
            $society = Societies::where("login_tokens", $request->token)->first();

            if (!$society || !$request->token)
                return $this->failed(["message" => "Unauthorized user"], 401);

            $request->validate([
                "positions" => "required",
                "vacancy_id" => "required"
            ]);

            if (!Validations::where("society_id", $society->id)->where("status", "accepted")->first())
                return $this->failed(["message" => "Your data validator must be accepted by validator before"], 401);

            if (
                JobApplyPositions::where("society_id", $society->id)
                ->where("job_vacancy_id", $request->vacancy_id)
                ->first()
            ) return $this->failed(["message" => "Application for a job vacancy can only be once"], 401);

            $job_apply_societies = new JobApplySocietes();
            $job_apply_societies->notes = $request->notes;
            $job_apply_societies->date = Carbon::now();
            $job_apply_societies->society_id = $society->id;
            $job_apply_societies->job_vacancy_id = $request->vacancy_id;
            $job_apply_societies->save();

            $job_apply_positions = new JobApplyPositions();
            $job_apply_positions->date = Carbon::now();
            $job_apply_positions->society_id = $society->id;
            $job_apply_positions->job_vacancy_id = $request->vacancy_id;
            $job_apply_positions->position_id = $request->positions;
            $job_apply_positions->job_apply_societies_id = $job_apply_societies->id;
            $job_apply_positions->status = "pending";
            $job_apply_positions->save();

            return $this->success(["message" => "applying for job successful"]);
        } catch (ValidationException $e) {
            return $this->failed([
                "message" => "Invalid field",
                "errors" => $e->errors()
            ], 401);
        }
    }

    public function show(Request $request)
    {
        $society = Societies::where("login_tokens", $request->token)->first();

        if (!$society || !$request->token)
            return $this->failed(["message" => "Unauthorized user"], 401);

        $job_apply_positions = JobApplySocietes::with("position")->where("society_id", $society->id)->get();

        // $data = $job_apply_positions->map(function ($job_application) {
        //     $job_vacancy 
        // });

        // foreach ($job_apply_positions as $job_application_raw) {
        //     $job_application = get_object_vars($job_application_raw);

        //     $job_vacancy = DB::table("job_vacancies")->where("id", $job_application["job_vacancy_id"]);
        //     $job_category = DB::table("job_categories")->where("id", $job_vacancy->value("job_category_id"))->first();
        //     $job_position = DB::table("available_positions")->select("position", "id")->where("id", $job_application["position_id"]);

        //     $data[] = [
        //         "id" => $job_vacancy->value("id"),
        //         "category" => $job_category,
        //         "company" => $job_vacancy->value("company"),
        //         "address" => $job_vacancy->value("address"),
        //         "apply_date" => date("F d, Y", strtotime($job_apply_positions->value("date"))),
        //         "notes" => DB::table("job_apply_societies")->select("notes")->where("id", $job_application["job_apply_societies_id"])->value("notes"),
        //         "position" => array_map(function ($position) use ($society, $job_vacancy) {
        //             $job_apply = DB::table("job_apply_positions")
        //                 ->select("status")
        //                 ->where("position_id", get_object_vars($position)["id"])
        //                 ->where("society_id", $society->value("id"))
        //                 ->where("job_vacancy_id", $job_vacancy->value("id"));
        //             return [
        //                 "position" => get_object_vars($position)["position"],
        //                 "apply_status" => $job_apply->value("status"),
        //             ];
        //         }, $job_position->get()->toArray()),
        //     ];
        // }


        return $this->success(["vacancies" => $job_apply_positions], 200);
    }
}
