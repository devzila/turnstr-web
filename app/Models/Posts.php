<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $fillable = ['user_id', 'caption', 'media1_url','media2_url','media3_url','media4_url', 'media1_thumb_url', 'media2_thumb_url', 'media3_thumb_url', 'media4_thumb_url'];

    /*
    * Function to search and returns images data
    */
	public function scopeGetImages($query, $searchData='')
    {
    	$returnData = $query->leftjoin('users','posts.user_id','=','users.id');

    	if ($searchData!='') {
    		$returnData->where('username','like','%'.$searchData.'%');
    	}

    		return	$returnData->groupBy('posts.user_id')
                    ->select('users.username','posts.user_id','users.name','posts.id','posts.media1_thumb_url','posts.media2_thumb_url','posts.media3_thumb_url','posts.media4_thumb_url','posts.media4_url','posts.media1_url','posts.media2_url','posts.media3_url','posts.updated_at','posts.created_at','posts.caption')
    				->orderBy('posts.updated_at','desc')
    				->get();
    }


}
