<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Contestant;
use App\Models\Judge;
use Illuminate\Http\Request;

class ContestantController extends Controller
{
    public function index(Request $request){

        $events = Event::all()->where('id', $request->event);
        $contestants = Contestant::all()->where('eventID', $request->event);
        $judges = Judge::all()->where('eventID', $request->event);

        if(!session('username')){
            return redirect(route('admin.login'));
        }else{
            if($events->count() > 0) {
                return view('facilitator.singleEvent.contestants.index', [
                    'event' => $events->first(),
                    'contestants' => $contestants,
                    'judges' => $judges
                ]);
            }else{
                return redirect(route('event.index'));
            }
        }
    }

    public function addNew(Request $request){
        $events = Event::all()->where('id', $request->event);

        return view("facilitator.singleEvent.contestants.addContestant", [
            'event' => $events->first(),
        ]);
    }

    public function store(Request $request) {

        $file= $request->file('photo');
        $filename = date('YmdHi').$file->getClientOriginalName();
        $file-> move(public_path('public/Image'), $filename);

        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'contestantNum' => 'required',
            'age' => 'required',
            'chest' => 'required',
            'waist' => 'required',
            'height' => 'required',
            'weight' => 'required',
            'eventID' => 'required',
            'hips' => 'required'
        ]);

        $newData = Contestant::create([
            'name' => $validatedData['name'],
            'photo' => $filename,
            'contestantNum' => $validatedData['contestantNum'],
            'eventID' => $validatedData['eventID'],
            'address' => $validatedData['address'],
            'age' => $validatedData['age'],
            'chest' => $validatedData['chest'],
            'waist' => $validatedData['waist'],
            'height' => $validatedData['height'],
            'weight' => $validatedData['weight'],
            'hips' => $validatedData['hips'],
        ]);

        return redirect(route('contestant.index', [
            'event' => $validatedData['eventID']
        ]));
    }

    public function update(Request $request) {

        $contestant = Contestant::findOrFail($request -> contestantID);

        $file= $request->file('photo');
        $filename = date('YmdHi').$file->getClientOriginalName();
        $file-> move(public_path('public/Image'), $filename);

        $contestant->chest = $request->chest;
        $contestant->chest = $request->chest;
        $contestant->waist = $request->waist;
        $contestant->height = $request->height;
        $contestant->weight = $request->weight;
        $contestant->hips = $request->hips;
        $contestant->name = $request->name;
        $contestant->photo = $filename;
        $contestant->contestantNum = $request->contestantNum;
        $contestant->eventID = $request->eventID;
        $contestant->address = $request->address;

        $contestant->save();

        return redirect(route('contestant.index', [
            'event' => $request->eventID
        ]));

    }

    public function destroy(Request $request){

        Contestant::where('id', $request->contestant)->delete();

        return redirect(route('contestant.index', [
            'event' => $request->event
        ]));
     }
}
