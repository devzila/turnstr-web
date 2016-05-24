<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Helpers\UniversalClass;

class Posts extends Model
{
    const POSTS_PER_PAGE = 10;
    protected $fillable = ['user_id', 'caption', 'media1_url','media2_url','media3_url','media4_url', 'media1_thumb_url', 'media2_thumb_url', 'media3_thumb_url', 'media4_thumb_url'];
    /*
    * Function to search and returns images data
    */

    static function addExtraAttributes($posts){
        if(is_array($posts)){
            $touchedPosts = [];
            foreach($posts as $post){
                $touchedPosts[] = self::addExtraFields($post);
            }

            return $touchedPosts;

        }
        else{
            return self::addExtraFields($posts);
        }
    }
    /*
    * Function to return posts by user id
    */

    static function addExtraFields($post)
    {
        for($i = 1; $i<=4; $i++){
            $newProp = "media".$i."_type";
            $mediaProp = "media" . $i . "_url";
            $post->$newProp = pathinfo($post->$mediaProp, PATHINFO_EXTENSION);
        }

        $post->shareUrl = UniversalClass::shareUrl($post->id);

        // TODO: figure out actual value for following attributes
        $post->liked = null;
        $post->follow = null;

        return $post;
    }

    /*
    * Function to return posts for home page
    * Posts current user is following
    */ 

    public function scopeGetImages($query,$userId='', $searchData='')
    {
        $returnData = $query->join('users','posts.user_id','=','users.id');

        if ($searchData!='') {
            $returnData->where('username','like','%'.$searchData.'%');
        }
        if ($userId!='') {
            $returnData->where('users.id','!=',$userId)
                    ->select('users.username','posts.user_id','users.name','users.profile_image','posts.id','posts.media1_thumb_url','posts.media2_thumb_url','posts.media3_thumb_url','posts.media4_thumb_url','posts.media4_url','posts.media1_url','posts.media2_url','posts.media3_url','posts.updated_at','posts.created_at','posts.total_likes','posts.caption','postData.status as liked','followData.status as follow')
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
            $returnData->select('users.username','posts.user_id','users.name','posts.total_likes','users.profile_image','posts.id','posts.media1_thumb_url','posts.media2_thumb_url','posts.media3_thumb_url','posts.media4_thumb_url','posts.media4_url','posts.media1_url','posts.media2_url','posts.media3_url','posts.updated_at','posts.created_at','posts.caption');
        }

            return  $returnData
                    ->orderBy('posts.updated_at','desc')
                    ->get();
    }
    /*
    * Function to return posts by a user
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
    * Function to return posts by a user
    */

    public function scopeGetPostsUserFollowing($query, $userId='')
    {
        $returnData = $query->join('users','posts.user_id','=','users.id');

        if ($userId!='') {
            $returnData->where('users.id','!=',$userId)
                    ->select('users.username','posts.user_id','users.profile_image','users.name','posts.total_likes','posts.id','posts.media1_thumb_url','posts.media2_thumb_url','posts.media3_thumb_url','posts.media4_thumb_url','posts.media4_url','posts.media1_url','posts.media2_url','posts.media3_url','posts.updated_at','posts.created_at','posts.caption','postData.status as liked','followData.status as is_following')
                    ->leftjoin('user_activity as postData',function($join) use ($userId) {
                        $join->where('postData.activity','=','liked');
                        $join->where('postData.liked_id','=',$userId);
                        $join->on('postData.post_id','=','posts.id');
                    })
                    ->join('user_activity as followData',function($join) use ($userId)  {
                        $join->where('followData.activity','=','follow');
                        $join->where('followData.follower_id','=',$userId);
                        $join->on('followData.user_id','=','users.id');
                    })->distinct('posts.id');
        } else {
            $returnData->select('users.username','posts.user_id','users.name','posts.id','posts.total_likes','posts.media1_thumb_url','posts.media2_thumb_url','posts.media3_thumb_url','posts.media4_thumb_url','posts.media4_url','posts.media1_url','posts.media2_url','posts.media3_url','posts.updated_at','posts.created_at','posts.caption');
        }

            return  $returnData
                    ->orderBy('posts.updated_at','desc')
                    ->get();
    }

    /*
    * Function to return posts by id
    */

