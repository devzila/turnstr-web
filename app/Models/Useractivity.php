<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Useractivity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'user_activity';
    protected $fillable = [
        'user_id', 'follower_id', 'post_id', 'liked_id', 'activity', 'status'
    ];

    public function scopeGetLastTenActivity($query,$user_id) {

        return $query->where(function ($query) use ($user_id) {
           $query->where('user_activity.user_id',$user_id)
                    ->orWhere('user_activity.follower_id',$user_id)
                    ->orWhere('user_activity.liked_id',$user_id);
        })
        ->leftjoin('posts as postData',function($join) {
            $join->where('user_activity.activity','=','liked');
            $join->on('user_activity.post_id','=','postData.id');
        })
        ->leftjoin('users as followData',function($join) {
            $join->where('user_activity.activity','=','follow');
            $join->on('user_activity.user_id','=','followData.id');
        })
            ->leftjoin('users as followingUser','user_activity.user_id','=','followingUser.id') // who is being followed
            ->leftjoin('users as followerUser','user_activity.follower_id','=','followerUser.id') // who is following
            ->leftjoin('users as likeUser','user_activity.liked_id','=','likeUser.id') // who liked the post
            ->leftjoin('users as likeofUser','user_activity.user_id','=','likeofUser.id') // whom post is liked
            ->orderBy('user_activity.updated_at','DESC')
            ->select('user_activity.activity','followerUser.name as follower_name','followerUser.id as follower_id','followerUser.profile_image as follower_image','followingUser.name as following_name','likeUser.name as likedby_name','likeUser.id as likedby_id','likeUser.profile_image as likedby_image','likeofUser.name as likedof_name','user_activity.status','postData.media1_url','followData.profile_image')
                        ->get();

    }

    /*
    * Get user like/unlike details by post and user id
    */
    public function scopeGetActivityById($query,$userId,$postId) {
        return $query->where('post_id',$postId)->where('liked_id',$userId)->where('activity','liked')->select('status');
    }

}
