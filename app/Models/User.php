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
        'name', 'email', 'password', 'username',
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



}
