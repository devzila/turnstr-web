<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Useractivity;
use App\Models\Comments;
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
			return redirect('/login');
		}
		
		$updateArry = [
				'post_id' => $request->input('post_id'),
				'comments' => $request->input('comments')
			];
        $rules = [
				'post_id' => 'required',
				'comments' => 'required'
			];

        $validator = Validator::make($updateArry, $rules);
        if ($validator->fails()) {
            return Redirect::to(URL::previous())->withInput()->withErrors($validator);
        }		
		
         $post_id = $request->input('post_id');
         $result = Comments::create([
            'user_id' => Auth::user()->id,
            'post_id' => $post_id,
    		'comments' => $request->input('comments')
    	 ]);

        // tag post if #tag present in comment
        PostTags::tag($post_id, $result->comments);
		return Redirect::back();

    }
    
}
