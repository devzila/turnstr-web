<?php namespace App\Http\Controllers\Admin;
use App\Http\Requests;
use App\Models\Posts;
use App\Models\Comments;
use Illuminate\Http\Request;
use Redirect;
use Session;


class CommentsController extends Controller {
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
        $data['all_comments'] = Comments::allComments();
        return view("admin/listcomments",$data);

    }

    public function edit($post_id){


    }

    public function show($post_id){

        $data = array();
        $data['post_details'] = Posts::find($post_id);
        $data['all_comments'] = Comments::commentsByPost($post_id);
        return view("admin/postcomments",$data);

    }

    public function destroy($comment_id){
        $comment = Comments::find($comment_id);
        $comment->delete();
        Session::flash('success','Comment Deleted Successfully');
        return redirect("admin/comments");
    }

}
