<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.login');
    }



    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors(),
                'status' => 'validation-error'
            ], 401);
        }

        $credentials = request(['email', 'password']);

        if(!Auth::guard('person')->attempt($credentials))
            return response()->json([
                'message' => 'Invalid email or password',
                'status' => 'error'
            ], 401);
        $person = $request->Person();

        return response()->json([
            'result' => $person,
            'status' => 'success',
            'message' => 'Success',
        ], 201);
    }


    public function person(Request $request)
    {
        return response()->json([
            'message' => $request->person(),
            'status' => 'success'
        ]);
    }
}
