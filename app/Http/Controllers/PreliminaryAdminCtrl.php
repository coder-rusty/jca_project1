<?php
namespace App\Http\Controllers;

use App\Models\Contestant;
use App\Models\Judge;
use App\Models\Event;
use App\Models\Preliminary;
use Illuminate\Http\Request;
use DB;

class PreliminaryAdminCtrl extends Controller
{
    public function index(Request $request)
{
    $eventId = $request->event;

    $event = Event::find($eventId);

    $contestants = Contestant::where('eventID', $eventId)->get();

    $mappedContestants = $contestants->map(function($con) {
    
        $contestantRates = Preliminary::where('contestantID', $con->id)
            ->select('poise', 'projection', 'judgesCode')
            ->get(); 
    
        $judgesCode = $contestantRates->unique('judgesCode')->pluck('judgesCode')->toArray();
    
        $con->judgesCode = $judgesCode;
    
        
        $total = round($contestantRates->average(function ($rate) {
            return $rate->poise + $rate->projection;
        }), 2);
    
        $con->total = $total;
    
        $con->ratings = $contestantRates;
    
        return $con;
    });
    
    $mappedContestants = $mappedContestants->sortByDesc('total');
    
    $rank = 1;
    $mappedContestants->each(function ($con) use (&$rank) {
        $con->rank = $rank;
        $rank++;
    });


    $judges = collect();

    if($mappedContestants->count() > 0){
        $judgesCode = $mappedContestants->first()->judgesCode;
    
    foreach ($judgesCode as $jud) {
        $judge = Judge::where([
            ['eventID', $eventId],
            ['category', 'Preliminary'],
            ['accessCode', $jud]
        ])->get();
    
        $judges = $judges->merge($judge);
    }
    }
    


    return view("facilitator.singleEvent.ratings.preliminary.index", [
        'event' => $event,
       'contestants' => $mappedContestants->sortBy('contestantNum'),
        'judges' => $judges
    ]);
}

}
