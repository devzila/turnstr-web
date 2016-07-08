<?php namespace App\Http\Controllers\Admin;

use App\Models\Posts;
use App\Models\Report;
use Illuminate\Http\Request;
use Redirect;
use Session;


class ReportController extends Controller {
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

    public function index($postId){

        $data = array();
		
		$data['post']  = Posts::find($postId);
		
        $data['reports'] = Report::reportByPost($postId);
        return view("admin.reports.index",$data);

    }
}
