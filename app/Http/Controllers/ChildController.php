<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Child;
use Illuminate\Support\Facades\Validator;

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

    /**
     * Update toy.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id){

        $rules = [
            'toy_id' => 'required|integer|exists:toys,id'
        ];

        $v = Validator::make($request->only('toy_id'), $rules);

        if($v->passes()){

            $child = Child::findOrFail($id);

            $child->toy_id = $request->input('toy_id', $child->toy_id);

            $child->save();

            return response()->json(['status' => 'success', 'data' => ['child' => $child]]);

        } else return response()->json(['status' => 'fail', 'data' => $v->messages()]);
    }
}