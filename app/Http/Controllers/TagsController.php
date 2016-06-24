<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Helpers\UniversalClass;

use App\Models\PostTags;
use App\Models\Posts;

use App\Models\Useractivity;
use App\Models\Comments;

use DB;
use Auth;

class TagsController extends Controller
{

    const POSTS_PER_PAGE = 10;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		
        $page = $request->input('page', 0);
        $tag = $request->input('searchData','');
		$page_title = "#".$tag;
		if(empty($request->input('jsonp'))){
			return view('tags', ['page_title'=>$page_title]);
		}
        $posts = DB::table('posts')
            ->join('post_tags', 'posts.id', '=', 'post_tags.post_id')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->where('post_tags.tag_name', '=', $tag)
            ->select('posts.*', 'users.name', 'users.profile_image', 'users.username')
            ->skip($page * self::POSTS_PER_PAGE)->take(self::POSTS_PER_PAGE)
            ->get();

        // add additional field
        $posts = Posts::addExtraAttributes($posts);
		
		$userId = Auth::user()->id;
		if($userId && $posts){			
            foreach ($posts as $key => $value) {
				$commentsCount = Comments::commentsCountByPostId($value->id);
				$value->total_comments = (string)(($commentsCount>0)?$commentsCount:0);
				 
                $value->total_likes = (string)(($value->total_likes > 0 )?$value->total_likes:0);
				
				$followingDetails = Useractivity::getFollowDetailByUserId($value->user_id,$userId);
				$value->follow = (count($followingDetails) && isset($followingDetails->status)) ? (int)($followingDetails->status) : 0 ;
				$value->is_following = $value->follow;
				$likeDetail = Useractivity::likeStatusByUserId($value->id,$userId);
				$value->liked = (count($likeDetail) && isset($likeDetail->status)) ? (int)($likeDetail->status) : 0 ;
				$value->shareUrl = UniversalClass::shareUrl($value->id);
			}
		}

        return response()->json($posts);
    }



}