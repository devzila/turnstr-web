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
    Route::resource('posts.tag', 'TagsController', ['only' => ['store']]);
    Route::resource('tag', 'TagsController', ['only' => ['show']]);
    Route::resource('comments', 'CommentsController');
    Route::resource('posts.comments', 'CommentsController');
    Route::post('getComments', 'CommentsController@commentsByPostId');
    Route::get('homePage/{page?}', 'PostsController@index');
    Route::get('followersList', 'UserController@followersList');
    Route::post('markInappropriate', 'PostsController@markInappropriate');

    Route::get('user/{id}/followers',['uses' => 'UserController@followers']);
    Route::get('user/{id}/followings',['uses' => 'UserController@followings']);
    Route::get('me/followings',['uses' => 'UserController@currentUserFollowings']);

    Route::post('posts/upload', [
        //'uses' => 'PostsController@upload',
        //'uses' => 'PostsController@uploadFileToS3Aws',
        'uses' => 'PostsController@uploadTurn',
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
        'as' => 'UserProfile',
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
        Route::post('otheruser', [
            'uses' => 'PostsController@otheruser',
            'as' => 'OtherUser',
            'middleware' => []
        ]);
		 Route::post('explorer', [
			'uses' => 'PostsController@explorer',
			'as' => 'ExploreImages',
			'middleware' => []
		]);
		Route::post('deleteComment', [
            'uses' => 'CommentsController@deleteUserComment',
            'as' => 'deleteUserComment',
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
    Route::post('login/facebook', [
        'uses' => 'UserController@loginFacebook',
        'as' => 'MobileUserLoginFacebook',
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
        'uses' => '\App\Http\Controllers\Auth\PasswordController@postApiPassword',
        'as' => 'MobileUserForgot',
        'middleware' => []
    ]);
    
   
	
    //shareURL
    Route::post('posts/shareUrl', [
        'uses' => 'PostsController@shareUrl',
        'as' => 'shareUrlPost',
        'middleware' => []
    ]);
});
?>