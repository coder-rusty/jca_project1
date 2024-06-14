<?php

namespace App\Http\Controllers;
use App\Models\Contestant;
use App\Models\Event;
use App\Models\Gown;
use App\Models\Judge;
use App\Models\Preliminary;
use App\Models\Semi;
use App\Models\Swimwear;
use Illuminate\Http\Request;

class SemifinalCtrl extends Controller
{
    public function indexJudges(Request $request){
        $id = session('event_id');
        $accessCode = session('access_code');
    
        $contestants = Contestant::where('eventID', $id)->get();
    
        $mappedContestants = $contestants->map(function($con) {
            
            $preliminaryScores = Preliminary::where('contestantID', $con->id)
                ->select('poise', 'projection')
                ->get(); 
            
            $swimwearScores = Swimwear::where('contestantID', $con->id)
                ->select('suitability', 'projection')
                ->get(); 
    
            $gownScores = Gown::where('contestantID', $con->id)
                ->select('suitability', 'projection')
                ->get(); 
            
            $averagePreliminary = $preliminaryScores->avg(function($score) {
                return ($score->poise + $score->projection) / 2;
            });
    
            $averageSwimwear = $swimwearScores->avg(function($score) {
                return ($score->suitability + $score->projection) / 2;
            });
    
            $averageGown = $gownScores->avg(function($score) {
                return ($score->suitability + $score->projection) / 2;
            });
    
            $overallAverage = ($averagePreliminary + $averageSwimwear + $averageGown) / 3;
    
            $con->overallAverage = $overallAverage;
    
            return $con;
        });
    
        $topContestants = $mappedContestants->sortByDesc('overallAverage')->take(9);

        $contestantsWithRate = $topContestants->map(function($con) use ($accessCode) {
            $semiScores = Semi::where('contestantID', $con->id)
                              ->where('judgesCode', $accessCode)
                              ->select('beauty', 'poise', 'projection')
                              ->first();
    
            if ($semiScores) {
                $con->beauty = $semiScores->beauty;
                $con->poise = $semiScores->poise;
                $con->projection = $semiScores->projection;
            } else {
                $con->beauty = 0;
                $con->poise = 0;
                $con->projection = 0;
            }

            $total = ($con->beauty) + ($con->poise) + ($con->projection);
            $con->total = $total;
        
            return $con;
        });

        $contestantsWithRate = $contestantsWithRate->sortByDesc('total');

        $rank = 1;
        $prevTotal = null;
        $contestantsWithRate->transform(function($con) use (&$rank, &$prevTotal) {
            if ($prevTotal !== null && $con->total < $prevTotal) {
                $rank++;
            }
            $con->rank = $rank;
            $prevTotal = $con->total;
            return $con;
        });

        $ranks = $contestantsWithRate->map(function($con) {
            return $con->rank;
        })->unique();
        
        return view('jcaJudges.pages.final.semifinal', [
            'semiContestant' =>  $contestantsWithRate->sortBy('contestantNum'),
            'ranks' =>  $ranks->count()
        ]);
    }
    

    public function index(Request $request) {
        $eventId = $request->event;
    
        $event = Event::findOrFail($eventId);
        $judges = Judge::where('eventID', $eventId)
                       ->where('category', 'Final')
                       ->get();
    
        $semis = Semi::where('eventID', $eventId)->pluck('contestantID')->unique();
    
        $contestants = $semis->map(function($id) use ($judges) {
            $contestantDetails = Contestant::findOrFail($id);
            
            $totalScores = [];
    
            foreach ($judges as $judge) {
                $semisRate = Semi::where('contestantID', $id)
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
    
        return view('facilitator.singleEvent.ratings.final.semi', [
            'event' => $event,
            'contestants' => $sortedContestants->sortBy('contestantNum'),
            'judges' => $judges
        ]);
    }
    
    
    
}
