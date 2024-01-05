<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validations extends Model
{
    use HasFactory;

    protected $table = 'validations';
    protected $fillable = [
        'job_category_id',
        'society_id',
        'validator_id',
        'status',
        'work_experience',
        'job_position',
        'reason_accepted',
        'validator_notes'
    ];

    protected $hidden = ["job_category_id", "validator_id"];
    protected $with = ["validator"];

    public $timestamps = false;

    public function job_category()
    {
        return $this->belongsTo(JobCategories::class);
    }

    public function category()
    {
        return $this->belongsTo(JobCategories::class, "job_category_id");
    }

    public function validator()
    {
        return $this->belongsTo(Validators::class);
    }
}
