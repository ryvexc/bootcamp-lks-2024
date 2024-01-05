<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaBaru extends Model
{
    use HasFactory;

    protected $table = "mahasiswa_baru";

    protected $fillable = [
        'nama',
        'perguruan_id',
        'fakultas_id',
        'jurusan_id',
        'status',
        "user_id"
    ];

    protected $with = ["perguruan", "fakultas", "jurusan", "user_data"];

    public function perguruan()
    {
        return $this->belongsTo(Perguruan::class, "perguruan_id", "id");
    }

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, "fakultas_id", "id");
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, "jurusan_id", "id");
    }

    public function user_data()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
