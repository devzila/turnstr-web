<?php

namespace App\Http\Controllers;

use App\Helpers\UniversalClass;
use App\Models\User;
use App\Models\Useractivity;
use App\Models\Posts;
use App\Models\Comments;
use Auth;

class ShareController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $decryptedPostId = UniversalClass::decrypt($id);

        $data['post'] = Posts::find($decryptedPostId);
		$user_id = $data['post']->user_id;
		//$mainUserId = Auth::user()->id;
		
		$data['userdetail'] = User::find($user_id);
		
        $data['comments'] = Comments::commentsByPost($decryptedPostId);
		// Adding comments count
		$commentsCount = Comments::commentsCountByPostId($decryptedPostId);
		$commentsCount = ($commentsCount==-1)?0:$commentsCount;
		$data['total_comments'] = (string)($commentsCount);
		// adding total likes
		$total_likes = Useractivity::likeCountByPostId($decryptedPostId);
		$total_likes = ($total_likes==-1)?0:$total_likes;
		$data['total_likes'] = (string)($total_likes);
		
		if(isset(Auth::user()->id)){
			$mainUserId = Auth::user()->id;
			$followingDetails = Useractivity::getFollowDetailByUserId($user_id,$mainUserId);
			$data['is_following'] = (count($followingDetails) && isset($followingDetails->status)) ? (int)($followingDetails->status) : 0 ;
		}else{
			$data['is_following']=0;
		}
        $extensionArr = array('mov','mp4');

        for ($i=0;$i<=4;$i++) {
            $mediaurl = "media".$i."_url";
            $mediatype = "media".$i."_type";
            if (isset($data['post']->$mediaurl)) {
                $arr = explode('.',$data['post']->$mediaurl);
                $arrLength = count($arr);

                if (in_array($arr[$arrLength-1], $extensionArr)) {
                    $data['post']->$mediatype = 'video';
                } else {
                    $data['post']->$mediatype = 'image';
                }
            }
        }

        return view('share/index', $data);

    }
}
