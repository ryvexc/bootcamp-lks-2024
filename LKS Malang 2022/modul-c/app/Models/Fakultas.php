<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;

    protected $table = "fakultas";

    protected $fillable = [
        "status",
        "name",
        "deleted"
    ];

    public function jurusan()
    {
        return $this->hasMany(Jurusan::class, "fakultas_id", "id")->where("deleted", 0)->where("status", 1);
    }

    public function jurusan_unfilter()
    {
        return $this->hasMany(Jurusan::class, "fakultas_id", "id");
    }
}
