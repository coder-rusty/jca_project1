<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gown extends Model
{
    use HasFactory;

    protected $table = "gown";

    protected $fillable = [
        "contestantID",
        "eventID",
        "judgesCode",
        "suitability",
        "projection",
    ];
}
