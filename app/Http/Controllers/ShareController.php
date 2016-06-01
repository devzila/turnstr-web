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
        $extensionArr = array('mov','mp4');

        for ($i=0;$i<=4;$i++) {
            $mediaurl = "media".$i."_url";
            $mediatype = "media".$i."_type";
            if (isset($data['post']->$mediaurl)) {
                $arr = explode('.',$data['post']->$mediaurl);
                $arrLength = count($arr);

                if (in_array($arr[$arrLength-1], $extensionArr)) {
                    $data['post']->$mediatype = 'video';
                } else {
                    $data['post']->$mediatype = 'image';
                }
            }
        }

        return view('share/index', $data);

    }
}
