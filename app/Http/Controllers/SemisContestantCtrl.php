<?php

namespace App\Http\Controllers;

use App\Models\SemisContestant;
use Illuminate\Http\Request;

class SemisContestantCtrl extends Controller
{
    public function store(Request $request){
        SemisContestant::create([
            'contestantID' =>  $request->id,
            'rank' => $request->rank,
            'eventID' => $request->event
        ]);

        return response()->json("GOODS");
    }
}
