<?php namespace App\Http\Controllers\Api;

use Config;

use App\Models\DeviceSession;

class UserController extends Controller {

    public function __construct()
    {

    }

    public function test(){
        return response()->json(DeviceSession::get()->user);
    }

}
