<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\FakultasJunction;
use App\Models\MahasiswaBaru;
use App\Models\Perguruan;
use Exception;
use Illuminate\Http\Request;

class PerguruanController extends Controller
{
    public function index(Request $request)
    {
        $perguruan = Perguruan::all();
        $fakultas = Fakultas::where("deleted", 0)->where("status", 1)->get();
        return view('perguruan_tinggi', [
            "perguruan" => $perguruan,
            "fakultas" => $fakultas,
        ]);
    }

    public function tambah(Request $request)
    {
        try {
            $request->validate([
                "name" => "required",
                "kategori" => "required",
                "akreditasi" => "required",
                "website" => "required",
                "alamat" => "required",
                "description" => "required",
                "telepon" => "required",
                "email" => "required",
                "whatsapp" => "required",
                "biaya" => "required"
            ]);

            $perguruan = new Perguruan();
            $perguruan->gambar = $request->link_gambar;
            $perguruan->nama = $request->name;
            $perguruan->kategori = $request->kategori;
            $perguruan->akreditasi = $request->akreditasi;
            $perguruan->website = $request->website;
            $perguruan->alamat = $request->alamat;
            $perguruan->description = $request->description;
            $perguruan->telepon = $request->telepon;
            $perguruan->email = $request->email;
            $perguruan->whatsapp = $request->whatsapp;
            $perguruan->biaya = $request->biaya;
            $perguruan->save();

            $fakultas = explode(",", $request->fakultas);

            foreach ($fakultas as $fak) {
                $fakultas_junction = new FakultasJunction();
                $fakultas_junction->fakultas_id = $fak;
                $fakultas_junction->perguruan_id = $perguruan->id;
                $fakultas_junction->save();
            }

            return redirect()->back();
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function edit(Request $request)
    {
        try {
            $request->validate([
                "id" => "required",
                "name" => "required",
                "kategori" => "required",
                "akreditasi" => "required",
                "website" => "required",
                "alamat" => "required",
                "description" => "required",
                "telepon" => "required",
                "email" => "required",
                "whatsapp" => "required",
                "biaya" => "required"
            ]);

            FakultasJunction::where("perguruan_id", $request->id)->delete();

            $fakultas = explode(",", $request->fakultas);

            foreach ($fakultas as $fak) {
                $fakultas_junction = new FakultasJunction();
                $fakultas_junction->fakultas_id = $fak;
                $fakultas_junction->perguruan_id = $request->id;
                $fakultas_junction->save();
            }

            Perguruan::find($request->id)->update([
                "gambar" => $request->link_gambar,
                "nama" => $request->name,
                "kategori" => $request->kategori,
                "akreditasi" => $request->akreditasi,
                "website" => $request->website,
                "alamat" => $request->alamat,
                "description" => $request->description,
                "telepon" => $request->telepon,
                "email" => $request->email,
                "whatsapp" => $request->whatsapp,
                "biaya" => $request->biaya
            ]);

            return redirect()->back();
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function delete(Request $request)
    {
        Perguruan::find($request->id)->delete();

        return redirect()->back();
    }
}
