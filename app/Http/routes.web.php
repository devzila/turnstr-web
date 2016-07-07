<?php


#   Route::get('/', 'IndexController@index');

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/', 'HomeController@index');
    Route::get('/share/{id}', 'ShareController@index');
	
    Route::get('/userprofile/{id?}', 'UserController@userProfile');	
	Route::resource('comments', 'CommentsController');
	Route::get('/tags', 'TagsController@index');
	
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
	Route::post('/users/update',[
        'uses' => 'UserController@updateProfile',
        'as' => 'updateProfile',
		'middleware' => 'auth'
    ]);
	Route::post('/users/changepassword',[
        'uses' => 'UserController@changePasword',
        'as' => 'change_pwd',
		'middleware' => 'auth'
    ]);	
	
	Route::post('/markInappropriate/{id}',[
        'uses' => 'ReportController@markInappropriatePost',
        'as' => 'inapp',
		//'middleware' => ''
    ]);	
	
	Route::post('/deletePost/{id}',[
        'uses' => 'HomeController@deletePost',
        'as' => 'deletePost',		
    ]);	
	
	Route::get('auth/facebook', 'Auth\AuthController@redirectToProvider');
	Route::get('auth/facebook/callback', 'Auth\AuthController@handleProviderCallback');
    
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
	Route::post('comments/approve', [
        'uses' => 'Admin\CommentsController@approve',
        'as' => 'comment_approve'
    ]);
	
	Route::post('posts/activate', [
        'uses' => 'Admin\PostController@activate',
        'as' => 'posts_activate'
    ]);
	
	Route::get('reports/{id}', [
        'uses' => 'Admin\ReportController@index',
        'as' => 'posts_activate'
    ]);
	
	Route::get('settings/profane', [
        'uses' => 'Admin\SettingsController@profane',
        'as' => 'profane'
    ]);
	Route::post('settings/profaneUpdate', [
        'uses' => 'Admin\SettingsController@profaneUpdate',
        'as' => 'profane'
    ]);
	
});
