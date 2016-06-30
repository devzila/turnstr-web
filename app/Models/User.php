<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username','fb_token','gender','profile_thumb_image','profile_image',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function devices()
    {
        return $this->hasMany('App\Models\UserDevice');
    }
    /*
    * token based on access_token
    */
    public function scopeUserDetails($query, $access_token='')
    {
        return UserDevice::where('access_token',$access_token)
                            ->join('users','user_id','=','users.id')->first();
    }

    public function isAdmin(){
        return strtolower($this->role) == 'admin';
    }

    public function scopeFollowers($query, $page = 0,  $records = 10){
        $userId = $this->id;
        return $query
            ->whereIn('id', function($subQuery) use($userId)
            {
                $subQuery->select('follower_id')
                    ->from('user_activity')
                    ->where('user_id', $userId)
                    ->where('activity','follow')
                    ->where('status',1);
            })
            ->skip($page * $records)
            ->take($records)
            ->get();

    }

    public function scopeFollowings($query, $page = 0,  $records = 10){
        $userId = $this->id;
        return $query
            ->whereIn('id', function($subQuery) use($userId)
            {
                $subQuery->select('user_id')
                    ->from('user_activity')
                    ->where('follower_id', $userId)
                    ->where('activity','follow')
                    ->where('status',1);
            })
            ->skip($page * $records)
            ->take($records)
            ->get();

    }

    public static function createByFacebook($params){
        $user = new User();
        $user->email = $params['email'];
        $user->name = $params['first_name'] . ' ' . $params['last_name'];
        $user->fb_token = $params['id'];
        $user->profile_thumb_image = "http://graph.facebook.com/".$params['id']."/picture?type=normal";
        $user->profile_image = "http://graph.facebook.com/".$params['id']."/picture?type=large";

        $user->save();
		if($user){
            // Auto follow turnstr
            $autofollow = array(
                'user_id' => env('TURNSTR_USER_ID', 2),
                'follower_id' => $user->id,
                'activity' => 'follow',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            Useractivity::insert($autofollow);
			$user->following = 1;
			$user->save();                    
        } 
        return $user;
    }


}
