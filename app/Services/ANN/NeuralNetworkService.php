<?php

namespace App\Services\ANN;

use Illuminate\Support\Facades\File;
use App\Child;
use Exception;

/**
 * Class NeuralNetworkService
 * @package App\Services
 */
class NeuralNetworkService {

    /**
     * Generates an answer based on provided input.
     *
     * @param $input
     * @param $trainedANNFilePath
     * @return mixed
     * @throws \Exception
     */
    public function ask($input, $trainedANNFilePath){

        if (!is_file($trainedANNFilePath))
            throw new Exception("The training data file has not been created.");

        $ann = fann_create_from_file($trainedANNFilePath);

        if (!$ann)
            die("There was an issue creating ANN");

        $output = fann_run($ann, $input);

        fann_destroy($ann);

        return $output;
    }
}