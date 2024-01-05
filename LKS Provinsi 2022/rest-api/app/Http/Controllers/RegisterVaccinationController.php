<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Society;
use App\Models\User;
use App\Models\Vaccination;
use App\Models\VaccinationSpot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Ramsey\Uuid\Exception\DateTimeException;

class RegisterVaccinationController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'spot_id' => 'required|string',
            'date' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()], 422);
        }

        $inputToken = $request->input('token');
        $user = Society::where('login_tokens', $inputToken)->first();
        $userSocietyId = $user->id;

        $consultation = Consultation::where('society_id', $userSocietyId)->first();
        $consultationStatus = $consultation->status;
        $consultationId = $consultation->id;

        // Check user vaccination
        $societyIdCount = Vaccination::where('society_id', $userSocietyId)->count();

        // Check vaccination date
        $societyDate = Vaccination::find($userSocietyId)
            ->where('date', $request->input('date'))
            ->first();

        $vaccinationDate = Carbon::parse($request->input('date'));
        $currentDate = Carbon::parse($societyDate->date ?? null);
        $daysDifference = $currentDate->diffInDays($vaccinationDate);

        if ($consultationStatus === "pending") {
            return response()->json(['message' => 'Your consultation must be accepted by the doctor before'], 422);
        } else if ($societyIdCount >= 2) {
            return response()->json(['message' => 'Society has been 2x vaccinated'], 422);
        } else if ($daysDifference < 30) {
            return response()->json(['message' => 'Vaccination must be 30 days after dose one!'], 422);
        } else {
            // Continue with the vaccination creation logic
            $formData = $request->only(['spot_id', 'date', 'vaccine_id', 'doctor_id']);
            $formData['society_id'] = $userSocietyId;

            // Handle add dose
            $existingDose = Vaccination::where('society_id', $userSocietyId)->max('dose');

            // Increment dose when the user stores vaccination again
            $vaccinationData = Vaccination::create($formData);
            $vaccinationData->dose = $existingDose + 1;
            $vaccinationData->save();

            return response()->json($vaccinationData, 200);
        }
    }

    public function get(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => "required|string"
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()], 422);
        }

        $society = Society::where('login_tokens', $request->token)->first();

        $vaccinations = Vaccination::where("society_id", $society->id)->orderBy("date")->get();

        if (!$vaccinations) {
            return response()->json(['error' => 'Vaccination not found'], 404);
        }

        return $this->ok($vaccinations);
    }
}
