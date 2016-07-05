<?php namespace App\Http\Controllers\Admin;
use App\Http\Requests;
use App\Models\Posts;
use App\Models\Comments;
use App\Models\Report;
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
        $posts = Posts::getAllPosts();
		foreach($posts as $key=>$value){
			$report = Report::getReportCountByPost($value->id);
			$value->report_count = ($report>0)?$report:0;
		}
		$data['all_posts'] = $posts;
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
	public function activate(){

        $post_id = $this->request->get('apprId');
		
		$status = ($this->request->get('status')) ? $this->request->get('status') : 0;
		
		$post = Posts::find($post_id);
		
		if($post && $post->active != $status){
			$post->active = $status;
			$post->save();
			return response()->json(['status'=>1,'msg'=>'Successfully Updated']);
		}
		return response()->json(['status'=>0,'msg'=>'Successfully Updated']);

    }

}
