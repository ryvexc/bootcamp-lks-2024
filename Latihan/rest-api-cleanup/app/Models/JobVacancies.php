<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobVacancies extends Model
{
    use HasFactory;

    protected $hidden = ["job_category_id"];
    protected $with = ["category", "available_position"];

    public function category()
    {
        return $this->belongsTo(JobCategories::class, "job_category_id", "id");
    }

    public function available_position()
    {
        return $this->hasMany(AvailablePositions::class, "job_vacancy_id", "id");
    }
}
