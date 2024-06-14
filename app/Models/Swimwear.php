<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Swimwear extends Model
{
    use HasFactory;

    protected $table = "swimwear";

    protected $fillable = [
        "contestantID",
        "eventID",
        "judgesCode",
        "suitability",
        "projection",
    ];

}
