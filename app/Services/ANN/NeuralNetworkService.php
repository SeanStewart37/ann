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

    protected $trainedANNFilePath = null;

    /**
     * @param $trainedANNFilePath
     */
    public function __construct($trainedANNFilePath) {

        if(!extension_loaded('fann'))
            throw new Exception('FANN PHP Extension Not Loaded');

        if (!is_file($trainedANNFilePath))
            throw new Exception("The training data file has not been created.");

        $this->trainedANNFilePath = $trainedANNFilePath;
    }

    /**
     * Generates an answer based on provided input.
     *
     * @param $input
     * @param $trainedANNFilePath
     * @return mixed
     * @throws \Exception
     */
    public function ask($input){

        $ann = fann_create_from_file($this->trainedANNFilePath);

        if (!$ann)
            throw new Exception("There was an issue creating ANN");

        $output = fann_run($ann, $input);

        fann_destroy($ann);

        return $output;
    }
}