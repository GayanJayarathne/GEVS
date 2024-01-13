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

    public function getByDate(Request $request)
    {
//        $user = User::where('api_token', $request['api_token'])->first();

        $votingDate = VotingStart::Where('date', $request['date'])->first();

        return response()->json([
            'message' => $votingDate,
            'status' => 'success'
        ]);
    }
}
