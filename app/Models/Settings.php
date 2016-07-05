<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Helpers\UniversalClass;

class Settings extends Model
{
	public $timestamps = false;
    protected $table = 'settings';
	
	public static function scopeProfaneFilter($query,$sentance){
		$profaneStr = $query->find(1);
		
		if(!$profaneStr) return 1;
		
		$sentance = str_replace(","," ",$sentance);
	
		$strings = explode(" ",$sentance);	
		$profaneArray = explode(",",$profaneStr->profane_words);
		
		foreach($strings as $string){
			if(empty(trim($string))) continue;
		
			if (in_array($string, $profaneArray)) {
				return -1;
			}
		}
	
		
		return 1;	
	}
	
	
}

?>