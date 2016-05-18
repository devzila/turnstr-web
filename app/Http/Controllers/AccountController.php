<?php namespace App\Http\Controllers;

use Config;

use App\Http\Requests;
use Illuminate\Http\Request;
use Hash;
use Response;

class AccountController extends Controller {
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
        return view('accounts/index');
    }

}
