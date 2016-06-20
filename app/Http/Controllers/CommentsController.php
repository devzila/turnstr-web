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
		
         
         $result = Comments::create([
            'user_id' => $user_id,
            'post_id' => $post_id,
    		'comments' => $comments
    	 ]);

        // tag post if #tag present in comment
        PostTags::tag($post_id, $result->comments);
		$user =array();
		$userDetail = User::find($user_id);
		if($userDetail){
			$user = [				
				'profile_image' => ($userDetail->profile_image)? $userDetail->profile_image : "/assets/images/defaultprofile.png"
			];
		}
		$comment_link = UniversalClass::replaceTagMentionLink($comments);
		$commentBlock = '<div class="w-clearfix userinfo">
                            <div class="userthumb">
								<a href="/userprofile/'.$userDetail->id.'"><img src="'.$user['profile_image'].'" class="img-circle"></a>
							</div>
                            <div class="usercommentsblock">
                                <div class="username"><a href="/userprofile/'.$userDetail->id.'">'.$userDetail->username.'</a></div>
                                <div class="usercomment">'.$comment_link.'</div>
                            </div>
                                                        <div class="postedtime">0 seconds</div>
                            <div class="photocaption"></div>
                        </div>';
		$response = [ 'status'=>1,'msg'=>"Successfully Added",'commentBlock'=>$commentBlock];
		return response()->json($response,200);

    }
    
}
