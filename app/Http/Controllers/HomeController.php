<?php

namespace App\Http\Controllers;
use Illuminate\View\Middleware\ErrorBinder;
use App\Http\Requests;
use Hash;
use Response;
use App\Models\Posts;
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
        $posts = Posts::GetUserHomePosts(Auth::user()->id);
        return view('home', ['posts' => $posts]);
    }
}
