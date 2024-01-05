<?php

namespace App\Http\Controllers;

use App\Models\Societies;
use App\Models\Validations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValidationController extends Controller
{
    public function index(Request $request)
    {
        $society = Societies::where("login_tokens", $request->token)->first();

        if (!$society || !$request->token)
            return $this->failed(["message" => "Unauthorized user"], 401);

        $validation = Validations::with("job_category")->where('society_id', $society->id)
            ->get(["id", "status", "work_experience", "job_category_id", "job_position", "reason_accepted", "validator_notes", "validator_id"]);

        return $this->success(["validation" => $validation]);
    }

    public function store(Request $request)
    {
        $society = Societies::where("login_tokens", $request->token)->first();

        if (!$society || !$request->token)
            return $this->failed(["message" => "Unauthorized user"], 401);

        $validation = new Validations();
        $validation->work_experience = $request->work_experience;
        $validation->job_category_id = $request->job_category_id;
        $validation->job_position = $request->job_position;
        $validation->reason_accepted = $request->reason_accepted;
        $validation->society_id = $society->id;
        $validation->save();

        return $this->success(["message" => "Request data validation sent successful"], 200);
    }
}
