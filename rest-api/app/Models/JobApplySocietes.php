<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplySocietes extends Model
{
    use HasFactory;

    protected $table = 'job_apply_societes';
    protected $fillable = [
        'notes',
        'date',
        'society_id',
        'job_vacancy_id'
    ];
}
