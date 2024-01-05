<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index(Request $request)
    {
        $jurusan = Jurusan::all()->where("deleted", 0)->sortBy("status", SORT_REGULAR, true);
        $fakultas = Fakultas::all();

        return view('jurusan', [
            "jurusan" => $jurusan,
            "fakultas" => $fakultas
        ]);
    }

    public function toggleStatus(Request $request)
    {
        $request->validate([
            "id" => "required",
            "status" => "required"
        ]);

        Jurusan::find($request->id)->update([
            "status" => !$request->status
        ]);

        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $request->validate([
            "id" => "required"
        ]);

        Jurusan::find($request->id)->update([
            "deleted" => 1,
            "status" => 0
        ]);

        return redirect()->back();
    }

    public function restore(Request $request)
    {
        $request->validate([
            "id" => "required"
        ]);

        Jurusan::find($request->id)->update([
            "deleted" => 0
        ]);

        return redirect()->back();
    }

    public function sampah()
    {
        $jurusan = Jurusan::all()->where("deleted", 1)->sortBy("status", SORT_REGULAR, true);

        return view('sampah/jurusan', [
            "jurusan" => $jurusan
        ]);
    }

    public function edit(Request $request)
    {
        $request->validate(["id" => "required", "name" => "required", "fakultas_id" => "required"]);

        Jurusan::find($request->id)->update([
            "name" => $request->name,
            "fakultas_id" => $request->fakultas_id,
        ]);

        return redirect()->back();
    }

    public function tambah(Request $request)
    {
        $request->validate(["name" => "required", "fakultas_id" => "required"]);

        $jurusan = new Jurusan();
        $jurusan->name = $request->name;
        $jurusan->fakultas_id = $request->fakultas_id;
        $jurusan->deleted = 0;
        $jurusan->status = 0;
        $jurusan->save();

        return redirect()->back();
    }
}
