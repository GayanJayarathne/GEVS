<?php

namespace App\Http\Controllers;

use Faker\Guesser\Name;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    public function partiesDropdown(Request $request)
    {

        $name = Name::get();

        $obj = (object)array(
            'name' => $name
        );

        return response()->json([
            'result' => $obj,
            'message' => 'ok',
            'status' => 'success'
        ]);
    }
}
