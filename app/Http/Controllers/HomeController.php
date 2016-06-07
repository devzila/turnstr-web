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
}
