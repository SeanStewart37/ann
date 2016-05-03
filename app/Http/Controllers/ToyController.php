<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Toy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

/**
 * Class ToyController
 * @package App\Http\Controllers
 */
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
     * Update toy.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id){

        $rules = [
            'name' => 'required|string|min:2|max:255'
        ];

        $v = Validator::make($request->only('name'), $rules);

        if($v->passes()){

            $toy = Toy::findOrFail($id);

            $toy->name = $request->input('name', $toy->name);

            $toy->save();

            return response()->json(['status' => 'success', 'data' => ['toy' => $toy]]);

        } else return response()->json(['status' => 'fail', 'data' => $v->messages()], 400);
    }

    /**
     * Create new toy.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){

        $rules = [
            'name' => 'required|string|min:2|max:255',
        ];

        $v = Validator::make($request->only('name'), $rules);

        if($v->passes()){

            if(Toy::count() < 100){

                $toy = new Toy($request->only('name'));

                $toy->save();

                return response()->json(['status' => 'success', 'data' => ['toy' => $toy]], 200);

            } else return response()->json(['status' => 'error', 'message' => 'max number of toys created.'], 400);

        } else return response()->json(['status' => 'fail', 'data' => $v->messages()], 400);
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