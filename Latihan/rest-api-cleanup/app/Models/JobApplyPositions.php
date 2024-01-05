<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplyPositions extends Model
{
    use HasFactory;

    protected $table = 'job_apply_positions';
    protected $fillable = [
        'user_id',
        'role',
        'name'
    ];
    protected $hidden = ["position_id"];

    public $timestamps = false;

    public function position()
    {
        return $this->hasMany(AvailablePositions::class, "id", "position_id");
    }
}
