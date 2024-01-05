<?php

namespace App\Models;

use App\Http\Controllers\UserController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = ["posisi", "nama", "nomor_punggung", "created_by_id", "modified_by_id"];
    protected $with = ["created_by", "modified_by"];
    protected $hidden = ["created_by_id", "modified_by_id"];

    public function created_by()
    {
        return $this->belongsTo(User::class, "created_by_id", "id");
    }

    public function modified_by()
    {
        return $this->belongsTo(User::class, "modified_by_id", "id");
    }
}
