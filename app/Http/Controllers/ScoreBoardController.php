<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Contestant;
use App\Models\Event;

class ScoreBoardController extends Controller
{
    public function index (){

        $name =  session('judge_name');
        $code = session('access_code');
        $id = session('event_id');

        $event = Event::all()->where('id', $id);
        $contestants = Contestant::where('eventID', $id)->orderBy('contestantNum', 'asc')->get();


        if($name && $code && $id){
            return view('jcaJudges.home.index', [
                'event' => $event->first(),
                'contestants' => $contestants
            ]);
        }else{
            return redirect(route('judge.logout'));
        }
    }

    public function preliminary(){
        $id = session('event_id');
        $contestants = Contestant::where('eventID', $id)->orderBy('contestantNum', 'asc')->get();

        return view('jcaJudges.pages.pre.index', [
            'contestants' => $contestants
        ]);
    }
}
