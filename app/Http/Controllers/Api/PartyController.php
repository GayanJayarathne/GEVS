<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\party;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    public function partiesDropdown(Request $request)
    {

        $party = party::get();

        $obj = (object)array(
            'party' => $party
        );

        return response()->json([
            'result' => $obj,
            'message' => 'ok',
            'status' => 'success'
        ]);
    }
}
