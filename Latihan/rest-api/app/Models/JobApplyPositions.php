<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplyPositions extends Model
{
    use HasFactory;

    protected $table = 'validators';
    protected $fillable = [
        'user_id',
        'role',
        'name'
    ];
}