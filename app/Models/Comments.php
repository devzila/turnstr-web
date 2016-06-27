<?php

namespace App\Models;
use App\Models\Settings;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{

    protected $table = 'comments';
    protected $fillable = ['user_id','post_id','approved','comments']; 
	
	public static function createComment($data){
		$comment = new Comments;
		
		$approved = Settings::profaneFilter($data['comments']);
		if($approved < 0) $approved = 0;
		$comment->user_id = $data['user_id'];
		$comment->post_id = $data['post_id'];
		$comment->comments = $data['comments'];
		$comment->approved = $approved;
		$comment->save();
		if($approved == 1){
			PostTags::tag($data['post_id'],$data['comments']);
		}
		return $comment;
	}
	
	
	public function scopeApproved($query)
    {
        return $query->where('approved', 1);
    }
	
    public function scopeCommentsByPost($query, $post_id,$record = "") {
    	$query->where('post_id',$post_id)->join('users','comments.user_id','=','users.id')
		->approved()
		->select('comments.*','users.username','users.profile_image','users.name','users.fb_token')->orderBy('comments.created_at','ASC');
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
                    ->select('comments.comments','comments.id','comments.approved','comments.created_at','posts.caption','users.name as user_name')
                    ->get();
    }

}
