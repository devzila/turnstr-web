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
		$pageTitle = "Home";
		
		if(empty(Input::get('jsonp'))){
			return view('home', ['page_title'=>$pageTitle]);
		}
		$page = Input::get('page', 0);
		$userId = Auth::user()->id;		
        $posts = Posts::GetUserHomePosts($userId,$page);
		
		if (count($posts)) {
            foreach ($posts as $key => $value) {
				$value->comments = Comments::commentsByPost($value->id,0,2,"DESC");
                $commentsCount = Comments::commentsCountByPostId($value->id);                
				$commentsCount = ($commentsCount==-1)?0:$commentsCount;
                $value->total_comments = (string)($commentsCount);
				//$value->total_likes = ($value->total_likes==-1)?0:$value->total_likes;
				$total_likes = Useractivity::likeCountByPostId($value->id);
                $value->total_likes = (string)(($total_likes>0)?$total_likes:0);
				$value->shareUrl = UniversalClass::shareUrl($value->id);
				$value->caption = UniversalClass::replaceTagMentionLink($value->caption);
            }
        }
		
		return response()->json($posts);
        //return view('home', ['posts' => $posts,'page_title'=>$pageTitle]);
    }
	
	
	public function explore()
    {
		$pageTitle = "Explore";
        $searchData = Input::get('searchData');
        
        if(empty(Input::get('jsonp'))){
			return view('discover', ['page_title'=>$pageTitle]);
		}
		$page = Input::get('page', 0);
        
        $userId = Auth::user()->id;
        
        $imagesToExplore = Posts::getImages($userId,$searchData,$page);

        foreach ($imagesToExplore as $key => $value) {
                       
			$imagesToExplore[$key]->is_following = ($value->follow > 0) ? (int)($value->follow) : 0;
			
            // getting comments count
            $commentsCount = comments::commentsCountByPostId($value->id);
            $imagesToExplore[$key]->comments_count = ($commentsCount > 0) ? (string)($commentsCount) : "0" ;
            // total likes converting to string
            $imagesToExplore[$key]->total_likes = ($value->total_likes > 0) ? (string)($value->total_likes):"0";
            $imagesToExplore[$key]->shareUrl = UniversalClass::shareUrl($value->id);
        }
        return response()->json($imagesToExplore);
        //return view('discover', ['posts'=>$imagesToExplore,'page_title'=>$pageTitle]);
    }

	public function deletePost($postId)
    {
		
		if(!isset(Auth::user()->id)){
			
			$response = [ 'status'=>3,'msg'=>"Please Login"];
			return response()->json($response,200);
		}
		
		$userId = Auth::user()->id;
		
		$postFind = Posts::find($postId);
		if(!$postId){
			$response = [ 'status'=>2,'msg'=>"Your Post is Already Deleted"];
			return response()->json($response,200);
		}
			
        $post = Posts::where('id',$postId)->where('user_id', '=', Auth::user()->id)->delete();

		$response = [ 'status'=>1,'msg'=>"Your Post Deleted successfuly"];
		return response()->json($response,200);
    }
	
}
