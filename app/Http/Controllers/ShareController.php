<?php

namespace App\Http\Controllers;

use App\Helpers\UniversalClass;
use App\Models\Posts;

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

        $post = Posts::find($decryptedPostId);



        var_dump($post->user);
        die;

    }
}
