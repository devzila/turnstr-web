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
            ->select('post_id as turn_id','user_activity.id as activity_id','user_activity.activity','user_activity.status',
                    'followerUser.name as follower_name','followerUser.id as follower_id',
                    'followerUser.profile_image as follower_image','followingUser.name as following_name',
                    'likeUser.name as likedby_name','likeUser.id as likedby_id',
                    'likeUser.profile_image as likedby_image','likeofUser.name as likedof_name',
                    'user_activity.status as activity_status')
                        ->get();

    }
//
//    /*
//    * Get user like/unlike details by post and user id
//    */
//    public function scopeGetActivityById($query,$userId,$postId) {
//        return $query->where('post_id',$postId)->where('liked_id',$userId)
//                ->where('activity','liked')->select('status')->first();
//    }
    /*
    * Get user like/unlike details by post and user id
    */
    public function scopeIsUserFollowing($query,$post_owner_id,$user_id) {
        return $query->where('user_id',$post_owner_id)->where('follower_id',$user_id)
                ->where('activity','follow')->select('status')->first();
    }
    public function scopeGetActivityById($query,$userId,$postId) {
        return $query->where('post_id',$postId)->where('liked_id',$userId)->where('activity','liked')
                ->select('status')->first();
    }
    /*
    * Get user follow/unfollow details by post id
    */
    public function scopeGetFollowingStatusByPostId($query,$postId) {
        return $query->where('post_id',$postId)->where('activity','follow')
                ->select('status')->get();
    }
    /*
    * Get user follwoing status
    */
    public function scopeGetFollowDetailByUserId($query,$followingId,$currentuserId) {
        return $query->where('user_id',$followingId)->where('follower_id',$currentuserId)->where('activity','follow')->first();
    }
    /*
	* Get comments count by post id
    */
    public function scopeLikeCountByPostId($query, $post_id) {
    	$res = $query->where('activity','liked')->where('post_id',$post_id)->count();
    	return ($res>0) ? $res : -1 ;
    }
    /*
	* Get Followers Details
    */
    public function scopeGetFollowersByUserId($query, $user_id) {
        $res = $query->where('user_id',$user_id)
                    ->where('activity','follow')
                    ->where('status',1)
                    ->leftjoin('users','user_activity.follower_id','=','users.id')
                    ->select('users.*')
                    ->get();
        return $res;
    }
}
