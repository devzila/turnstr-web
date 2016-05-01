<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// for shared image

Route::get('forgotpassword/{shortcode}', [
    'uses' => 'UserController@resetpassword',
    'middleware' => []
]);

Route::post('updatePasword', [
    'uses' => 'UserController@updatePasword',
    'as' => 'updatePasword',
    'middleware' => []
]);

Route::resource('/','HomeController');

// APi for shared web url
Route::get('posts/{id}', [
    'uses' => 'PostsController@index',
    'middleware' => []
]);