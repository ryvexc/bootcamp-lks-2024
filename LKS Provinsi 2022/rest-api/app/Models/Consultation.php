<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $table = "consultations";
    protected $hidden = ["society_id", "doctor_id"];
    protected $with = ["doctor"];
    protected $fillable = ["society_id", "disease_history", "current_symptoms"];

    public $timestamps = false;

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, "doctor_id", "id");
    }
}
