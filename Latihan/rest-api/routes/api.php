<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobVacanciesController;
use App\Http\Controllers\ValidationController;
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

Route::group(['prefix' => 'v1'], function () {
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/logout', [AuthController::class, 'logout']);

    Route::post('validation', [ValidationController::class, 'store']);
    Route::get('validations', [ValidationController::class, 'index']);

    Route::get('job_vacancies', [JobVacanciesController::class, 'index']);
    Route::get('job_vacancies/{id}', [JobVacanciesController::class, 'detail']);

    Route::post('applications', [ApplicationController::class, 'index']);
    Route::get('applications', [ApplicationController::class, 'show']);
});
