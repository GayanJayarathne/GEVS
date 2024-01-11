<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
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
                'message' => 'Lead successfully saved',
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
        $lead = Lead::where('id')
                        ->first();

        if (empty($lead)) {
            return response()->json([
                'message' => 'Lead Not Found',
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
            'message' => 'Lead successfully updated',
            'status' => 'success'
        ]);
    }

    public function updateVotes(Request $request)
    {
        $lead = Lead::where('id')
            ->first();

        if (empty($lead)) {
            return response()->json([
                'message' => 'UserId Not Found',
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

        $updateLead = $lead->updateVotes([
            'name'             => $request['name'],
            'party_id'         => $request['party'],
            'constituency_id'  => $request['constituency'],
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
                'message' => 'Lead Not Found',
                'status' => 'error'
            ]);
        }

        $deleteLead = $lead->delete();

        if ($deleteLead) {
            return response()->json([
                'message' => 'Lead successfully deleted',
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
