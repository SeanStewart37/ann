<?php

namespace App\Http\Controllers;

use App\Toy;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Services\ANN;
use App\Child;
use Illuminate\Support\Facades\Validator;

/**
 * Class NeuralNetworkController
 * @package App\Http\Controllers
 */
class NeuralNetworkController extends Controller
{
    /**
     * Train neural network based on children's favorite toy.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function train(Request $request) {

        $rules = [
            'max_timeout' => 'integer|min:30',
            'layers' => 'integer|min:3',
            'hidden_neurons' => 'integer|between:3,1000',
            'max_iterations' => 'integer|min:100'
        ];

        $v = Validator::make($request->all(), $rules);

        if($v->passes()){
            //set max time for execution (seconds)
            set_time_limit($request->input('max_timeout', 30));

            $generator = new ANN\TrainingDataGenerators\ChildrenToyGenerator();

            $children = Child::get();

            $generator->generateFile($children, storage_path('children.data'));

            $trainer = new ANN\Trainer();

            //configure trainer.
            $trainer->maxIterations = $request->input('max_iterations', $trainer->maxIterations);
            $trainer->numLayers = $request->input('layers', $trainer->numLayers);
            $trainer->numHiddenNeurons = $request->input('hidden_neurons', $trainer->numHiddenNeurons);

            //let's train.
            $trainer->train(storage_path('children.data'), storage_path('children.ann'));

            return response()->json(['status'=> 'success', 'data' => null], 200);

        } else return response()->json(['status'=> 'fail', 'data' => $v->messages()], 200);
    }

    /**
     * Analyze input to get predicted results.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function analyze(Request $request){

        //configure rules for validation.
        $rules = [
            'gender' => 'required|in:male,female',
            'age' => 'required|integer|between:1,12'
        ];

        $v = Validator::make($request->all(), $rules);

        if($v->passes()){

            //Get child for comparison of predicted results.
            $child = Child::with('toy')
                ->where('age', $request->input('age'))
                ->where('gender',$request->input('gender'))
                ->first();

            //Gender needs to be converted to numeric representation.
            $genderConvert = ($request->input('gender') == 'male') ? 0 : 1;

            $annService = new ANN\NeuralNetworkService(storage_path('children.ann'));

            $input = [$genderConvert, intval($request->input('age'))];

            $annOutput = $annService->ask($input);

            $predictedToyId = $this->getPredictedToyId($annOutput);

            $predictedToy = Toy::findOrFail($predictedToyId);

            return response()->json(['status' => 'success', 'data' => [
                'predicted_favorite_toy' => $predictedToy->name,
                'actual_favorite_toy' => $child->toy->name
            ]], 200);

        } else return response()->json(['status'=> 'fail', 'data' => $v->messages()], 400);
    }

    /**
     * Generates an accuracy report of current trained ANN.
     * @return \Illuminate\Http\JsonResponse
     */
    public function accuracy(){

        $children = Child::get();

        $accuracyCount = 0;

        $report = [];

        $annService = new ANN\NeuralNetworkService(storage_path('children.ann'));

        foreach($children as $child){

            //Gender needs to be converted to numeric representation.
            $genderConvert = ($child->gender == 'male') ? 0 : 1;

            $input = [$genderConvert, $child->age];

            $output = $annService->ask($input);

            $predictedToyId = $this->getPredictedToyId($output);

            $accuracyCount += ($predictedToyId == $child->toy_id) ? 1 : 0;

            $report[] = [
                'gender' => $child->gender,
                'age' => $child->age,
                'actual_toy_id' => $child->toy_id,
                'predicted_toy_id' => $predictedToyId,
                'ann_output' => $output,
                'correct' => ($predictedToyId == $child->toy_id) ? true : false
            ];
        }

        $accuracy = round($accuracyCount/$children->count(), 4) * 100;

        return response()->json([
            'status' => 'success',
            'data' => ['accuracy' => $accuracy . '%', 'report' => $report]
        ], 200);
    }

    /**
     * Get predicted toy id based on ANN output.
     *
     * @param $annOutput
     * @return int|null
     */
    private function getPredictedToyId($annOutput){

        //convert back to near representation of toy id and round decimal places.
        $convertedToyResult = round($annOutput[0]*100, 6);

        $toyIds = Toy::lists('id');

        return $this->getClosestToyId($convertedToyResult, $toyIds);
    }

    /**
     * Function to convert ANN output value to nears toy id.
     *
     * @param $search
     * @param $arr
     * @return integer|null
     */
    private function getClosestToyId($search, $arr) {

        $closest = ($arr) ? $arr[0] : null;

        foreach ($arr as $item) {
            if (abs($search - $closest) > abs($item - $search)) {
                $closest = $item;
            }
        }
        return intval($closest);
    }
}