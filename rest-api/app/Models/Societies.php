<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Societies extends Model
{
    use HasFactory;

    protected $table = 'societies';
    protected $fillable = ['id_card_number', 'password', 'name', 'born_date', 'gender', 'address', 'regional_id', 'login_tokens'];
}
