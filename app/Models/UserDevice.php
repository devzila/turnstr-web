<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Rhumsaa\Uuid\Uuid;

class UserDevice extends Model
{
    protected $table = 'user_devices';

    protected $primaryKey = null;

    public $incrementing = false;

    protected $fillable = ['device_id', 'os_type', 'os_version','hardware','app_verison','user_id','access_token'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public static function add($user, $deviceInfo){
        $device = self::where('device_id', '=', $deviceInfo['device_id'])
            ->where('user_id', '=', $user->id)
            ->first();

        // device session is already there
        // return existing token
        if($device){
            $user->id = (string)($user->id);
            $user->following = (string)($user->following);
            $user->followers = (string)($user->followers);
            $device->user = $device->user;
            return $device;
        }

        // create access token for device
        $device = self::create([
            'device_id' => $deviceInfo['device_id'],
            'os_type' => $deviceInfo['os_type'],
            'os_version' => $deviceInfo['os_version'],
            'hardware' => $deviceInfo['hardware'],
            'app_version' => $deviceInfo['app_version'],
            'user_id' => $user->id,
            'access_token' => Uuid::uuid1()->toString()
        ]);
        if($device){
            $user->id = (string)($user->id);
            $user->following = (string)($user->following);
            $user->followers = (string)($user->followers);
            $device->user = $device->user;
            return $device;
        }
    }

    public static function remove($token){
        return self::where('access_token', '=', $token)
            ->delete();
    }
}