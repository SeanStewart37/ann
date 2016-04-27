<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * Display the authorized user.
     *
     * @return JsonResponse
     */
    public function me()
    {
        return response()->json(['status' => 'success', 'data' => ['user' => Auth::user()]], 200);
    }
}
