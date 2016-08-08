<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\UniversalClass;
use App\Http\Requests;
use App\Models\Useractivity;
use App\Models\Comments;
use App\Models\User;
use Input;
use App\Models\PostTags;
use Auth;
use Redirect;
use Validator;
use URL;

class CommentsController extends Controller
{
    

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * api/posts/<post_id>/comments
     */
    public function store(Request $request)
    {
		
		if(!isset(Auth::user()->id)){
			$response = [ 'status'=>3,'msg'=>"Please Login to Comment"];
			return response()->json($response,200);
		}
		$user_id = Auth::user()->id;
		$post_id = $request->input('post_id');
		$comments = $request->input('comments');
		$updateArry = [				
				'comments' => $comments
			];
        $rules = [				
				'comments' => 'required'
			];

        $validator = Validator::make($updateArry, $rules);
		
        if ($validator->fails()) {
			$err = $validator->errors()->all();
            $response = [ 'status'=>2,'msg'=>$err];
			return response()->json($response,200);
        }	
         
         $result = Comments::createComment([
            'user_id' => $user_id,
            'post_id' => $post_id,
    		'comments' => $comments
    	 ]);
		
		if($result->approved !=1){
			$response = [ 'status'=>2,'msg'=>"Sorry your comment seems offensive!"];
			return response()->json($response,200);
		}
		
        // tag post if #tag present in comment
        
		$user =array();
		$userDetail = User::find($user_id);
		if($userDetail){
			if($userDetail->profile_image)
				$profile_image =  $userDetail->profile_image;
			elseif($userDetail->fb_token)
				$profile_image = "http://graph.facebook.com/".$userDetail->fb_token."/picture?type=normal";
			else
				$profile_image = "/assets/images/defaultprofile.png";
			
		}
		$comment_link = UniversalClass::replaceTagMentionLink($comments);
		$commentBlock = '<div class="w-clearfix userinfo delete-user-comment-'.$result->id.'">
                            <div class="userthumb">
								<a href="/userprofile/'.$userDetail->id.'"><img src="'.$profile_image.'" class="img-circle"></a>
							</div>
                            <div class="usercommentsblock">
                                <div class="username"><a href="/userprofile/'.$userDetail->id.'">'.$userDetail->username.'</a></div>
                                <div class="usercomment">'.$comment_link.'</div>
                            </div>
                                                        <div class="postedtime time-ago">
								few second ago
																	<br><div class="pull-right"><a title="Delete Comment" class="deleteComment" data-cmsg="Do you want to delete this Comment?" data-id="'.$result->id.'" data-href="/deleteComment/'.$result->id.'" href="javascript:void(0);">x</a></div>
															</div>
                            <div class="photocaption"></div>
                        </div>';
		$response = [ 'status'=>1,'msg'=>"Successfully Added",'commentBlock'=>$commentBlock];
		return response()->json($response,200);

    }
	
	
	public function  deleteComment($comment_id){
		
		if(!isset(Auth::user()->id)){
			$response = [ 'status'=>3,'msg'=>"Please Login to Delete Comment"];
			return response()->json($response,200);
		}		
        $response = Comments::deleteUserComment($comment_id,Auth::user()->id);
		
        return response()->json($response,200);
	}
    
}
