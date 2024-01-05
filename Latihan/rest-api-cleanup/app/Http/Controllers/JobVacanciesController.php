<?php

namespace App\Http\Controllers;

use App\Models\JobApplyPositions;
use App\Models\JobVacancies;
use App\Models\Societies;
use App\Models\Validations;
use Illuminate\Http\Request;

class JobVacanciesController extends Controller
{
    public function index(Request $request)
    {
        $society = Societies::where("login_tokens", $request->token)->first();

        if (!$society || !$request->token)
            return $this->failed(["message" => "Unauthorized user"], 401);

        $validations = Validations::with("job_category")
            ->where("society_id", $society->id)
            ->where("status", "accepted")
            ->first();

        $job_vacancies = JobVacancies::where("job_category_id", $validations->job_category_id)->get();

        return $this->success([
            "vacancies" => $job_vacancies->map(function ($vacancies) use ($society) {
                $job_apply_position = JobApplyPositions::where("job_vacancy_id", $vacancies->id)->where("society_id", $society->id);
                $vacancies["applied_by_user"] = $job_apply_position->count() > 0;
                return $vacancies;
            })
        ]);
    }

    public function detail(Request $request, $id)
    {
        $society = Societies::where("login_tokens", $request->token)->first();

        if (!$society || !$request->token)
            return $this->failed(["message" => "Unauthorized user"], 401);

        $job_vacancy = JobVacancies::where('id', $id)->first();

        foreach ($job_vacancy->available_position as &$available_position) {
            $count = JobApplyPositions::where("position_id", $available_position->id)
                ->where("job_vacancy_id", $job_vacancy->id)
                ->count();

            $available_position->apply_count = $count;
        }

        return $this->success(["vacancy" => $job_vacancy]);
    }
}
