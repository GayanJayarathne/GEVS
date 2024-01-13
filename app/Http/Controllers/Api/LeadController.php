<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Cluster;
use App\Models\Constituency;
use App\Models\Coordinator;
use App\Models\Department;
use App\Models\Lead;
use App\Models\Role;
use App\Models\TrainingDiaryCode;
use App\Models\TrainingDiaryStatus;
use App\Models\TrainingDiaryType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class LeadController extends Controller
{
    public function listData(Request $request)
    {
        $user = User::where('api_token',$request['api_token'])->first();

        $perPage = $request['per_page'];
        $sortBy = $request['sort_by'];
        $sortType = $request['sort_type'];


//        $leads = Lead::where('user_id', $user->id)->orderBy($sortBy, $sortType);
        $leads = Lead::orderBy($sortBy, $sortType);

        if ($request['query'] != '') {
            $leads->where('name', 'like', '%' . $request['query'] . '%');
        }

        return response()->json([
            'message' => $leads->paginate($perPage),
            'status' => 'success'
        ]);
    }

    public function create(Request $request)
    {
        $user = User::where('api_token',$request['api_token'])->first();

        $validate = Validator::make($request->all(), [
            'name'            => 'required|string',
            'party_id'        => 'numeric',
            'constituency_id' => 'numeric',
            'votes'           => 'numeric',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors(),
                'status' => 'validation-error'
            ], 401);
        }

        $newLead = Lead::create([
//            'user_id'          => $user->id,
            'name'             => $request['name'],
            'party_id'         => $request['party'],
            'constituency_id'  => $request['constituency'],
            'votes'            => $request['votes'],
        ]);

        if ($newLead) {
            return response()->json([
                'message' => 'Candidate successfully saved',
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'message' => 'Something went wrong',
                'status' => 'error'
            ]);
        }
    }

    public function update(Request $request)
    {
        $user = User::where('api_token',$request['api_token'])->first();

//        $lead = Lead::where('id',$request['lead_id'])
//                        ->where('user_id', $user->id)
//                        ->first();
        $lead = Lead::where('id',$request['id'])
                        ->first();

        if (empty($lead)) {
            return response()->json([
                'message' => 'Candidate Not Found',
                'status' => 'error'
            ]);
        }


        $validate = Validator::make($request->all(), [
            'name'            => 'required|string',
            'party_id'        => 'numeric',
            'constituency_id' => 'numeric',
            'votes'           => 'numeric',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors(),
                'status' => 'validation-error'
            ], 401);
        }

        $updateLead = $lead->update([
            'name'             => $request['name'],
            'party_id'         => $request['party'],
            'constituency_id'  => $request['constituency'],
            'votes'            => $request['votes'],
        ]);

        return response()->json([
            'message' => 'Candidate successfully updated',
            'status' => 'success'
        ]);
    }

    public function updateVotes(Request $request)
    {
        $lead = Lead::where('id',$request['id'])
            ->first();

        if (empty($lead)) {
            return response()->json([
                'message' => 'CandidateId Not Found',
                'status' => 'error'
            ]);
        }


//        $validate = Validator::make($request->all(), [
//            'name'            => 'required|string',
//            'votes'           => 'numeric'
//        ]);

//        if ($validate->fails()) {
//            return response()->json([
//                'message' => $validate->errors(),
//                'status' => 'validation-error'
//            ], 401);
//        }

        $updateVotes = $lead->updateVotes([
            'name'             => $lead->name,
            'votes'            => $lead->votes + 1,
        ]);

        return response()->json([
            'message' => 'Vote successfully updated',
            'status' => 'success'
        ]);
    }

    public function destroy(Request $request)
    {
        $user = User::where('api_token',$request['api_token'])->first();
        $lead = Lead::where('id',$request['lead_id'])
                        ->where('user_id', $user->id)
                        ->first();

        if (empty($lead)) {
            return response()->json([
                'message' => 'Candidate Not Found',
                'status' => 'error'
            ]);
        }

        $deleteLead = $lead->delete();

        if ($deleteLead) {
            return response()->json([
                'message' => 'Candidate successfully deleted',
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'message' => 'Something went wrong',
                'status' => 'error'
            ]);
        }
    }


    public function votesDropdown(Request $request)
    {
        $constituency1 = Lead::join('parties', 'leads.party_id', '=', 'parties.id')
            ->join('constituencies', 'leads.constituency_id', '=', 'constituencies.id')
            ->select('leads.name as candidate_name', 'parties.name as party_name', 'constituencies.name as constituency_name', 'leads.votes')
            ->where('leads.constituency_id', 1)
            ->orderBy('votes', 'desc')
            ->paginate($request['per_page']);

        $constituency2 = Lead::join('parties', 'leads.party_id', '=', 'parties.id')
            ->join('constituencies', 'leads.constituency_id', '=', 'constituencies.id')
            ->select('leads.name as candidate_name', 'parties.name as party_name', 'constituencies.name as constituency_name', 'leads.votes')
            ->where('leads.constituency_id', 2)
            ->orderBy('votes', 'desc')
            ->paginate($request['per_page']);

        $constituency3 = Lead::join('parties', 'leads.party_id', '=', 'parties.id')
            ->join('constituencies', 'leads.constituency_id', '=', 'constituencies.id')
            ->select('leads.name as candidate_name', 'parties.name as party_name', 'constituencies.name as constituency_name', 'leads.votes')
            ->where('leads.constituency_id', 3)
            ->orderBy('votes', 'desc')
            ->paginate($request['per_page']);

        $constituency4 = Lead::join('parties', 'leads.party_id', '=', 'parties.id')
            ->join('constituencies', 'leads.constituency_id', '=', 'constituencies.id')
            ->select('leads.name as candidate_name', 'parties.name as party_name', 'constituencies.name as constituency_name', 'leads.votes')
            ->where('leads.constituency_id', 4)
            ->orderBy('votes', 'desc')
            ->paginate($request['per_page']);

        $constituency5 = Lead::join('parties', 'leads.party_id', '=', 'parties.id')
            ->join('constituencies', 'leads.constituency_id', '=', 'constituencies.id')
            ->select('leads.name as candidate_name', 'parties.name as party_name', 'constituencies.name as constituency_name', 'leads.votes')
            ->where('leads.constituency_id', 5)
            ->orderBy('votes', 'desc')
            ->paginate($request['per_page']);

        $obj = (object) array(
            'constituency1' => $constituency1,
            'constituency2' => $constituency2,
            'constituency3' => $constituency3,
            'constituency4' => $constituency4,
            'constituency5' => $constituency5,

        );

        return response()->json([
            'result' => $obj,
            'message' => 'ok',
            'status' => 'success'
        ]);
    }

    public function listVotesConstituency(Request $request)
    {

        $constituency = Lead::join('parties', 'leads.party_id', '=', 'parties.id')
            ->join('constituencies', 'leads.constituency_id', '=', 'constituencies.id')
            ->select('leads.name as candidate_name', 'parties.name as party_name', 'constituencies.name as constituency_name', 'leads.votes')
            ->where('leads.constituency_id', $request['constituency_id'])
            ->orderBy('votes', 'desc')
            ->paginate($request['per_page']);

        return response()->json([
            'message' => $constituency,
            'status' => 'success'
        ]);
    }

    public function finalResults(Request $request)
    {

//        $result = Lead::join('parties', 'leads.party_id', '=', 'parties.id')
//            ->join('constituencies', 'leads.constituency_id', '=', 'constituencies.id')
//            ->where('leads.constituency_id', $request->input('constituency_id'))
//            ->orderByDesc('leads.votes')
//            ->get(['parties.name as party_name', 'leads.votes'])
//            ->paginate($request['per_page']);
//
//
//        return response()->json([
//            'result' => $result->toArray(),
//            'status' => 'success'
//        ]);

//        $rp = 0;
//        $bp = 0;
//        $yp = 0;
//        $ip = 0;
//
//        $results = [];
//
//        for ($constituencyId = 1; $constituencyId <= 5; $constituencyId++) {
//            $result = Lead::join('parties', 'leads.party_id', '=', 'parties.id')
//                ->join('constituencies', 'leads.constituency_id', '=', 'constituencies.id')
//                ->where('leads.constituency_id', $constituencyId)
//                ->orderByDesc('leads.votes')
//                ->get(['parties.name as party_name', 'leads.votes'])
//                ->toArray();
//
//            if ('parties.name as party_name' == 'Red Party'){
//                $rp += 1;
//            }elseif ('parties.name as party_name' == 'Blue Party'){
//                $bp += 1;
//            }elseif ('parties.name as party_name' == 'Yellow Party'){
//                $yp += 1;
//            }elseif ('parties.name as party_name' == 'Independent'){
//                $ip += 1;
//            }
//            $results->seat = $rp;
//            $results->seat = $bp;
//            $results->seat = $yp;
//            $results->seat = $ip;
//            $results = $result;
//        }
//
//        return response()->json([
//            'results' => $results,
//            'status' => 'success'
//        ]);

        $partySeats = [
            'Red Party' => 0,
            'Blue Party' => 0,
            'Yellow Party' => 0,
            'Independent' => 0,
        ];

        for ($constituencyId = 1; $constituencyId <= 5; $constituencyId++) {
            $result = Lead::join('parties', 'leads.party_id', '=', 'parties.id')
                ->join('constituencies', 'leads.constituency_id', '=', 'constituencies.id')
                ->where('leads.constituency_id', $constituencyId)
                ->orderByDesc('leads.votes')
                ->limit(1)
                ->get(['parties.name as party_name', 'leads.votes'])
                ->first();

            if ($result) {
                switch ($result->party_name) {
                    case 'Red Party':
                        $partySeats['Red Party'] += 1;
                        break;
                    case 'Blue Party':
                        $partySeats['Blue Party'] += 1;
                        break;
                    case 'Yellow Party':
                        $partySeats['Yellow Party'] += 1;
                        break;
                    case 'Independent':
                        $partySeats['Independent'] += 1;
                        break;
                }
            }
        }

        return response()->json([
            'party_seats' => $partySeats,
            'status' => 'success'
        ]);

    }
}
