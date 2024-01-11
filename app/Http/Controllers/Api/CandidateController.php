<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function listData(Request $request)
    {
        $user = User::where('api_token',$request['api_token'])->first();

        $perPage = $request['per_page'];
        $sortBy = $request['sort_by'];
        $sortType = $request['sort_type'];


        $candidates = Candidate::where('user_id', $user->id)->orderBy($sortBy, $sortType);

        if ($request['query'] != '') {
            $candidates->where('name', 'like', '%' . $request['query'] . '%');
        }

        return response()->json([
            'message' => $candidates->paginate($perPage),
            'status' => 'success'
        ]);
    }

    public function create(Request $request)
    {
        $user = User::where('api_token',$request['api_token'])->first();

        $validate = Validator::make($request->all(), [
            'name'        => 'required|string',
            'email'       => 'required|email|unique:leads,email',
            'phone'       => 'required|unique:leads,phone',
            'address'     => '',
            'description' => '',
            'progress'    => 'numeric',
            'status'      => 'numeric',
            'earnings'    => 'numeric',
            'expenses'    => 'numeric',
            'net'         => 'numeric',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors(),
                'status' => 'validation-error'
            ], 401);
        }

        $newCandidate = Candidate::create([
            'user_id'     => $user->id,
            'name'        => $request['name'],
            'email'       => $request['email'],
            'phone'       => $request['phone'],
            'address'     => $request['address'],
            'description' => $request['description'],
            'progress'    => $request['progress'],
            'status'      => $request['status'],
            'earnings'    => $request['earnings'],
            'expenses'    => $request['expenses'],
            'net'         => $request['net'],
        ]);

        if ($newCandidate) {
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

        $lead = Candidate::where('id',$request['candidate_id'])
            ->where('user_id', $user->id)
            ->first();

        if (empty($lead)) {
            return response()->json([
                'message' => 'Lead Not Found',
                'status' => 'error'
            ]);
        }


        $validate = Validator::make($request->all(), [
            'name'        => 'required|string',
            'email'       => 'required|email|unique:leads,email,'.$lead->id.',id',
            'phone'       => 'required|unique:leads,phone,'.$lead->id.',id',
            'address'     => '',
            'description' => '',
            'progress'    => 'numeric',
            'status'      => 'numeric',
            'earnings'    => 'numeric',
            'expenses'    => 'numeric',
            'net'         => 'numeric',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors(),
                'status' => 'validation-error'
            ], 401);
        }

        $updateLead = $lead->update([
            'name'        => $request['name'],
            'email'       => $request['email'],
            'phone'       => $request['phone'],
            'address'     => $request['address'],
            'description' => $request['description'],
            'progress'    => $request['progress'],
            'status'      => $request['status'],
            'earnings'    => $request['earnings'],
            'expenses'    => $request['expenses'],
            'net'         => $request['net'],
        ]);

        return response()->json([
            'message' => 'Lead successfully updated',
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
