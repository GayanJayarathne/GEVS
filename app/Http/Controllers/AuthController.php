<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\PersonController;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use App\Models\UVCCode;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Boolean;
use Validator;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        return view('user.login');
    }

    public function redirectToIndex()
    {
        return Redirect(route('Login'));
    }

    public function signup(Request $request)
    {
        $uvcCode = UVCCode::where('uvcCodeName',$request['uvc'])->first();

        $validate = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        if (!$validate) {
            return response()->json([
                'message' => $validate->errors(),
                'status' => 'validation-error'
            ], 401);
        }

        if (!$uvcCode) {
            return response()->json([
                'message' => 'Invalid UVC',
                'status' => 'validation-error'
            ], 401);
        }

        $user_uvc = User::where('uvc_code_id',$uvcCode->id)->first();

        if ($user_uvc) {
            return response()->json([
                'message' => 'UVC Already Registered',
                'status' => 'validation-error'
            ], 401);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'api_token' => Str::random(80),
            'date_of_birth' => $request->date_of_birth,
            'uvc_code_id' => $uvcCode->id,
            'constituency_id' => $request->constituency,
        ]);
        $user->save();

        $token = Str::random(80);

        $user->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        $credentials = request(['email', 'password']);

        if (!Auth::guard('users')->attempt($credentials))
            return response()->json([
                'message' => 'Invalid email or password',
                'status' => 'error'
            ], 401);

        return response()->json([
            'message' => $user->api_token,
            'status' => 'success'
        ], 201);
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

        if(!Auth::guard('users')->attempt($credentials))
            return response()->json([
                'message' => 'Invalid email or password',
                'status' => 'error'
            ], 401);
        $user = $request->user();
        $userEmail = $user->email;
        $is_admin = ($userEmail == 'election@shangrila.gov.sr');

        return response()->json([
            'message' => $user->api_token,
            'admin' => $is_admin,
            'status' => 'success'
        ], 201);
    }

    public function logout(Request $request)
    {
    }


    public function user(Request $request)
    {
        return response()->json([
            'message' => $request->user(),
            'status' => 'success'
        ]);
    }


////////////////////////////////////
///
//    public function index(Request $request)
//    {
//        return view('user.login');
//    }
//
//    public function redirectToIndex()
//    {
//        return Redirect(route('Login'));
//    }
//
//    public function signup(Request $request)
//    {
//        $validate = Validator::make($request->all(), [
//            'name' => 'required|string',
//            'email' => 'required|email|unique:users',
//            'password' => 'required|confirmed'
//        ]);
//
//        if ($validate->fails()) {
//            return response()->json([
//                'message' => $validate->errors(),
//                'status' => 'validation-error'
//            ], 401);
//        }
//
//        $person = Person::create([
//            'name' => $request->name,
//            'email' => $request->email,
//            'password' => bcrypt($request->password),
//            'api_token' => Str::random(80),
//        ]);
//        $person->save();
//
//        $apiToken = Str::random(80);
//
//        $person->forceFill([
//            'api_token' => hash('sha256', $apiToken),
//        ])->save();
//
//        $credentials = request(['email', 'password']);
//
//        if(!Auth::guard('people')->attempt($credentials))
//            return response()->json([
//                'message' => 'Invalid email or password',
//                'status' => 'error'
//            ], 401);
//
//        return response()->json([
//            'message' => $person->api_token,
//            'status' => 'success'
//        ], 201);
//    }
//
//
//
//    public function login(Request $request)
//    {
//        $validate = Validator::make($request->all(), [
//            'email' => 'required|email',
//            'password' => 'required'
//        ]);
//
//        if ($validate->fails()) {
//            return response()->json([
//                'message' => $validate->errors(),
//                'status' => 'validation-error'
//            ], 401);
//        }
//
//        $credentials = request(['email', 'password']);
//
//        if(!Auth::guard('people')->attempt($credentials))
//            return response()->json([
//                'message' => 'Invalid email or password',
//                'status' => 'error'
//            ], 401);
//        $person = $request->Person();
//
//        return response()->json([
//            'result' => $person,
//            'status' => 'success',
//            'message' => 'Success',
//        ], 201);
//    }
//
//
//    public function person(Request $request)
//    {
//        return response()->json([
//            'message' => $request->person(),
//            'status' => 'success'
//        ]);
//    }
}
