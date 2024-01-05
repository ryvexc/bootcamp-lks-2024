<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Society extends Model
{
    use HasFactory;

    protected $table = "societies";
    protected $fillable = ["login_tokens"];
    protected $hidden = ["regional_id", "id_card_number", "id", "password", "login_tokens"];
    protected $with = ["regional"];

    public $timestamps = false;

    public function regional()
    {
        return $this->belongsTo(Regional::class, "regional_id", "id");
    }
}
