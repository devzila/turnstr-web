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
		
		$strings = explode(" ",$sentance);
	
		foreach($strings as $string){
			if(empty(trim($string)) || $string == ",") continue;
		
			if (preg_match('/\b' . $string . '\b/i', (string)($profaneStr->profane_words))) { 
			   return -1;
			}
		}
		
		return 1;	
	}
	
	
}

?>