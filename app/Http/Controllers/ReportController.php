<?php namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Posts;
use Auth;
use Illuminate\Http\Request;
 /**
 * User Activity Class Web
 *
 * 
 */

class ReportController extends Controller {
	
	public function __construct(Request $request){
		$this->request = $request;
	}
   
	public function markInappropriatePost($postId) {
		
		if(!isset(Auth::user()->id) || empty($postId)){			
			$response = [ 'status'=>3,'msg'=>"Please Login to mark this Inapprpriate"];
			return response()->json($response,200);
		}
		
		$markedBy = Auth::user()->id;
		
		$reportDetail = Report::where('post_id',$postId)->where('user_id',$markedBy)->first();
		if(!$reportDetail){
			$report = new Report;
			$report->user_id = $markedBy;
			$report->post_id = $postId;
			$report->content = $this->request->get('optinapp');
			$report->save();			
			$msg = "Thanks for Reporting";
		}else{			
			$msg = "You have Already Marked this as inappropriate.";
		}		
        
		$response = [ 'status'=>1,'msg'=>$msg];
		return response()->json($response,200);
        
    }
	

	
}



