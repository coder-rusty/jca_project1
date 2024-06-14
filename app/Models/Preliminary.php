<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preliminary extends Model
{
    use HasFactory;

    protected $table = "priliminary_rate";

    protected $fillable = [
        "contestantID",
        "eventID",
        "judgesCode",
        "poise",
        "projection",
    ];

}
