<?php

namespace App\Http\Controllers;

use App\Helpers\UniversalClass;
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
        $data['comments'] = Comments::commentsByPost($decryptedPostId);
        return view('share/index', $data);

    }
}
