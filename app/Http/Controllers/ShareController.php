<?php

namespace App\Http\Controllers;

use App\Helpers\UniversalClass;
use App\Models\User;
use App\Models\Posts;
use App\Models\Comments;

class ShareController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $decryptedPostId = UniversalClass::decrypt($id);

        $data['post'] = Posts::find($decryptedPostId);
		$user_id = $data['post']->user_id;
		
		$data['userdetail'] = User::find($user_id);
		
        $data['comments'] = Comments::commentsByPost($decryptedPostId);
        return view('share/index', $data);

    }
}
