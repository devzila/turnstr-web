<?php namespace App\Http\Controllers\Admin;
use App\Http\Requests;
use Illuminate\Http\Request;


class HomeController extends Controller {
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

        return view('admin/index');

    }

}
