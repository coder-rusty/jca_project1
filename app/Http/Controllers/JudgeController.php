<?php

namespace App\Http\Controllers;
use App\Models\Judge;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PhpParser\Node\Name;

class JudgeController extends Controller
{

    public function index(Request $request){
        $event = $request->event;
        $accessCode = $request->accessCode;
        $category = $request->category;
        $eventValue = substr($event, strpos($event, '=') + 1);
        $accessCodeValue = substr($accessCode, strpos($accessCode, '=') + 1);
        $categoryValue = substr($category, strpos($category, '=') + 1);

        return view('jcaJudges.index',[
            'accessCode' => $accessCodeValue,
            'event' => $eventValue,
            'category' => $categoryValue
        ]);
    }

    public function store(Request $request) {

        $data = Judge::create([
            'name' => $request->name,
            'judgeNum' => $request->judgeNum,
            'eventID'=> $request->eventID,
            'accessCode' => Str::random(5),
            'category' => $request->category
        ]);

        return redirect(route('eventShow.show', [
            'event' => $request->eventID
        ]));

     }

     public function destroy(Request $request){
        Judge::where('id', $request->judge)->delete();

        return redirect(route('eventShow.show', [
            'event' => $request->event
        ]));
     }

     public function update(Request $request)
     {

         $judge = Judge::findOrFail($request -> judge);


         $judge->name = $request->name;
         $judge->judgeNum = $request->judgeNum;
         $judge->accessCode = $request->accessCode;

         $judge->save();

         return redirect(route('eventShow.show', [
            'event' => $request->event
        ]));
     }



}
