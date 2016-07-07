<?php namespace App\Http\Controllers;

use Config;
use App\Models\Useractivity;
use App\Models\User;
use App\Models\Posts;
use App\Models\Comments;
use App\Helpers\UniversalClass;
use Auth;
use Input;
use Illuminate\Http\Request;
 /**
 * User Activity Class Web
 *
 * 
 */

class ActivityController extends Controller {
	const POSTS_PER_PAGE = 20;
	
	public function __construct(Request $request){
		$this->request = $request;
	}
		
	public function getActivity() {
		$pageTitle = "Activity";
        $user_id = Auth::user()->id;
        $activityList = array();
		$page = Input::get('page', 0);
        $alreadyLiked = Useractivity::getActivity($user_id,$page,self::POSTS_PER_PAGE);
        foreach ($alreadyLiked as $key => $value) {
            if ($alreadyLiked[$key]->activity=='liked' || $alreadyLiked[$key]->activity=='comment') {
				$value->user_info_profile_image = $value->likedby_image;
				$value->user_info_id = $value->likedby_id;
				$value->user_info_name = $value->likedby_name;               
				$value->user_info_username = $value->likedby_username;               
				
				            
            } else {                
                $value->user_info_profile_image = $value->follower_image;
				$value->user_info_id = $value->follower_id;
				$value->user_info_name = $value->follower_name;
				$value->user_info_username = $value->follower_username;				
							
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
		
		
		if(!isset(Auth::user()->id) || empty($this->request->get('followId'))){
			
			$response = [ 'status'=>3,'msg'=>"Please Login"];
			return response()->json($response,200);
		}
		$followerId = Auth::user()->id;
		$following_id = $this->request->get('followId');
		$following_status = $this->request->get('status');	
		
		Useractivity::followUnfollowStatus($following_id,$followerId,$following_status);
		
		$msg = ($following_status) ? "Successfully Followed": "Successfully UnFollowed";
		$response = [ 'status'=>1,'msg'=>$msg];
		return response()->json($response,200);
		
	}
	
	 public function likePost() {
		
		if(!isset(Auth::user()->id) || empty($this->request->get('postId'))){
			
			$response = [ 'status'=>3,'msg'=>"Please Login"];
			return response()->json($response,200);
		}
		
		$likedBy = Auth::user()->id;
		
        $post_id = $this->request->get('postId'); // post id
		
        $like_status = $this->request->get('status'); // like/unlike
		$postDetail = Posts::find($post_id);		
        Useractivity::likeUnlikeStatus($post_id,$postDetail->user_id,$likedBy,$like_status);
		
        $msg = ($like_status) ? "Successfully Liked": "Successfully Unliked";
		$response = [ 'status'=>1,'msg'=>$msg];
		return response()->json($response,200);
        
    }
   
	
	

	
}



