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
    Route::resource('comments', 'CommentsController');
    Route::resource('posts.comments', 'CommentsController');
    Route::post('getComments', 'CommentsController@commentsByPostId');

    Route::post('posts/upload', [
        'uses' => 'PostsController@upload',
        'as' => 'UploadPhoto',
        'middleware' => []
    ]);

    Route::post('posts/uploads', [
        'uses' => 'PostsController@uploads',
        'as' => 'UploadPhoto',
        'middleware' => []
    ]);

    Route::post('posts/deletePost', [
        'uses' => 'PostsController@deletePost',
        'as' => 'DeletePost',
        'middleware' => []
    ]);

    /* Profile Routes starts*/
    Route::post('updateProfile', [
        'uses' => 'UserController@updateProfile',
        'as' => 'EditProfile',
        'middleware' => []
    ]);
    Route::post('userProfile', [
        'uses' => 'UserController@userProfile',
        'as' => 'EditProfile',
        'middleware' => []
    ]);
    Route::get('myProfile', [
        'uses' => 'UserController@myProfile',
        'as' => 'EditProfile',
        'middleware' => []
    ]);
    Route::post('profileImageUpload', [
        'uses' => 'UserController@profileImageUpload',
        'as' => 'profileUpload',
        'middleware' => []
    ]);
    Route::post('profilePosts', [
        'uses' => 'PostsController@profilePosts',
        'as' => 'profilePosts',
        'middleware' => []
    ]);
    /* Profile Routes ends*/

    /* Activity Routes Starts*/
        Route::post('follow', [
            'uses' => 'ActivityController@followUser',
            'as' => 'followUser',
            'middleware' => []
        ]);
        Route::post('likePost', [
            'uses' => 'ActivityController@likePost',
            'as' => 'likePost',
            'middleware' => []
        ]);
        Route::post('activityList', [
            'uses' => 'ActivityController@getTenActivity',
            'as' => 'activityList',
            'middleware' => []
        ]);
    /* Activity Routes ends*/

});

Route::group(['prefix' => 'api'], function () {
    Route::get('emailtest',['uses' => 'UserController@test']);
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
    Route::post('forgotpassword', [
        'uses' => 'UserController@forgotpassword',
        'as' => 'MobileUserForgot',
        'middleware' => []
    ]);
	
    Route::post('explorer', [
        'uses' => 'PostsController@explorer',
        'as' => 'ExploreImages',
        'middleware' => []
    ]);
});
?>