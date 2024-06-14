<?php

namespace App\Http\Controllers;
use App\Models\Preliminary;
use App\Models\Swimwear;
use Illuminate\Http\Request;
use App\Models\Contestant;
use DB;

class SwimwearCtrl extends Controller
{
    public function index(){
        $id = session('event_id');
        $accessCode = session('access_code');

    $contestants = Contestant::where('eventID', $id)->orderBy('contestantNum', 'asc')->get();

    $mappedContestants = $contestants->map(function($con) use($accessCode) {
        $preliminaryRate = Swimwear::where('contestantID', $con->id)
        ->where('judgesCode', $accessCode)
        ->select('suitability', 'projection')
        ->first();

        if ($preliminaryRate) {
            $con->suitability = $preliminaryRate->suitability;
            $con->projection = $preliminaryRate->projection;
        } else {
            $con->suitability = null;
            $con->projection = null;
        }

        return $con;
    });

    $checkRecord =  $mappedContestants->filter(function($con){
        return $con == null;
    });

    return view('jcaJudges.pages.pre.swimwear', [
       'contestants' => $mappedContestants->sortBy('contestantNum'),
        'isRecorded' => $contestants->count() > 0 ? $checkRecord->count() < 1:false
    ]);
    }

    public function store(Request $request){

        Swimwear::create([
             'contestantID' =>  $request->contestantID, 
             'suitability' => $request->suitability,
             'projection' => $request->projection,
             'judgesCode' => session('access_code'),
             'eventID' => session('event_id'),
         ]);
 
         return response()->json("GOODS");
 
     }
}
