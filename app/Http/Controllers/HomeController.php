<?php

namespace App\Http\Controllers;
use Illuminate\View\Middleware\ErrorBinder;
use App\Http\Requests;
use Hash;
use Response;
use App\Models\Posts;
use App\Models\Comments;
use App\Models\Useractivity;
use Auth;
use Input;
use App\Helpers\UniversalClass;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$userId = Auth::user()->id;
        $posts = Posts::GetUserHomePosts($userId);
		
		if (count($posts)) {
            foreach ($posts as $key => $value) {
				$value->comments = Comments::commentsByPost($value->id,2);
                $commentsCount = Comments::commentsCountByPostId($value->id);                
				$commentsCount = ($commentsCount==-1)?0:$commentsCount;
                $value->total_comments = (string)($commentsCount);
				$value->total_likes = ($value->total_likes==-1)?0:$value->total_likes;			
            }
        }
		
		
        return view('home', ['posts' => $posts]);
    }
	
	
	public function discover()
    {
        $searchData = Input::get('searchData');
        $userId = Auth::user()->id;
        
        $imagesToExplore = Posts::getImages($userId,$searchData);

        foreach ($imagesToExplore as $key => $value) {
            $arr1 = explode('.',$value->media1_url);
            $arr2 = explode('.',$value->media2_url);
            $arr3 = explode('.',$value->media3_url);
            $arr4 = explode('.',$value->media4_url);
            $imagesToExplore[$key]->media1_type = end($arr1);
            $imagesToExplore[$key]->media2_type = end($arr2);
            $imagesToExplore[$key]->media3_type = end($arr3);
            $imagesToExplore[$key]->media4_type = end($arr4);
            
			$imagesToExplore[$key]->is_following = ($value->follow > 0) ? (int)($value->follow) : 0;
			
            // getting comments count
            $commentsCount = comments::commentsCountByPostId($value->id);
            $imagesToExplore[$key]->comments_count = ($commentsCount > 0) ? (string)($commentsCount) : "0" ;
            // total likes converting to string
            $imagesToExplore[$key]->total_likes = ($value->total_likes > 0) ? (string)($value->total_likes):"0";
            $imagesToExplore[$key]->shareUrl = UniversalClass::shareUrl($value->id);
        }

        return view('discover', ['posts'=>$imagesToExplore]);
    }

	
	
}
