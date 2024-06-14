<?php

namespace App\Http\Controllers;

use App\Models\Contestant;
use App\Models\Event;
use App\Models\Gown;
use App\Models\Preliminary;
use App\Models\Swimwear;
use Illuminate\Http\Request;

class RankingCtrl extends Controller
{
    public function index(Request $request) {
        $eventID = $request->event;
        $event = Event::find($eventID);
        $contestants = Contestant::where('eventID', $eventID)->get();

        $mappedContestants = $contestants->map(function($con) use ($eventID) {
            $preliminaryRate = Preliminary::where('contestantID', $con->id)->where('eventID', $eventID)->select('poise', 'projection')->get();
            $swimwearRate = Swimwear::where('contestantID', $con->id)->where('eventID', $eventID)->select('suitability', 'projection')->get();
            $gownRate = Gown::where('contestantID', $con->id)->where('eventID', $eventID)->select('suitability', 'projection')->get();

            $preliminary = 0;
            $swimwear = 0;
            $gown = 0;

            if($preliminaryRate->isNotEmpty()) {
                foreach ($preliminaryRate as $rate) {
                    $preliminary += $rate->poise + $rate->projection;
                }
            }

            if($swimwearRate->isNotEmpty()) {
                foreach ($swimwearRate as $rate) {
                    $swimwear += $rate->suitability + $rate->projection;
                }
            }

            if($gownRate->isNotEmpty()) {
                foreach ($gownRate as $rate) {
                    $gown += $rate->suitability + $rate->projection;
                }
            }


            $con->preliminary = $preliminary;
            $con->swimwear = $swimwear;
            $con->gown = $gown;

            return $con;
        });

        $mappedContestants = $mappedContestants->sortByDesc('preliminary');
        $preliminaryRank = 1;
        $mappedContestants->each(function ($con) use (&$preliminaryRank) {
            $con->preliminaryRank = $preliminaryRank;
            $preliminaryRank++;
        });

        $mappedContestantSwimwear = $mappedContestants->sortByDesc('swimwear');
        $swimwearRank = 1;
        $mappedContestantSwimwear->each(function ($con) use (&$swimwearRank) {
            $con->swimwearRank = $swimwearRank;
            $swimwearRank++;
        });

        $mappedContestantsGown = $mappedContestants->sortByDesc('gown');
        $gownRank = 1;
        $mappedContestantsGown->each(function ($con) use (&$gownRank) {
            $con->gownRank = $gownRank;
            $gownRank++;
        });

        $mappedContestants->map(function($con){
            $con->total = round((($con->preliminaryRank + $con->gownRank + $con->swimwearRank) / 3), 2);
        });


        $mappedContestantsTotal = $mappedContestants->sortBy('total');
$totalRank = 1;
$mappedContestantsTotal->each(function ($con) use (&$totalRank) {
    $con->totalRank = $totalRank;
    $totalRank++;
});




        return view('facilitator.singleEvent.ratings.ranking.index', [
            'event' => $event,
            'contestants' => $mappedContestants->sortBy('contestantNum')
        ]);
    }
    }


