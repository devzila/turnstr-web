<?php namespace App\Http\Controllers\Admin;
use App\Http\Requests;
use App\Models\Posts;
use App\Models\Comments;
use Illuminate\Http\Request;
use Redirect;
use Session;


class PostController extends Controller {
    /**
     * The Http Request Object
     *
     * @var Object
     */
    protected $request;


    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->assertAdmin();
    }

    public function index(){

        $data = array();
        $data['all_posts'] = Posts::getAllPosts();
        return view('admin/posts',$data);

    }

    public function edit($post_id){

        $data = array();
        $data['post_details'] = Posts::find($post_id);
        return view("admin/editposts");

    }

    public function destroy($post_id){

        $post = Posts::find($post_id);
        $post->delete();
        Session::flash('success','Post Deleted Successfully');
        return redirect("admin/posts");

    }

    public function postcomment($post_id){

        $data = array();
        $data['post_details'] = Posts::find($post_id);
        $data['all_comments'] = Comments::commentsByPost($post_id);
        return view("admin/postcomments",$data);

    }

}
