<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $fillable = ['user_id','post_id','comments']; 

    public function scopeCommentsByPost($query, $post_id) {
    	return $query->where('post_id',$post_id)->join('users','comments.user_id','=','users.id')
    					->select('Comments.*','users.username','users.profile_image')->get();
    }

}
