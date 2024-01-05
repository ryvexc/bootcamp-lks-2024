<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FakultasApiController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\MahasiswaBaruController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PerguruanApiController;
use App\Http\Controllers\PerguruanController;
use App\Models\Fakultas;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/", function () {
    return view("auth");
});

Route::get("/register", function () {
    return view("register");
});
Route::post("/register/save", [AuthController::class, 'register'])->name('signup');

Route::get('/form', [MahasiswaBaruController::class, 'create'])->name('form.show');
Route::post('/form/save', [MahasiswaBaruController::class, 'store'])->name('form.store');

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/member', [MemberController::class, 'index']);
Route::get('/member/toggle', [MemberController::class, 'toggleStatus']);

Route::prefix("/mahasiswa_baru")->group(function () {
    Route::get('/', [MahasiswaBaruController::class, 'index']);
});

Route::prefix("/perguruan_tinggi")->group(function () {
    Route::get('/', [PerguruanController::class, 'index']);
    Route::get('/delete', [PerguruanController::class, 'delete']);
});

Route::prefix("/fakultas")->group(function () {
    Route::get('/', [FakultasController::class, 'index']);
    Route::get('/toggle', [FakultasController::class, 'toggleStatus']);
    Route::get('/delete', [FakultasController::class, 'delete']);
    Route::get('/restore', [FakultasController::class, 'restore']);
});

Route::prefix("/jurusan")->group(function () {
    Route::get('/', [JurusanController::class, 'index']);
    Route::get('/toggle', [JurusanController::class, 'toggleStatus']);
    Route::get('/delete', [JurusanController::class, 'delete']);
    Route::get('/restore', [JurusanController::class, 'restore']);
});

Route::prefix("/sampah")->group(function () {
    Route::get("/fakultas", [FakultasController::class, 'sampah']);
    Route::get("/jurusan", [JurusanController::class, 'sampah']);
});

Route::prefix("api/v1")->group(function () {
    Route::post("external/auth", [AuthController::class, 'external_login']);
    Route::post("external/register", [AuthController::class, 'external_register']);
    Route::post("external/daftar", [MahasiswaBaruController::class, 'external_daftar']);

    Route::post('auth/login', [AuthController::class, 'login']);
    Route::get('auth/logout', [AuthController::class, 'logout']);

    Route::post('jurusan/edit', [JurusanController::class, 'edit']);
    Route::post('jurusan/tambah', [JurusanController::class, 'tambah']);

    Route::post('fakultas/edit', [FakultasController::class, 'edit']);
    Route::post('fakultas/tambah', [FakultasController::class, 'tambah']);

    Route::post('mahasiswa_baru/edit', [MahasiswaBaruController::class, 'edit']);

    Route::get('perguruan', [PerguruanApiController::class, 'index']);
    Route::post('perguruan/edit', [PerguruanController::class, 'edit']);
    Route::post('perguruan/tambah', [PerguruanController::class, 'tambah']);
    Route::get('perguruan/detail', [PerguruanApiController::class, 'detail']);

    Route::get('fakultas', [FakultasApiController::class, 'index']);
    Route::get("pendaftaran", [MahasiswaBaruController::class, 'pendaftaran']);
});
