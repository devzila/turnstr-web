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

Route::get('/login',function(){
    return view('login');
});
Route::get('logout', array('uses' => 'Auth\AuthController@logout'));


Route::post('login', [
    'uses' => 'Auth\AuthController@authenticate',
    'as' => 'authenticate',
    'middleware' => []
]);

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

Route::group(['middleware' => [], 'prefix' => 'admin'], function () {

    Route::get('/', function () {
        return view('admin/index');
    });
});