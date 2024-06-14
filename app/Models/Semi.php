<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semi extends Model
{
    use HasFactory;
    protected $table = "semi";

    protected $fillable = [
        "contestantID",
        "eventID",
        "judgesCode",
        "beauty",
        "poise",
        "projection",
    ];
}
