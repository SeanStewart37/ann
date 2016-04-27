<?php
/**
 * Created by JetBrains PhpStorm.
 * User: seanstewart
 * Date: 4/27/16
 * Time: 8:57 AM
 */

namespace App\Services\ANN\TrainingDataGenerators;
use Illuminate\Support\Facades\File;

/**
 * Generates FANN data file to train ANN
 * using Children's gender and age to predict favorite toy.
 *
 * Class ChildrenToyGenerator
 * @package App\Services\ANN\TrainingDataGenerators
 */
class ChildrenToyGenerator {

    /**
     * Generate data file for FANN to train with.
     *
     * @param $children
     * @param $outputFilePath
     */
    public function generateFile($children, $outputFilePath){

        $contents = "";

        //set file header - # sets, # inputs, # output.
        $contents .= $children->count() . " 2 1\n";

        foreach($children as $child){

            //set input 0 - male, 1 - female. Second input is child's age.
            $contents .= ($child->gender == 'male') ? "0 " : "1 ";
            $contents .= strval($child->age) . "\n";

            //output will be the toys primary key to the tenth decimal place.
            $contents .=  strval($child->toy_id/10) ."\n";
        }

        File::put($outputFilePath, $contents);
    }
}