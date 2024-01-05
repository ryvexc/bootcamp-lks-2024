<?php

namespace App\Http\Controllers;

use App\Models\Society;
use App\Models\Spot;
use App\Models\Vaccination;
use App\Models\VaccinationSpot;
use App\Models\Vaccines;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VaccinationSpotController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->token) {
            return $this->unauthorized();
        }

        $society = Society::where("login_tokens", $request->token)->first();

        if (!$society) {
            return $this->unauthorized();
        }

        $vaccines = Vaccines::all();

        $spots = Spot::with("junction")->where("regional_id", $society->regional->id)->get();
        $spots = $spots->map(function ($spot) use ($vaccines) {
            $d = [];

            foreach ($vaccines as $vaccine) $d[$vaccine->name] = false;
            foreach ($spot->junction as $junction) $d[$junction->vaccine->name] = true;

            $spot->available_vaccine = $d;
            unset($spot->junction);

            return $spot;
        });

        return $this->ok(["spots" => $spots]);
    }

    public function detail(Request $request, $spot_id)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()]);
        }

        $date = $request->input('date');

        $spotVacinationsCount = Spot::withCount('vaccinations_count as total_doses')
            ->with('vaccinations_count')
            ->find($spot_id);

        // Handle get vaccination by date
        $vaccinationByDate = Spot::with(['vaccinations_count' => function ($query) use ($date) {
            $query->whereDate('date', $date);
        }])
            ->find($spot_id);

        // Handle get total dose
        $totalDose = $spotVacinationsCount->total_doses;

        $spot = Spot::with('spot_vaccine.vaccine')
            ->find($spot_id);

        if (!$spot) {
            return response()->json(['Error' => 'Spots not found']);
        }

        return response()->json([
            'date' => $request->input('date'),
            'spot' => $spot,
            'vaccinations_count_list' => $spotVacinationsCount->vaccinations_count,
            'vaccination_list_date' => $vaccinationByDate->vaccinations_count,
            'vaccinations_count' => $totalDose
        ], 200);
    }
}
