<?php namespace App\Http\Controllers\Admin;
use App\Http\Requests;
use App\Models\User;
use App\Models\Comments;
use Illuminate\Http\Request;
use Redirect;
use Session;


class UserController extends Controller {
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

    public function index(){

        $data = array();
        $data['all_users'] = User::get();
        return view('admin/listUsers',$data);

    }

}
