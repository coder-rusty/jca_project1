<?php

namespace App\Http\Controllers;

use App\Models\Semi;
use Illuminate\Http\Request;

class SemJudgeCtrl extends Controller
{
    public function store(Request $request){

        Semi::create([
             'contestantID' =>  $request->contestantID, 
             'judgesCode' => session('access_code'),
             'eventID' => session('event_id'),
             'beauty' =>  $request->beauty,
             'poise' =>  $request->poise,
             'projection' =>  $request->projection,
         ]);
 
         return response()->json("GOODS");
 
     }
}
