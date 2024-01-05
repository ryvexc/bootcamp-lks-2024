<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakultasJunction extends Model
{
    use HasFactory;

    protected $fillable = ["fakultas_id", "perguruan_id"];

    protected $hidden = ["fakultas_id", "perguruan_id", "created_at", "updated_at", "id"];

    protected $with = ['fakultas', "jurusan"];

    public function perguruan()
    {
        return $this->belongsTo(Perguruan::class, "perguruan_id", "id");
    }

    public function jurusan()
    {
        return $this->hasMany(Jurusan::class, "fakultas_id", "fakultas_id")->where('status', 1)->where('deleted', 0);
    }

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, "fakultas_id", "id")->where('status', 1)->where("deleted", 0);
    }
}
