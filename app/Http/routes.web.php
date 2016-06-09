<?php


#   Route::get('/', 'IndexController@index');

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/', 'HomeController@index');
    Route::get('/share/{id}', 'ShareController@index');
    Route::get('/userprofile/{id?}', 'UserController@userProfile');
    Route::get('/users/edit', 'UserController@edit');
    Route::post('/users/update', 'UserController@updateProfile');
    Route::get('/users/activity', 'ActivityController@getActivity');
	Route::get('/discover', 'HomeController@discover');
	Route::post('/users/changepassword', 'UserController@changePasword');
    
});

Route::group(['middleware' => ['web','auth'], 'prefix' => 'admin'], function () {

    Route::get('/', [
        'uses' => 'Admin\HomeController@index',
        'as' => 'admin_home'
    ]);


    // Post routes
    Route::resource('/posts', 'Admin\PostController');
    Route::resource('/comments', 'Admin\CommentsController');
    Route::resource('/users', 'Admin\UserController');

    // User Routes
    Route::get('users', [
        'uses' => 'Admin\UserController@index',
        'as' => 'posts_listing'
    ]);
	Route::post('users/{id}/update', [
        'uses' => 'Admin\UserController@update',
        'as' => 'user_update'
    ]);
});
