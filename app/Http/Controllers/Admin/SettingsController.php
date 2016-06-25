<?php namespace App\Http\Controllers\Admin;

use App\Models\Posts;
use App\Models\Comments;
use App\Models\Settings;
use Illuminate\Http\Request;
use Redirect;
use Session;


class SettingsController extends Controller {
    /**
     * The Http Request Object
     *
     * @var Object
     */
    protected $request;


    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->assertAdmin();
    }

    public function index(){

        $data = array();
        $data['settings'] = Settings::all();
        return view("admin.settings.list",$data);

    }

    public function profane(){
		$profane_words = Settings::find(1);
		if(!$profane_words){
			$profane_words = new Settings;
			$profane_words->id = 1;
			$profane_words->profane_words = "";
			$profane_words->save();
		}
		$data['profane_words'] = ($profane_words)? $profane_words->profane_words:"";
		return view("admin.settings.profane",$data);
    }

	public function profaneUpdate(){
		$profaneWords = Settings::find(1);
		
		$profane_words_arr = explode(',',$this->request->get('profane_words'));
		$profane_words_string="";
		foreach ( $profane_words_arr as $pf){
			if(!trim($pf)) continue;
			$profane_words_string .= trim($pf).",";
		}
		$profane_words_string = rtrim($profane_words_string,',');	
		$profaneWords->profane_words = trim($profane_words_string);
		$profaneWords->save();
		Session::flash('success','Profane Updated Successfully');
		return redirect("admin/settings/profane");
    }



}
