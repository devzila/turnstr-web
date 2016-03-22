<?php namespace App\Models;
class SessionUser
{
    public static $user;

    public static function set($user_id){
        self::$user = User::find($user_id);
    }

    public function get(){
        return self::$user;
    }

}
