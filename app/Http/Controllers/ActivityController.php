<?php namespace App\Http\Controllers;

use Config;
use App\Models\Useractivity;
use App\Models\User;
use App\Models\Posts;
use App\Models\Comments;
use App\Helpers\UniversalClass;
use Auth;
use Illuminate\Http\Request;
 /**
 * User Activity Class Web
 *
 * 
 */

class ActivityController extends Controller {
	
	public function __construct(Request $request){
		$this->request = $request;
	}
		
	public function getActivity() {
		$pageTitle = "Activity";
        $user_id = Auth::user()->id;
        $activityList = array();

        $alreadyLiked = Useractivity::getLastTenActivity($user_id);
		
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
                $value->user_info = $userInfoFinal;
                $value->post_info = $postInfoFinal;
               
            } else {
                
                unset($alreadyLiked[$key]->likedby_name);
                unset($alreadyLiked[$key]->likedby_id);
                unset($alreadyLiked[$key]->likedby_image);
                unset($alreadyLiked[$key]->likedof_name);
               
                $userInfo = User::find($alreadyLiked[$key]->follower_id);
                
                $value->user_info = (count($userInfo)) ? $userInfo : '' ;
                $value->is_following = $alreadyLiked[$key]->status;
            }
        }
		return view("activity.activity",['activities'=>$alreadyLiked,'page_title'=>$pageTitle]);
    }
	/*
	* followId (user_id of user you are following)
    * followStatus (1= follow & 0 = unfollow)
	*
	*/
	public function followUser(){
		$followerId = Auth::user()->id;
		$following_id = $this->request->get('followId');
		$following_status = $this->request->get('status');	
		
		Useractivity::followUnfollowStatus($following_id,$followerId,$following_status);
		
		$msg = ($following_status) ? "Successfully Followed": "Successfully UnFollowed";
		$response = [ 'status'=>1,'msg'=>$msg];
		return response()->json($response,200);
		
	}

	
}



