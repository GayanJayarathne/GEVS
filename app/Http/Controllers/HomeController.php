<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Auth;
use Illuminate\Http\Request;
use Redirect;
use Faker\Provider\Lorem;

class HomeController extends Controller
{
//    public function index(Request $request)
//    {
//        return view('user.dashboard');
//    }

    public function index(Request $request)
    {
        $loggedUser=Auth::user();

        if($loggedUser->email==='election@shangrila.gov.sr'){ //1 is admin role
            return view('user.dashboard');
        }else{
            return redirect(route('voter.index'));
        }
    }



    public function logout(Request $request)
    {
        Auth::logout();
        return redirect(route('Login'));
    }
}
