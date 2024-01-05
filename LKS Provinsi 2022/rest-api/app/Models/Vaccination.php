<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    use HasFactory;

    protected $table = "vaccinations";
    protected $fillable = ["spot_id", "society_id", "date"];
    protected $hidden = ["id", "doctor_id", "officer_id", "society_id", "spot_id", "vaccine_id"];
    protected $with = ["spot", "vaccine", "medicals"];

    public $timestamps = false;

    public function spot()
    {
        return $this->belongsTo(Spot::class, "spot_id", "id");
    }

    public function vaccine()
    {
        return $this->belongsTo(Vaccines::class, "vaccine_id", "id");
    }

    public function medicals()
    {
        return $this->belongsTo(Doctor::class, "doctor_id", "id");
    }
}
