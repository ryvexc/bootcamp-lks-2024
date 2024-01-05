<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Jurusan;
use App\Models\MahasiswaBaru;
use App\Models\Perguruan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $perguruan = Perguruan::all();
        $fakultas = Fakultas::all();
        $mahasiswa_baru = MahasiswaBaru::all();
        $jurusan = Jurusan::all();

        return view("dashboard", [
            "perguruan" => $perguruan,
            "fakultas" => $fakultas,
            "mahasiswa_baru" => $mahasiswa_baru,
            "jurusan" => $jurusan
        ]);
    }
}
