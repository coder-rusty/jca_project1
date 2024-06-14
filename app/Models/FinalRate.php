<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalRate extends Model
{
    use HasFactory;
    protected $table = "final";

    protected $fillable = [
        "contestantID",
        "eventID",
        "judgesCode",
        "beauty",
        "poise",
        "projection",
    ];
}
