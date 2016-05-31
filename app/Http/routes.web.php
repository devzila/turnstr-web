<?php


#   Route::get('/', 'IndexController@index');

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/', 'HomeController@index');
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

// Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
Route::group(['prefix' => 'admin'], function () {

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
});
