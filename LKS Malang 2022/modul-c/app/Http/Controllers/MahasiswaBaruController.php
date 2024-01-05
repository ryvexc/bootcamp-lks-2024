<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Jurusan;
use App\Models\MahasiswaBaru;
use App\Models\Perguruan;
use App\Models\User;
use Illuminate\Http\Request;

class MahasiswaBaruController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa_baru = MahasiswaBaru::all();

        if ($request->search) {
            if ($request->search == "email") {
                $user = User::where("email", "like", "%" . $request->q . "%")->first();
                if ($user) $mahasiswa_baru = MahasiswaBaru::all()->where("user_id", $user->id)->all();
                else $mahasiswa_baru = [];
            } else if ($request->search == "jurusan") {
                $jurusan = Jurusan::where("name", "like", "%" . $request->q . "%")->first();
                if ($jurusan) $mahasiswa_baru = MahasiswaBaru::all()->where("jurusan_id", $jurusan->id)->all();
                else $mahasiswa_baru = [];
            } else {
                $mahasiswa_baru = MahasiswaBaru::where($request->search, "like", "%" . $request->q . "%")->get();
            }
        }

        return view("mahasiswa_baru", [
            "mahasiswa_baru" => $mahasiswa_baru,
            "defaults" => [
                "search" => $request->search,
                "q" => $request->q
            ]
        ]);
    }

    public function create()
    {
        $perguruan = Perguruan::all();
        $jurusan = Jurusan::where("status", 1)->get();
        $fakultas = Fakultas::where("status", 1)->get();

        return view('form_mahasiswa', [
            "perguruan" => $perguruan,
            "fakultas" => $fakultas,
            "jurusan" => $jurusan
        ]);
    }

    public function edit(Request $request)
    {
        $request->validate(["id" => "required", "status" => "required"]);

        MahasiswaBaru::find($request->id)->update([
            "status" => $request->status
        ]);

        return redirect()->back();
    }

    public function store(Request $request)
    {
        $request->validate([
            "email" => "required",
            "password" => "required",
            'perguruan'   => 'required',
            'fakultas'   => 'required',
            'jurusan'   => 'required',
        ]);

        $user = User::where("email", $request->email)->where("password", md5($request->password))->first();

        if ($user) {
            MahasiswaBaru::create([
                'nama' => $user->name,
                'perguruan_id' => $request->perguruan,
                'fakultas_id' => $request->fakultas,
                'jurusan_id' => $request->jurusan,
                'status' => 1,
                "user_id" => $user->id
            ]);

            return redirect("/");
        } else {
            return redirect()->back();
        }
    }

    public function external_daftar(Request $request)
    {
        $request->validate([
            "email" => "required",
            'perguruan'   => 'required',
            'fakultas'   => 'required',
            'jurusan'   => 'required',
        ]);

        $user = User::where("email", $request->email)->first();

        if ($user) {
            MahasiswaBaru::create([
                'nama' => $user->name,
                'perguruan_id' => $request->perguruan,
                'fakultas_id' => $request->fakultas,
                'jurusan_id' => $request->jurusan,
                'status' => 1,
                "user_id" => $user->id
            ]);

            return response()->json(["registered" => true]);
        } else {
            return response()->json(["registered" => false], 401);
        }
    }

    public function pendaftaran(Request $request)
    {
        $request->validate([
            "email" => "required"
        ]);

        $pendaftaran = MahasiswaBaru::all()->where("user_data.email", $request->email)->all();

        return response()->json([...$pendaftaran]);
    }
}
