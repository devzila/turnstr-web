<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use Auth;
use Response;

class Controller extends BaseController
{
    public function __construct(){

    }

    protected function assertAdmin(){
        if(!Auth::user()->isAdmin()){
            abort(403);
        }
    }

}
