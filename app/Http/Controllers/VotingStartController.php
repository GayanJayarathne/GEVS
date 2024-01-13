<?php

namespace App\Http\Controllers;

use App\Models\Constituency;
use App\Models\Lead;
use App\Models\User;
use App\Models\VotingStart;
use Illuminate\Http\Request;

class VotingStartController extends Controller
{
    public function listData(Request $request)
    {
//        $user = User::where('api_token',$request['api_token'])->first();

        $voting_start = VotingStart::get();

//        if ($request['query'] != '') {
//            $voting_start->where('name', 'like', '%' . $request['query'] . '%');
//        }

        return response()->json([
            'message' => $voting_start,
            'status' => 'success'
        ]);


//        $constituency = Constituency::get();
//
//        $obj = (object)array(
//            'constituency' => $constituency
//        );
//
//        return response()->json([
//            'result' => $obj,
//            'message' => 'ok',
//            'status' => 'success'
//        ]);
    }


    public function create(Request $request)
    {
        $user = User::where('api_token',$request['api_token'])->first();

        $validate = Validator::make($request->all(), [
            'date'        => 'required|date',
            'start_time'  => 'time',
            'end_time'    => 'time'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors(),
                'status' => 'validation-error'
            ], 401);
        }

        $newVotingStart = Lead::create([
            'date'        => $request['date'],
            'start_time'  => $request['start_time'],
            'end_time'    => $request['end_time']
        ]);

        if ($newVotingStart) {
            return response()->json([
                'message' => 'Voting Start successfully saved',
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'message' => 'Something went wrong',
                'status' => 'error'
            ]);
        }
    }
}
