<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Toy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ToyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $toys = Toy::get();

        return response()->json(['status' => 'success', 'data' => ['toys' => $toys]], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $toy = Toy::findOrFail($id);

        return response()->json(['status' => 'success', 'data' => ['toy' => $toy]], 200);
    }
}