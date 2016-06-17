<?php


#   Route::get('/', 'IndexController@index');

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/', 'HomeController@index');
    Route::get('/share/{id}', 'ShareController@index');
	
    Route::get('/userprofile/{id?}', 'UserController@userProfile');	
	Route::resource('comments', 'CommentsController');

	Route::post('/users/followuser',[
        'uses' => 'ActivityController@followUser',
        'as' => 'followUser',
		'middleware' => 'auth'
    ]);	
	Route::post('/users/likePost',[
        'uses' => 'ActivityController@likePost',
        'as' => 'likePost',
		'middleware' => 'auth'
    ]);
	
	Route::get('/explore',[
        'uses' => 'HomeController@explore',
        'as' => 'explore',
		'middleware' => 'auth'
    ]);
	
	Route::get('/users/activity',[
        'uses' => 'ActivityController@getActivity',
        'as' => 'user_activity',
		'middleware' => 'auth'
    ]);
	
	Route::get('/users/edit',[
        'uses' => 'UserController@edit',
        'as' => 'user_edit',
		'middleware' => 'auth'
    ]);
	Route::get('/users/update',[
        'uses' => 'UserController@updateProfile',
        'as' => 'updateProfile',
		'middleware' => 'auth'
    ]);
	Route::post('/users/changepassword',[
        'uses' => 'UserController@changePasword',
        'as' => 'change_pwd',
		'middleware' => 'auth'
    ]);	
	Route::get('/tags', [
        'uses' => 'TagsController@index',
        'as' => 'tags',
		'middleware' => 'auth'
    ]);
    
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
