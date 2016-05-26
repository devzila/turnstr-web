<?php


Route::get('/', 'IndexController@index');

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

// Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
Route::group(['prefix' => 'admin'], function () {

    Route::get('/', [
        'uses' => 'admin\HomeController@index',
        'as' => 'admin_home'
    ]);
    // Post routes
    Route::get('posts', [
        'uses' => 'admin\PostController@index',
        'as' => 'posts_listing'
    ]);
    Route::get('deletepost/{post_id}', [
        'uses' => 'admin\PostController@deletepost',
        'as' => 'posts_listing'
    ]);
    Route::get('postcomment/{post_id}', [
        'uses' => 'admin\PostController@postcomment',
        'as' => 'posts_comment'
    ]);
    Route::get('editpost/{post_id}', [
        'uses' => 'admin\PostController@editpost',
        'as' => 'edit_post'
    ]);
    // User Routes
    Route::get('users', [
        'uses' => 'admin\UserController@index',
        'as' => 'posts_listing'
    ]);
});
