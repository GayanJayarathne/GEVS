<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Constituency;
use Illuminate\Http\Request;

class ConstituencyController extends Controller
{
    public function constituenciesDropdown(Request $request)
    {

        $constituency = Constituency::get();

        $obj = (object)array(
            'constituency' => $constituency
        );

        return response()->json([
            'result' => $obj,
            'message' => 'ok',
            'status' => 'success'
        ]);
    }
}
