<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Helpers\ResponseClass;
use App\Helpers\UniversalClass;
use Response;
use App\Models\Useractivity;
use App\Models\Comments;
use App\Models\DeviceSession;
use App\Models\Posts;
use Input;
use App\Models\PostTags;
use Mail;
class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()  
    {
         $comments = Comments::where('user_id', DeviceSession::get()->user->id)->get();
         return ResponseClass::Prepare_Response($comments,'',true,200);
		 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

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
		//file_put_contents(public_path()."/media/emoji.txt", $request->input('comments'));
		
         $post_id = $request->input('post_id');
         $result = Comments::createComment([
            'user_id' => DeviceSession::get()->user->id,
            'post_id' => $post_id,
    		'comments' => $request->input('comments')
    	 ]);

        // tag post if #tag present in comment
        //PostTags::tag($post_id, $result->comments);
		if($result->approved){
			$msg = "Comment create successfully";
			$status = true;
		}else{
			$msg = "Sorry your comment seems offensive!";
			$status = false;
		}

        return ResponseClass::Prepare_Response($result,$msg,$status,200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$comments = Comments::find($id);
		return $comments->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
		$comments = Comments::find($id);
    	$comments->comments = $request->input('comments');
		$comments->update();
        return $comments->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $comments = Comments::find($id);
        $comments->delete();
        return ResponseClass::Prepare_Response('','',true,200);
    }
    /**
     * Return list of comments on particular post
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function commentsByPostId()
    {
        $user_id = DeviceSession::get()->user->id;
        $postId = Input::get('post_id');

        $comments = Comments::commentsByPost($postId);

        $likeData = Useractivity::getActivityById($user_id,$postId);
        $posts = Posts::find($postId);
		$isFollowing = 0;
		$postUserID = 0;
		$postUrl = "";
		if($posts){
			$postUrl = UniversalClass::shareUrl($posts->id);
			$postUserID = $posts->user_id;
			$isFollowing = Useractivity::getFollowDetailByUserId($posts->user_id,$user_id);
			$isFollowing = (count($isFollowing) && isset($isFollowing->status)) ? (int)($isFollowing->status) : 0 ;
		}
        $like = (isset($likeData->status)) ? $likeData->status : 0 ;
        
        return ResponseClass::Prepare_Response(['comments'=>$comments,'is_liked'=>$like,'is_Following'=>$isFollowing,'postUserID'=>$postUserID,'postUrl'=>$postUrl],'List of comments',true,200);
    }
	
	public function  deleteUserComment(){		
		$comment_id = Input::get('comment_id');
        $response = Comments::deleteUserComment($comment_id,DeviceSession::get()->user->id);
		$status = ($response['status'] == 1)? true:false;
        return ResponseClass::Prepare_Response('',$response['msg'],$status,200);
	}
	
}
