<?php namespace App\Models;
class DeviceSession
{
    public static $session;

    public static function set($device){
        self::$session = $device;
    }

    public static function get(){
        return self::$session;
    }

}
