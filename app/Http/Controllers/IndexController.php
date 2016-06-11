<?php
namespace App\Http\Controllers;
use App\Http\Requests;

class IndexController extends Controller
{


    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('landing');
    }
}
