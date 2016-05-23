<?php namespace App\Http\Controllers\Api;

use Config;

use App\Models\DeviceSession;
use App\Helpers\UniversalClass;
use App\Http\Requests\Api\UserLoginRequest;
use App\Http\Requests\Api\LikeRequest;
use App\Http\Requests\Api\UserRegistrationRequest;
use App\Http\Requests\Api\UserLogoutRequest;
use App\Http\Requests\Api\UserForgotpasswordRequest ;
use App\Http\Requests\Api\UserUpdateRequest ;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Posts;
use App\Models\Passwordreset;
use App\Models\Api;
use App\Helpers\ResponseClass;
use Hash;
use Response;
use App\Models\UserDevice;
use App\Models\Useractivity;
use App\Models\Comments;
use Mail;
use URL;
use Input;
class ActivityController extends Controller {
    /**
     * The Http Request Object
     *
     * @var Object
     */
    protected $request;


    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /*
    *   Function to follow or unfollow a user.
    */
    public function followUser() {

        $followerId = DeviceSession::get()->user->id; // who is following
        $following_id = Input::get('following_id'); // who is being followed
        $following_status = Input::get('following_status'); // following/unfollowing

        $alreadyFollowing = Useractivity::where('user_id',$following_id)->where('follower_id',$followerId)->where('activity','follow')->first();

        if (count($alreadyFollowing) && $alreadyFollowing->status != $following_status) {
            $updateArr = array(
                    'status'=>$following_status
                );
            Useractivity::where('user_id',$following_id)->where('follower_id',$followerId)->where('activity','follow')->update($updateArr);

            if ($following_status) {
                User::where('id',$followerId)->increment('following');
                User::where('id',$following_id)->increment('followers');
            } else {

                User::where('id',$followerId)->decrement('following');
                User::where('id',$following_id)->decrement('followers');
            }
            
        } else if (!count($alreadyFollowing)) {
            $insArr = array(
                    'user_id'=>$following_id,
                    'follower_id'=>$followerId,
                    'activity'=>'follow',
                    'status'=>1,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
                );
            Useractivity::insert($insArr);
            User::where('id',$followerId)->increment('following');
            User::where('id',$following_id)->increment('followers');
        }
        return ResponseClass::Prepare_Response('','Action performed successfully',true,200);
        
    }
    /*
    *   Function to like a post.
    */
    public function likePost(LikeRequest $LikeRequest) {

        $likedBy = DeviceSession::get()->user->id; // who liked post
        $likedOf = Input::get('post_user'); // who's post is liked
        $post_id = Input::get('post_id'); // post id
        $like_status = Input::get('like_status'); // like/unlike

        $alreadyLiked = Useractivity::where('post_id',$post_id)->where('liked_id',$likedBy)->where('activity','liked')->first();
        
        if (count($alreadyLiked) && $alreadyLiked->status != $like_status) {
            $updateArr = array(
                    'status'=>$like_status
                );
            Useractivity::where('post_id',$post_id)->where('liked_id',$likedBy)->where('activity','liked')->update($updateArr);
            if ($like_status==1) {
                Posts::where('id',$post_id)->increment('total_likes');
            } else if ($like_status==0) {
                Posts::where('id',$post_id)->decrement('total_likes');
            }
            
        } else if (!count($alreadyLiked)) {
            $insArr = array(
                    'user_id'=>$likedOf,
                    'liked_id'=>$likedBy,
                    'post_id'=>$post_id,
                    'activity'=>'liked',
                    'status'=>1,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
                );
            Useractivity::insert($insArr);
        }
        return ResponseClass::Prepare_Response('','Action performed successfully',true,200);
        
    }
    /*
    *   Function to get last 10 activities
    */
    public function getTenActivity() {

        $user_id = DeviceSession::get()->user->id; // who liked post
        $activityList = array();

        $alreadyLiked = Useractivity::getLastTenActivity($user_id);
//        print_r($alreadyLiked);die;
        foreach ($alreadyLiked as $key => $value) {
            if ($alreadyLiked[$key]->activity=='liked') {

                // Removing following details 
                unset($alreadyLiked[$key]->following_name);
                unset($alreadyLiked[$key]->follower_name);
                unset($alreadyLiked[$key]->follower_id);
                unset($alreadyLiked[$key]->follower_image);

                // fetching user and posts data
                $userInfo = User::find($alreadyLiked[$key]->likedby_id);
                $postInfo = Posts::find($alreadyLiked[$key]->turn_id);

                // adding user info
                if (count($userInfo)) {
                    $postCount = Posts::where('user_id',$userInfo->id)->count();
                    $userInfo->post_count = ($postCount>0) ? (string)$postCount : "0" ;
                    $followingDetails = Useractivity::getFollowDetailByUserId($userInfo->id,$user_id);
                    $userInfo->is_following = (count($followingDetails) && isset($followingDetails->status)) ? (int)($followingDetails->status) : 0 ;
                    $userInfo->id = (string)($userInfo->id);
                    $userInfoFinal =  $userInfo;
                } else {
                    $userInfoFinal =  '';
                }
                // adding post info
                if (count($postInfo)) {
                    $commentsCount = comments::commentsCountByPostId($alreadyLiked[$key]->turn_id);
                    $postInfo->post_comments_count = ($commentsCount>0) ? (string)$commentsCount : "0" ;
                    $postInfoFinal =  $postInfo;
                    $postInfo->id =  (string)($postInfo->id);
                    // adding share url
                    $postInfo->shareUrl = UniversalClass::shareUrl($alreadyLiked[$key]->turn_id);
                } else {
                    $postInfoFinal =  '';
                }

                // Inserting user and post data
                $value->user_info = $userInfoFinal;
                $value->post_info = $postInfoFinal;
                // $value->post_comments_count = ($commentsCount>0) ? $commentsCount : 0 ;
            } else {
                // Removing like details
                unset($alreadyLiked[$key]->likedby_name);
                unset($alreadyLiked[$key]->likedby_id);
                unset($alreadyLiked[$key]->likedby_image);
                unset($alreadyLiked[$key]->likedof_name);
               
                $userInfo = User::find($alreadyLiked[$key]->follower_id);
                // unset($alreadyLiked[$key]->follower_name);
                //  //unset($alreadyLiked[$key]->following_name);
                // unset($alreadyLiked[$key]->follower_id);
                // unset($alreadyLiked[$key]->follower_image);
                // Adding following count
                //$followingDetails = Useractivity::getFollowDetailByUserId($userInfo->id,$user_id);
              //  echo $alreadyLiked[$key]->status;die;
                $value->user_info = (count($userInfo)) ? $userInfo : '' ;
                $value->is_following = $alreadyLiked[$key]->status;
            }
        }
        return ResponseClass::Prepare_Response($alreadyLiked,'Activiy list',true,200);
        
    }
}