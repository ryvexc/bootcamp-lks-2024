<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    use HasFactory;

    protected $table = "spots";
    protected $hidden = ["regional_id"];
    protected $with = [];

    public function junction()
    {
        return $this->hasMany(VaccinationSpot::class, "spot_id", "id");
    }

    public function vaccinations_count()
    {
        return $this->hasMany(Vaccination::class, 'spot_id');
    }

    public function regional()
    {
        return $this->hasMany(Regional::class, 'id');
    }

    public function spot_vaccine()
    {
        return $this->belongsTo(VaccinationSpot::class, 'id');
    }
}
