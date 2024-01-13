<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VotingStart;
use Illuminate\Http\Request;

class VotingStartController extends Controller
{
    public function listData(Request $request)
    {

        $voting_start = VotingStart::get();

        return response()->json([
            'message' => $voting_start,
            'status' => 'success'
        ]);
    }


    public function create(Request $request)
    {
//        $user = User::where('api_token',$request['api_token'])->first();

//        $validate = Validator::make($request->all(), [
//            'date'        => 'required|date',
//            'start_time'  => 'time',
//            'end_time'    => 'time'
//        ]);

//        if ($validate->fails()) {
//            return response()->json([
//                'message' => $validate->errors(),
//                'status' => 'validation-error'
//            ], 401);
//        }

        $newVotingStart = VotingStart::create([
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
