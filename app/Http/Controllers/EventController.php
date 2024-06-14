<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Models\Contestant;
use App\Models\Judge;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function judgeIndex(Request $request) {

        $events = Event::all()->where('id', $request->event);
        $contestants = Contestant::all()->where('eventID', $request->event);
        $judges = Judge::all()->where('eventID', $request->event);
    }

    public function index() {
        $events = Event::all();

        if(!session('username')){
            return redirect(route('admin.login'));
        }else{
        return view('facilitator.dashboard.index',[
            'events' => $events->reverse()
        ]);
    }
     }
    public function store(Request $request) {

        $data = $request->validate([
            'title' => 'required',
            'preliminaryDate' => 'required',
            'preliminaryStartTime' => 'required',
            'finalDate' => 'required',
            'finalStartTime' => 'required',
            'location' => 'required',

        ]);

        $newData = Event::create($data);
        return redirect()->route('eventShow.show', [
            'event' => $newData->id
        ])->with('eventCreated', "Event created succesfully!");
     }

     public function destroy(Request $request, Event $event) {
        $event->delete();

        return redirect()->route('event.index')->with('eventDeleted', 'Event deleted succesfully!');

     }

     public function update(Request $request, Event $event) {

        $event = Event::findOrFail($request -> eventID);

        $event->title = $request->title;
        $event->location = $request->location;
        $event->preliminaryDate = $request->preliminaryDate;
        $event->preliminaryStartTime = $request->preliminaryStartTime;
        $event->finalDate = $request->finalDate;
        $event->finalStartTime = $request->finalStartTime;

        $event->save();

        return redirect()->route('event.index')->with('eventUpdated', 'Event updated succesfully!');

     }
     public function show(Request $request) {
        $events = Event::all()->where('id', $request->event);
        $contestants = Contestant::all()->where('eventID', $request->event);
        $preliminaryJudges = Judge::where([
            ['eventID', '=', $request->event],
            ['category', '=', 'Preliminary']
        ])->get();

        $finalJudges = Judge::where([
            ['eventID', '=', $request->event],
            ['category', '=', 'Final']
        ])->get();

        if(!session('username')){
            return redirect(route('admin.login'));
        }else{
            if($events->count() > 0){
                return view('facilitator.singleEvent.index', [
                    'event' => $events->first(),
                    'contestants' => $contestants,
                    'preliminaryJudges' => $preliminaryJudges,
                    'finalJudges' => $finalJudges
                ]);
            }else{
                return redirect(route('event.index'));
            }
        }
     }
}
