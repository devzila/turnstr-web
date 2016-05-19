<?php


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


Route::group(['middleware' => ['web']], function () { 
    Route::auth();
     Route::get('login', [ 'as' => 'user.login', 'uses' => 'AuthController@index']);
     Route::post('login', 'AuthController@login');
    //Route::get('register', [ 'as' => 'user.register', 'uses' => 'AuthController@register']);
   // Route::post('register', [ 'as' => 'user.register', 'uses' => 'AuthController@register']);
   // Route::get('logout', [ 'as' => 'user.logout', 'uses' => 'AuthController@logout']);

    Route::get('home', 'HomeController@index');
//    Route::get('posts/{id}', [
//      'uses' => 'PostsController@index',
//      'middleware' => ['auth']
//  ]);
    
});


Route::get('forgotpassword/{shortcode}', [
    'uses' => 'UserController@resetpassword',
    'middleware' => []
]);

Route::post('updatePasword', [
    'uses' => 'UserController@updatePasword',
    'as' => 'updatePasword',
    'middleware' => []
]);

//Route::resource('/','HomeController');

// APi for shared web url

Route::get('posts/{id}', [
    'uses' => 'PostsController@index',
    'middleware' => []
]);

Route::group(['middleware' => ['auth'], 'prefix' => 'account'], function () {

    Route::get('/home', [
        'uses' => 'AccountController@index',
        'as' => 'user_home'
    ]);
});

Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {

    Route::get('/', [
        'uses' => 'admin\HomeController@index',
        'as' => 'admin_home'
    ]);
});
