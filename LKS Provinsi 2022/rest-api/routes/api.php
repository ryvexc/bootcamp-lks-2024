<?php

use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\RegisterVaccinationController;
use App\Http\Controllers\SocietyLoginController;
use App\Http\Controllers\VaccinationSpotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("v1")->group(function () {
    Route::post('auth/login', [SocietyLoginController::class, "login"]);
    Route::post('auth/logout', [SocietyLoginController::class, "logout"]);

    Route::post('consultations', [ConsultationController::class, "store"]);
    Route::get('consultations', [ConsultationController::class, "get"]);

    Route::get('spots', [VaccinationSpotController::class, "index"]);
    Route::get('spots/{spot_id}', [VaccinationSpotController::class, "detail"]);

    Route::post('vaccinations', [RegisterVaccinationController::class, "store"]);
    Route::get('vaccinations', [RegisterVaccinationController::class, "get"]);
});
