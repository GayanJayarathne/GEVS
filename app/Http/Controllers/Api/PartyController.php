<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Faker\Guesser\Name;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    public function partiesDropdown(Request $request)
    {

        $party = Party::get();

        $obj = (object)array(
            'name' => $party
        );

        return response()->json([
            'result' => $obj,
            'message' => 'ok',
            'status' => 'success'
        ]);
    }
}
