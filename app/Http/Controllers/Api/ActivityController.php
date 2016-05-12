<?php namespace App\Http\Controllers\Api;

use Config;

use App\Models\DeviceSession;
use App\Http\Requests\Api\UserLoginRequest;
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

        if (count($alreadyFollowing)) {
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
            
        } else {
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
    public function likePost() {

        $likedBy = DeviceSession::get()->user->id; // who liked post
        $likedOf = Input::get('post_user'); // who's post is liked
        $post_id = Input::get('post_id'); // post id
        $like_status = Input::get('like_status'); // like/unlike

        $alreadyLiked = Useractivity::where('user_id',$likedOf)->where('liked_id',$likedBy)->where('activity','liked')->first();

        if (count($alreadyLiked)) {
            $updateArr = array(
                    'status'=>$like_status
                );
            Useractivity::where('user_id',$likedOf)->where('liked_id',$likedBy)->where('activity','liked')->update($updateArr);
            
        } else {
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
        
        foreach ($alreadyLiked as $key => $value) {
            $data[$key]['activity_id'] = $alreadyLiked[$key]->activity_id;
            $data[$key]['activity_status'] = $alreadyLiked[$key]->activitywwwhn;
            $data[$key]['post']['media1_thumb_url'] = $alreadyLiked[$key]->media1_thumb_url;
            $data[$key]['post']['media2_thumb_url'] = $alreadyLiked[$key]->media2_thumb_url;
            $data[$key]['post']['media3_thumb_url'] = $alreadyLiked[$key]->media3_thumb_url;
            $data[$key]['post']['media4_thumb_url'] = $alreadyLiked[$key]->media4_thumb_url;
            $data[$key]['post']['media1_url'] = $alreadyLiked[$key]->media1_url;
            $data[$key]['post']['media2_url'] = $alreadyLiked[$key]->media2_url;
            $data[$key]['post']['media3_url'] = $alreadyLiked[$key]->media3_url;
            $data[$key]['post']['media4_url'] = $alreadyLiked[$key]->media4_url;
            $data[$key]['post']['turn_id'] = $alreadyLiked[$key]->turn_id;
            
            $data[$key]['liked_user']['follower_id'] = $alreadyLiked[$key]->media4_url;
            $data[$key]['liked_user']['follower_image'] = $alreadyLiked[$key]->media4_url;
            $data[$key]['liked_user']['follower_name'] = $alreadyLiked[$key]->media4_url;

            $data[$key]['follow_details']['likedby_id'] = $alreadyLiked[$key]->media4_url;
            $data[$key]['follow_details']['likedby_image'] = $alreadyLiked[$key]->media4_url;
            $data[$key]['follow_details']['likedby_name'] = $alreadyLiked[$key]->media4_url;
            
            $data[$key]['user']['name'] = $alreadyLiked[$key]->name;
            $data[$key]['user']['profile_image'] = $alreadyLiked[$key]->profile_image;
            $data[$key]['user']['phone_number'] = $alreadyLiked[$key]->phone_number;
            $data[$key]['user']['gender'] = $alreadyLiked[$key]->gender;
            $data[$key]['user']['website'] = $alreadyLiked[$key]->website;
            
            
            if ($value->activity == 'follow') {

                if ($value->user_id == $user_id) {

                } else  if ($value->user_id == $user_id) {

                }

            } else if ($value->activity == 'likeed') {

            }
        }
        return ResponseClass::Prepare_Response($data,'Activiy list',true,200);
        
    }
}