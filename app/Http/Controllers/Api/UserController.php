<?php namespace App\Http\Controllers\Api;

use Config;

class UserController extends Controller {

    public function __construct()
    {

    }

    public function test(){
        return response()->json(['status' => 'OK']);
    }

}
