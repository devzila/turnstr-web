<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Posts extends Model
{
    protected $fillable = ['user_id', 'caption', 'media1_url','media2_url','media3_url','media4_url', 'media1_thumb_url', 'media2_thumb_url', 'media3_thumb_url', 'media4_thumb_url'];
    /*
    * Function to search and returns images data
    */
    public function scopeGetImages($query,$userId='', $searchData='')
    {
        $returnData = $query->join('users','posts.user_id','=','users.id');

        if ($searchData!='') {
            $returnData->where('username','like','%'.$searchData.'%');
        }
        if ($userId!='') {
            $returnData->where('users.id','!=',$userId)
                    ->select('users.username','posts.user_id','users.name','posts.id','posts.media1_thumb_url','posts.media2_thumb_url','posts.media3_thumb_url','posts.media4_thumb_url','posts.media4_url','posts.media1_url','posts.media2_url','posts.media3_url','posts.updated_at','posts.created_at','posts.caption','postData.status as liked','followData.status as follow')
                    ->leftjoin('user_activity as postData',function($join) use ($userId) {
                        $join->where('postData.activity','=','liked');
                        $join->where('postData.liked_id','=',$userId);
                        $join->on('postData.post_id','=','posts.id');
                    })
                    ->leftjoin('user_activity as followData',function($join) use ($userId)  {
                        $join->where('followData.activity','=','follow');
                        $join->where('followData.follower_id','=',$userId);
                        $join->on('followData.user_id','=','users.id');
                    })->distinct('posts.id');
        } else {
            $returnData->select('users.username','posts.user_id','users.name','posts.id','posts.media1_thumb_url','posts.media2_thumb_url','posts.media3_thumb_url','posts.media4_thumb_url','posts.media4_url','posts.media1_url','posts.media2_url','posts.media3_url','posts.updated_at','posts.created_at','posts.caption');
        }

            return  $returnData
                    ->orderBy('posts.updated_at','desc')
                    ->get();
    }
    /*
    * Function to return posts by user id
    */
    public function scopeGetPostsByUserId($query, $user_id='')
    {
        $returnData = $query->join('users','posts.user_id','=','users.id');

        if ($userId!='') {
            $returnData->where('users.id','!=',$userId)
                    ->select('users.username','posts.user_id','users.profile_image','users.name','posts.id','posts.media1_thumb_url','posts.media2_thumb_url','posts.media3_thumb_url','posts.media4_thumb_url','posts.media4_url','posts.media1_url','posts.media2_url','posts.media3_url','posts.updated_at','posts.created_at','posts.caption','postData.status as liked','followData.status as follow')
                    ->leftjoin('user_activity as postData',function($join) use ($userId) {
                        $join->where('postData.activity','=','liked');
                        $join->where('postData.liked_id','=',$userId);
                        $join->on('postData.post_id','=','posts.id');
                    })
                    ->leftjoin('user_activity as followData',function($join) use ($userId)  {
                        $join->where('followData.activity','=','follow');
                        $join->where('followData.follower_id','=',$userId);
                        $join->on('followData.user_id','=','users.id');
                    })->distinct('posts.id');
        } else {
            $returnData->select('users.username','posts.user_id','users.name','posts.id','posts.media1_thumb_url','posts.media2_thumb_url','posts.media3_thumb_url','posts.media4_thumb_url','posts.media4_url','posts.media1_url','posts.media2_url','posts.media3_url','posts.updated_at','posts.created_at','posts.caption');
        }

            return  $returnData
                    ->orderBy('posts.updated_at','desc')
                    ->get();
    }

    /*
    * Function to return posts for home page
    * Posts current user is following
    */
    public function scopeGetPostsUserFollowing($query, $userId='')
    {
        $returnData = $query->join('users','posts.user_id','=','users.id');

        if ($userId!='') {
            $returnData->where('users.id','!=',$userId)
                    ->select('users.username','posts.user_id','users.profile_image','users.name','posts.id','posts.media1_thumb_url','posts.media2_thumb_url','posts.media3_thumb_url','posts.media4_thumb_url','posts.media4_url','posts.media1_url','posts.media2_url','posts.media3_url','posts.updated_at','posts.created_at','posts.caption','postData.status as liked','followData.status as follow')
                    ->leftjoin('user_activity as postData',function($join) use ($userId) {
                        $join->where('postData.activity','=','liked');
                        $join->where('postData.liked_id','=',$userId);
                        $join->on('postData.post_id','=','posts.id');
                    })
                    ->leftjoin('user_activity as followData',function($join) use ($userId)  {
                        $join->where('followData.activity','=','follow');
                        $join->where('followData.follower_id','=',$userId);
                        $join->on('followData.user_id','=','users.id');
                    })->distinct('posts.id');
        } else {
            $returnData->select('users.username','posts.user_id','users.name','posts.id','posts.media1_thumb_url','posts.media2_thumb_url','posts.media3_thumb_url','posts.media4_thumb_url','posts.media4_url','posts.media1_url','posts.media2_url','posts.media3_url','posts.updated_at','posts.created_at','posts.caption');
        }

            return  $returnData
                    ->orderBy('posts.updated_at','desc')
                    ->get();
    }
    /*
    * Function to return posts by a user
    */
	public function scopeFollowPosts($query, $user_id='')
    {
        return $query->where('user_id',$user_id)
                    ->join('users','posts.user_id','=','users.id')
                    // ->select('posts.*','users.following','users.followers')
                    ->select('posts.*')
                     ->get();
    }

    /*
    * Function to return posts by id
    */
    public function scopeGetPostsById($query, $post_id='')
    {
        return $query->select('posts.user_id','posts.id','posts.media1_thumb_url','posts.media2_thumb_url','posts.media3_thumb_url','posts.media4_thumb_url','posts.media4_url','posts.media1_url','posts.media2_url','posts.media3_url','posts.created_at','posts.updated_at')
                    ->where('posts.id','=',$post_id)
                    ->orderBy('posts.updated_at','desc')
                    ->get();
    }

}
