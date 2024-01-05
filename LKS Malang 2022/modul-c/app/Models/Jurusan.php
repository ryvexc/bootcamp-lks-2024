<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = "jurusans";

    protected $fillable = [
        "status",
        "deleted",
        "name",
        "fakultas_id"
    ];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, "fakultas_id", "id");
    }
}
