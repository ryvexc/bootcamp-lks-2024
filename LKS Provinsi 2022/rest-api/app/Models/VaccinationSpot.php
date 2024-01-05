<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccinationSpot extends Model
{
    use HasFactory;

    protected $table = "spot_vaccines";
    protected $hidden = ["id", "spot_id", "vaccine_id"];
    protected $with = ["vaccine"];

    public function vaccine()
    {
        return $this->belongsTo(Vaccines::class, "vaccine_id", "id");
    }
}
