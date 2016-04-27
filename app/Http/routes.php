<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group([], function () {
    Route::resource('children', 'ChildController');
    Route::resource('toys', 'ToyController');
    Route::post('ann/train', 'NeuralNetworkController@train');
    Route::post('ann/test', 'NeuralNetworkController@test');
});