    public function scopeSelfPosts($query, $userId='')
    {
        return $query->join('users','posts.user_id','=','users.id')
                    ->where('users.id',$userId)
                     ->select('users.username','posts.user_id','users.profile_image','users.name','posts.total_likes','posts.id','posts.media1_thumb_url','posts.media2_thumb_url','posts.media3_thumb_url','posts.media4_thumb_url','posts.media4_url','posts.media1_url','posts.media2_url','posts.media3_url','posts.updated_at','posts.created_at','posts.caption','postData.status as liked','followData.status as is_following')
                    ->leftjoin('user_activity as postData',function($join) use ($userId) {
                        $join->where('postData.activity','=','liked');
                        $join->where('postData.liked_id','=',$userId);
                        $join->on('postData.post_id','=','posts.id');
                    })
                    ->leftjoin('user_activity as followData',function($join) use ($userId)  {
                        $join->where('followData.activity','=','follow');
                        $join->where('followData.follower_id','=',$userId);
                        $join->on('followData.user_id','=','users.id');
                    })->distinct('posts.id')->orderBy('posts.updated_at','desc')
                    ->get();
    }

	public function scopeHomePagePosts($query, $userId='',$page=0)
    {
        $first = DB::table('posts')->join('users','posts.user_id','=','users.id')->where('users.id','!=',$userId)
                    ->select('users.username','posts.user_id','users.profile_image','users.name','posts.total_likes','posts.id','posts.media1_thumb_url','posts.media2_thumb_url','posts.media3_thumb_url','posts.media4_thumb_url','posts.media4_url','posts.media1_url','posts.media2_url','posts.media3_url','posts.updated_at','posts.created_at','posts.caption','postData.status as liked','followData.status as is_following')
                    ->leftjoin('user_activity as postData',function($join) use ($userId) {
                        $join->where('postData.activity','=','liked');
                        $join->where('postData.liked_id','=',$userId);
                        $join->on('postData.post_id','=','posts.id');
                    })
                    ->join('user_activity as followData',function($join) use ($userId)  {
                        $join->where('followData.activity','=','follow');
                        $join->where('followData.follower_id','=',$userId);
                        $join->on('followData.user_id','=','users.id');
                    })->distinct('posts.id');
        $finalContainer = DB::table('posts')->join('users','posts.user_id','=','users.id')
                    ->where('users.id',$userId)
                     ->select('users.username','posts.user_id','users.profile_image','users.name','posts.total_likes','posts.id','posts.media1_thumb_url','posts.media2_thumb_url','posts.media3_thumb_url','posts.media4_thumb_url','posts.media4_url','posts.media1_url','posts.media2_url','posts.media3_url','posts.updated_at','posts.created_at','posts.caption','postData.status as liked','followData.status as is_following')
                    ->leftjoin('user_activity as postData',function($join) use ($userId) {
                        $join->where('postData.activity','=','liked');
                        $join->where('postData.liked_id','=',$userId);
                        $join->on('postData.post_id','=','posts.id');
                    })
                    ->leftjoin('user_activity as followData',function($join) use ($userId)  {
                        $join->where('followData.activity','=','follow');
                        $join->where('followData.follower_id','=',$userId);
                        $join->on('followData.user_id','=','users.id');
                    })->distinct('posts.id')->orderBy('posts.updated_at','desc')->union($first)
                        ->skip($page * self::POSTS_PER_PAGE)->take(self::POSTS_PER_PAGE)
                        ->get();
                    return  $finalContainer;
    }
    /*
    * Function to return all posts of a user by user id
    */

    public function scopeGetPostsById($query, $post_id='')
    {
        return $query->select('posts.user_id','posts.id','posts.media1_thumb_url','posts.media2_thumb_url','posts.media3_thumb_url','posts.media4_thumb_url','posts.media4_url','posts.media1_url','posts.media2_url','posts.media3_url','posts.created_at','posts.updated_at')
                    ->where('posts.id','=',$post_id)
                    ->orderBy('posts.updated_at','desc')
                    ->get();
    }

    public function scopeGetPostDetails($query,$post_id){
//        echo $post_id;die;
        return $query
                 ->leftjoin('user_activity',function($join) {
                        $join->where('user_activity.activity','=','follow');
                        $join->where('user_activity.follower_id','=',DeviceSession::get()->user->id);
                        $join->on('posts.user_id','=','user_activity.user_id');
                    })
                  ->where('posts.id','=',$post_id)
                 ->select('posts.*','user_activity.status as is_following')->first();
                    
    }

    public function scopeGetAllPostsByUserId($query, $user_id='')
    {
        return $query->where('user_id',$user_id)->get();
    }

    // Web app functions

    /*
    * Function to fetch all posts
    */

    public function scopeGetAllPosts($query)
    {
        return $query
                    ->leftjoin('users','posts.user_id','=','users.id')
                    ->select('posts.*','users.name')
                    ->get();
    }

}
