<?php namespace App\Http\Controllers;

use Config;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\User,App\Models\Posts,App\Models\Comments;
use App\Helpers\ResponseClass;
use App\Helpers\UniversalClass;
use Hash;
use Response;

class PostsController extends Controller {
    /**
     * The Http Request Object
     *
     * @var Object
     */
    protected $request;


    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index($post_id = null){
        //decrypted id
       // echo $post_id;die;
        $status = true;
        $postsData = Posts::getPostsById($post_id);
        if(!isset($postsData[0])){
            $status = false;
            $post_id = UniversalClass::decrypt($post_id);
            $postsData = Posts::getPostsById($post_id);
            $status =(!isset($postsData[0]))? false: true;
        }
        $data['comments'] = Comments::commentsByPost($post_id);
        if(!$status){
            echo "wrong id";die;
        } 
        $data['post'] = $postsData[0];
          return view('posts/post', $data);
    }
}
