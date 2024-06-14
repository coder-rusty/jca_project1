<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use App\Models\Judge;
use Illuminate\Http\Request;

class JudgesAuth extends Controller
{
    public function login(Request $request){
        $judge = Judge::all()->where('accessCode', $request->accessCode);


        if($judge->count() > 0){
            Session::put('access_code', $judge->first()->accessCode);
            Session::put('judge_name', $judge->first()->name);
            Session::put('event_id', $request->event);

            if($request->category == "Preliminary"){
                return redirect(route('preliminary.index')); //PRELIMINARY PAGE
            }else{
               
                return redirect(route('final.index')); //To do:: FINAL PAGE
            }

        }else{
            dd("NO");
        }
    }

    public function logout()
    {
        Session::flush();

        return view('jcajudges.home.logout')->with('out',  'Thank you for taking time!');
    }
}
