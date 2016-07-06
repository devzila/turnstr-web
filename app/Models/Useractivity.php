<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Useractivity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	const POSTS_PER_PAGE = 20;
    protected $table = 'user_activity';
    protected $fillable = [
        'user_id', 'follower_id', 'post_id', 'liked_id', 'activity', 'status','created_at'
    ];
    
    public function scopeGetLastTenActivity($query,$user_id,$page=0,$offset=self::POSTS_PER_PAGE) {

        return $query->where(function ($query) use ($user_id) {
           //$query->where('user_activity.user_id',$user_id)
                    $query->where('user_activity.follower_id','<>',$user_id)
                    ->where('user_activity.liked_id','<>',$user_id)
                    ->where('user_activity.user_id',$user_id)
                    ->where('user_activity.status',1);
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
                    'user_activity.status as activity_status','user_activity.created_at as activity_time')
			 ->skip($page * $offset)->take($offset)
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
    	$res = $query->where('activity','liked')->where('post_id',$post_id)->where('status',1)->count();
    	return ($res>0) ? $res : -1 ;
    }
	
	/*
	* Get Like Status of the Post by user id
    */
    public function scopeLikeStatusByUserId($query, $post_id,$userId) {
    	$res = $query
				->where('post_id',$post_id)
				->where('liked_id',$userId)->where('activity','liked')
				->select('status')
				->first();		
		return $res;
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
	
	/*
	* Get Followings Details
    */
    public function scopeGetFollowingByUserId($query, $user_id) {
        $res = $query->where('follower_id',$user_id)
                    ->where('activity','follow')
                    ->where('status',1)
                    ->leftjoin('users','user_activity.user_id','=','users.id')
                    ->select('users.*')
                    ->get();
        return $res;
    }
	
	public static function followUnfollowStatus($following_id,$followerId,$following_status){
		
		if($following_id == $followerId){
			return;
		}
		
		$alreadyFollowing = Useractivity::where('user_id',$following_id)->where('follower_id',$followerId)->where('activity','follow')->first();

        if (count($alreadyFollowing) && $alreadyFollowing->status != $following_status) {
            $updateArr = array(
                    'status'=>$following_status
                );
            Useractivity::where('user_id',$following_id)->where('follower_id',$followerId)->where('activity','follow')->update($updateArr);

            if ($following_status) {
                User::where('id',$followerId)->increment('following');
                User::where('id',$following_id)->increment('followers');
            } else {

                User::where('id',$followerId)->decrement('following');
                User::where('id',$following_id)->decrement('followers');
            }
            
        } else if (!count($alreadyFollowing)) {
            $insArr = array(
                    'user_id'=>$following_id,
                    'follower_id'=>$followerId,
                    'activity'=>'follow',
                    'status'=>1,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
                );
            Useractivity::insert($insArr);
            User::where('id',$followerId)->increment('following');
            User::where('id',$following_id)->increment('followers');
        }
		
	}
	
	
	public static function likeUnlikeStatus($post_id,$likedOf,$likedBy,$like_status){
		
		$alreadyLiked = Useractivity::where('post_id',$post_id)->where('liked_id',$likedBy)->where('activity','liked')->first();
        
        if (count($alreadyLiked) && $alreadyLiked->status != $like_status) {
            $updateArr = array(
                    'status'=>$like_status
                );
            Useractivity::where('post_id',$post_id)->where('liked_id',$likedBy)->where('activity','liked')->update($updateArr);
            if ($like_status==1) {
                Posts::where('id',$post_id)->increment('total_likes');
            } else if ($like_status==0) {
                Posts::where('id',$post_id)->decrement('total_likes');
            }
            
        } else if (!count($alreadyLiked)) {
            $insArr = array(
                    'user_id'=>$likedOf,
                    'liked_id'=>$likedBy,
                    'post_id'=>$post_id,
                    'activity'=>'liked',
                    'status'=>1,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
                );
			Posts::where('id',$post_id)->increment('total_likes');
            Useractivity::insert($insArr);
        }
		
	}
	
	
	
}
