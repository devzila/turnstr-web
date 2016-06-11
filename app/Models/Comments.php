<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{

    protected $table = 'comments';
    protected $fillable = ['user_id','post_id','comments']; 

    public function scopeCommentsByPost($query, $post_id,$record = "") {
    	$query->where('post_id',$post_id)->join('users','comments.user_id','=','users.id')
    		  ->select('comments.*','users.username','users.profile_image')->orderBy('comments.created_at','DESC');
		if(!empty($record)){
			$query->take($record);
		}
		return $query->get();
    }
    /*
    * Get comments count by post id
    */
    public function scopeCommentsCountByPostId($query, $post_id) {
        $res = $query->where('post_id',$post_id)->count();
        return ($res>0) ? $res : -1 ;
    }
    /*
	* Get all comments 
    */
    public function scopeAllComments($query) {
    	return $query->leftjoin('posts','comments.post_id','=','posts.id')
                    ->leftjoin('users','comments.user_id','=','users.id')
                    ->select('comments.comments','comments.created_at','posts.caption','users.name as user_name')
                    ->get();
    }

}
