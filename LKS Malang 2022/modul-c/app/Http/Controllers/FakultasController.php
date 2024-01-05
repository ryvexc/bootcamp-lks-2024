<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use Illuminate\Http\Request;

class FakultasController extends Controller
{
    public function index(Request $request)
    {
        $fakultas = Fakultas::with("jurusan")->where("deleted", 0)->get()->sortBy("status", SORT_REGULAR, true);

        return view('fakultas', [
            "fakultas" => $fakultas
        ]);
    }

    public function toggleStatus(Request $request)
    {
        $request->validate([
            "id" => "required",
            "status" => "required"
        ]);

        Fakultas::find($request->id)->update([
            "status" => !$request->status
        ]);

        return redirect()->back();
    }

    public function sampah()
    {
        $fakultas = Fakultas::all()->where("deleted", 1)->sortBy("status", SORT_REGULAR, true);

        return view('sampah/fakultas', [
            "fakultas" => $fakultas
        ]);
    }

    public function edit(Request $request)
    {
        $request->validate(["id" => "required", "name" => "required"]);

        Fakultas::find($request->id)->update([
            "name" => $request->name,
        ]);

        return redirect()->back();
    }

    public function restore(Request $request)
    {
        $request->validate([
            "id" => "required"
        ]);

        Fakultas::find($request->id)->update([
            "deleted" => 0
        ]);

        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $request->validate([
            "id" => "required"
        ]);

        Fakultas::find($request->id)->update([
            "deleted" => 1,
            "status" => 0
        ]);

        return redirect()->back();
    }

    public function tambah(Request $request)
    {
        $request->validate(["name" => "required"]);

        $fakultas = new Fakultas();
        $fakultas->name = $request->name;
        $fakultas->deleted = 0;
        $fakultas->status = 0;
        $fakultas->save();

        return redirect()->back();
    }
}
