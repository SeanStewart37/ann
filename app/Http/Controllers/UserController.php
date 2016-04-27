<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

class UserController extends Controller
{
    /**
     * Display the authorized user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function me()
    {
        return response()->json(['status' => 'success', 'data' => ['user' => Auth::user()]], 200);
    }
}
