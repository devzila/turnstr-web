<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Helpers\ResponseClass;
use Response;
use App\Models\Comments;
use App\Models\DeviceSession;
use Input;

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
    public function store(Request $request, $post_id)
    {
      $result = Comments::create([
        'user_id' => DeviceSession::get()->user->id,
         'post_id' => $post_id,
		 'comments' => $request->input('comments'),
	 ]);
      return ResponseClass::Prepare_Response($result,'',true,200);
        // return Response::json($result, 200);
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
        $postId = Input::get('post_id');
		$comments = Comments::commentsByPost($postId);
        return ResponseClass::Prepare_Response($comments,'List of comments',true,200);
    }
}
