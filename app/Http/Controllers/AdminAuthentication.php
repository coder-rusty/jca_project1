<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use App\Models\Administrator;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class AdminAuthentication extends Controller
{
    public function login(Request $request)
    {
        // $hashed = Hash::make('password', [
        //     'rounds' => 12,
        // ]);

        // Administrator::create([
        //     'username' => 'user',
        //     'password' => 'userPass'
        // // ]);

        $administrator = Administrator::where('username', $request->username)->where('password', $request->password);



        if (!$administrator) {
            $error = "Invalid username";
            return view('facilitator.authentication.login', compact('error'));
        } else {
            Session::put('username', $request->username);
            return redirect()->route('event.index')->with('loggedIn', 'Hello '.$request->username. '! You are signed in as admin.');
            // if (Hash::check($request->password, $administrator->first()->password)) {
            //     Session::put('username', $request->username);
            //     return redirect()->route('event.index')->with('loggedIn', 'Hello '.$request->username. '! You are signed in as admin.');
            // }else{
            //     $error = "Incorrect password";
            //     return view('facilitator.authentication.login', compact('error'));
            // }
        }
    }

    public function logout(){
        Session::flush();
        return redirect(route('admin.login'));
    }
}
