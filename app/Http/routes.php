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
Route::post('authenticate', 'Auth\RESTAuthController@authenticate');

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::get('users/me', 'UserController@me');
    Route::resource('children', 'ChildController');
    Route::resource('toys', 'ToyController');
    Route::post('ann/train', 'NeuralNetworkController@train');
    Route::get('ann/accuracy', 'NeuralNetworkController@accuracy');

});

//This endpoint does not require authorization.
Route::post('ann/analyze', 'NeuralNetworkController@analyze');