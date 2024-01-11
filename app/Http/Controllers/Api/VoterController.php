<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;

class VoterController extends Controller
{
    public function index(Request $request)
    {
        return view('voter.index');
    }

    public function getDataByConstituency(Request $request)
    {
        $user = User::where('api_token',$request['api_token'])->first();

        $perPage = $request['per_page'];


        $leads = Lead::where('constituency_id', $user->constituency_id)->orderBy('name', 'asc');
//        $leads = Lead::orderBy($sortBy, $sortType);

        if ($request['query'] != '') {
            $leads->where('name', 'like', '%' . $request['query'] . '%');
        }

        return response()->json([
            'message' => $leads->paginate($perPage),
            'status' => 'success'
        ]);
    }

//    public function __construct() {
//        $this->middleware('auth');
//    }
////    public function index() {
////        return view('voter.dashboard');
////    }
//
//    public function store(Request $request) {
//        if(isset($request['apply']))
//        {
//            $Nominee = new PositionUser();
//            $Nominee->user_id = Auth::user()->id;
//            $Nominee->position_id = $request['position_id'];
//            // by default when voter apply for any position, its unapproved, until admin approves him/her
//            $Nominee->Status = 0;
//            $Nominee->votes = 0;
//        }
//        $user = User::findOrFail(Auth::user()->id);
//        if($user->role == "voter"){
//            $user->role = "candidate";
//            $user->save();
//        }
//        $Nominee->save();
//        $message = "Successfully applied as candidate";
//        return redirect()->route('candidate.dashboard')->with('success',"Successfully applied as Candidate");
//        //    return view('candidate.dashboard',compact('message'));
//    }
//
//    public function apply() {
//        $positions = Position::all();
//        $departments = Department::all();
//        return view('voter.apply',compact('departments','positions'));
//    }
}
