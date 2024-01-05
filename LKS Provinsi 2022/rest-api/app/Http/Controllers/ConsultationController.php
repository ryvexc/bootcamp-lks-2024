<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Society;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function store(Request $request)
    {
        if (!$request->token) {
            return $this->unauthorized();
        }

        $society = Society::where("login_tokens", $request->token)->first();
        if (!$society) {
            return $this->unauthorized();
        }

        $consultation = new Consultation();
        $consultation->society_id = $society->id;
        $consultation->disease_history = $request->disease_history;
        $consultation->current_symptoms = $request->current_symptoms;
        $consultation->save();

        return $this->ok(["message" => "Request consultation sent successful"]);
    }

    public function get(Request $request)
    {
        if (!$request->token) {
            return $this->unauthorized();
        }

        $society = Society::where("login_tokens", $request->token)->first();
        if (!$society) {
            return $this->unauthorized();
        }

        $consultation = Consultation::where("society_id", $society->id)->orderBy("id", "desc")->first();

        return $this->ok($consultation);
    }
}
