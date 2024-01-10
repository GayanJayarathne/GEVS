<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommissionerController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.dashboard');
    }
}
