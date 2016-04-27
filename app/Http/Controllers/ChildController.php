<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Child;

class ChildController extends Controller
{
    /**
     * Display a listing of children with their favorite toy.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $gender = $request->input('gender',null);
        $age = $request->input('age', null);

        $query = Child::with('toy');

        if($gender) $query->where('gender',$gender);

        if($age) $query->where('age', $age);

        $children = $query->get();

        return response()->json(['status' => 'success', 'data' => ['children' => $children] ], 200);
    }
}