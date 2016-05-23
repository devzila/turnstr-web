<?php

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/home', 'HomeController@index');
    Route::get('/share/{id}', 'ShareController@index');
});
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
