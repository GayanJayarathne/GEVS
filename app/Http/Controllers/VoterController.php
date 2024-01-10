<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VoterController extends Controller
{
    public function index(Request $request)
    {
        return view('voter.index');
    }
}
