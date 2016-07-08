<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Helpers\UniversalClass;

class Report extends Model
{
    const POSTS_PER_PAGE = 10;
    protected $table = 'report';
	
	static function scopeGetReportCountByPost($query,$postId){
		$res = $query->where('post_id',$postId)->count();
        return ($res>0) ? $res : -1 ;
	}
	
	static function scopeReportByPost($query,$postId){
		return $query->where('post_id',$postId)
				->leftJoin('users','report.user_id','=','users.id')
				->select('report.*','users.name','users.username')
				->get();
	}

}

?>