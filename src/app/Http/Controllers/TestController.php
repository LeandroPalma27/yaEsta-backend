<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(Request $request)
    {
        return response()->json([
        'user_id' => $request->attributes->get(
            'auth_user_id'
        ),

        'session_uuid' => $request->attributes->get(
            'auth_session_uuid'
        ),
    ]);
    }
}
