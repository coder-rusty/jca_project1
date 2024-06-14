<?php

namespace App\Http\Controllers;
use App\Models\Preliminary;
use Illuminate\Http\Request;

class preliminaryCtrl extends Controller
{
    public function store(Request $request){
        return response()->json("GOODS");

    }

}
