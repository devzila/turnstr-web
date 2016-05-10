<?php namespace App\Http\Controllers;

use Config;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\ResponseClass;
use Hash;
use Response;

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

        return view('home');

    }

}
