<?php

namespace App\Http\Controllers;

use App\Models\Contestant;
use App\Models\Event;
use App\Models\FinalRate;
use App\Models\Judge;
use App\Models\Semi;
use Illuminate\Http\Request;

class FinalCtrl extends Controller
{
    public function indexJudges() {
        $eventId = session('event_id');
        $accessCode = session('access_code');
    
        if (!$eventId || !$accessCode) {
            return redirect()->back()->with('error', 'Event ID or Access Code is missing.');
        }
    
        $semis = Semi::where('eventID', $eventId)->pluck('contestantID')->unique();
    
        $contestants = $semis->map(function($contestantID) use ($eventId) {
            $contestantDetails = Contestant::findOrFail($contestantID);
        
            $semisRate = Semi::where('contestantID', $contestantID)
                             ->where('eventID', $eventId)
                             ->select('beauty', 'poise', 'projection')
                             ->get();
        
            if ($semisRate->isNotEmpty()) {
                $totalBeauty = $semisRate->sum('beauty') / 3;
                $totalPoise = $semisRate->sum('poise') / 3;
                $totalProjection = $semisRate->sum('projection') / 3;
                $contestantDetails->total = $totalBeauty + $totalPoise + $totalProjection;
            } else {
                $contestantDetails->total = 0;
            }
        
            return $contestantDetails;
        });
        
        $sortedContestants = $contestants->sortByDesc('total')->values();

        $top4Contestants = $sortedContestants->take(4)->map(function($con) use ($accessCode, $eventId) {
            $finalRate = FinalRate::where('judgesCode', $accessCode)
                                  ->where('contestantID', $con->id)
                                  ->where('eventID', $eventId)
                                  ->select('beauty', 'poise', 'projection')
                                  ->first();
        
            if ($finalRate) {
                $con->beauty = $finalRate->beauty;
                $con->poise = $finalRate->poise;
                $con->projection = $finalRate->projection;
                $con->total = round(($finalRate->beauty + $finalRate->poise + $finalRate->projection), 2);
            } else {
                $con->beauty = 0;
                $con->poise = 0;
                $con->projection = 0;
                $con->total = null;
            }
        
            return $con;
        });        
       
        $top4Contestants = $top4Contestants->sortByDesc('total')->values();

        $rank = 1;
        foreach ($top4Contestants as $con) {
           if($con->total){
            $con->rank = $rank++;
           }
        }

        $ranks = $top4Contestants->map(function($rank) {
            return $rank->rank;
        });
    
        return view('jcaJudges.pages.final.final', [
            'contestants' => $top4Contestants->sortBy('contestantNum'),
            'ranks' => $ranks->first()
        ]);
    }

    public function indexAdmin(Request $request){
        $eventId = $request->event;
    
        $event = Event::findOrFail($eventId);
        $judges = Judge::where('eventID', $eventId)
                       ->where('category', 'Final')
                       ->get();

        $finals = FinalRate::where('eventID', $eventId)->select('contestantID')->pluck('contestantID')->unique();

        $contestants = $finals->map(function($con) use ($judges) {
            $contestantDetails = Contestant::findOrFail($con);

            $totalScores = [];

            foreach ($judges as $judge) {
                $semisRate = FinalRate::where('contestantID', $con)
                                 ->where('judgesCode', $judge->accessCode)
                                 ->select('beauty', 'poise', 'projection')
                                 ->first();

                                 

                if ($semisRate) {
                    $totalScores[] = $semisRate->poise + $semisRate->beauty + $semisRate->projection;
                }
            }

            $contestantDetails->totalRate = $totalScores;
            $contestantDetails->total = count($totalScores) > 0 ? round(array_sum($totalScores) / count($totalScores), 2) : 0;

            return $contestantDetails;
        });

        $sortedContestants = $contestants->sortByDesc('total')->values();
    
            foreach ($sortedContestants as $index => $contestant) {
                $contestant->rank = $index + 1;
            }

           
        return view('facilitator.singleEvent.ratings.final.final', [
            'event' => $event,
            'contestants' => $contestants->sortBy('contestantNum'),
            'judgesFin' => $judges
        ]);
    }

    public function store(Request $request){
        
        FinalRate::create([
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
