<?php

namespace App\Services\ANN;

use Illuminate\Support\Facades\File;
use App\Child;

/**
 * Class NeuralNetworkService
 * @package App\Services
 */
class NeuralNetworkService {

    public function ask($input, $trainedANNFilePath){

        if (!is_file($trainedANNFilePath))
            die("The file xor_float.net has not been created! Please run simple_train.php to generate it");

        $ann = fann_create_from_file($trainedANNFilePath);

        if (!$ann)
            die("ANN could not be created");

        $calc_out = fann_run($ann, $input);

        fann_destroy($ann);

        return $calc_out;
    }
}