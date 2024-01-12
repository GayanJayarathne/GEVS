<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ResultsController extends Controller
{
    public function index(Request $request)
    {
        return view('user.lead.index');
    }
}
