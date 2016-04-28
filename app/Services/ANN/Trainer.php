<?php

namespace App\Services\ANN;
use Exception;

class Trainer {

    public $numInput = 2;
    public $numOutput = 1;
    public $numLayers = 3;
    public $numHiddenNeurons = 3;
    public $desiredErrorRate = 0.0000001;
    public $maxIterations = 3000000;

    /**
     * Overload constructor to verify FANN extension installed.
     */
    public function __construct() {

        if(!extension_loaded('fann'))
            throw new Exception('FANN PHP Extension Not Loaded');
    }

    /**
     *
     * @param $trainingDataFilePath
     * @param $annOutputFilePath
     */
    public function train($trainingDataFilePath, $annOutputFilePath){

        $ann = fann_create_standard($this->numLayers, $this->numInput, $this->numHiddenNeurons, $this->numOutput);

        if($ann){

            fann_set_activation_function_hidden($ann, FANN_SIGMOID_SYMMETRIC);
            fann_set_activation_function_output($ann, FANN_SIGMOID_SYMMETRIC);

            if (fann_train_on_file($ann, $trainingDataFilePath, $this->maxIterations, 10000, $this->desiredErrorRate)){
                fann_save($ann, $annOutputFilePath);
            }

            fann_destroy($ann);
        }
    }
}