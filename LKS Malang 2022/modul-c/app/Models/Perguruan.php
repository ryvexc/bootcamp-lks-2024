<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perguruan extends Model
{
    use HasFactory;

    protected $with = ["fakultas_junction"];

    protected $fillable = [
        "id",
        "name",
        "kategori",
        "akreditasi",
        "website",
        "alamat",
        "description",
        "telepon",
        "email",
        "whatsapp",
        "biaya"
    ];

    public function fakultas_junction()
    {
        return $this->hasMany(FakultasJunction::class, "perguruan_id", "id");
    }

    public function mahasiswa()
    {
        return $this->hasMany(MahasiswaBaru::class, 'perguruan_id');
    }
}
