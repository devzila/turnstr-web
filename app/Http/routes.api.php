<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['turnstr.api'], 'prefix' => 'api'], function () {

    Route::get('test',['uses' => 'UserController@test']);
    Route::resource('posts', 'PostsController');
    Route::resource('posts.comments', 'CommentsController');

    Route::post('posts/upload', [
        'uses' => 'PostsController@upload',
        'as' => 'UploadPhoto',
        'middleware' => []
    ]);

});

Route::group(['prefix' => 'api'], function () {
    Route::post('login', [
        'uses' => 'UserController@login',
        'as' => 'MobileUserLogin',
        'middleware' => []
    ]);

    Route::post('register', [
        'uses' => 'UserController@register',
        'as' => 'MobileUserRegister',
        'middleware' => []
    ]);
    Route::post('logout', [
        'uses' => 'UserController@logout',
        'as' => 'MobileUserLogout',
        'middleware' => []
    ]);


	
});




?>