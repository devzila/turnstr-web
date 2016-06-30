<?php
namespace App\Helpers;
use Universal;
use URL;
use Carbon\Carbon;
class UniversalClass{

    const KEY = "98hmn9h";
    const BASE10 = 10;
    const BASE36 = 36;

    public static function encrypt($id)
    {
        $id = base_convert($id, self::BASE10, self::BASE36); // Save some space
        $data = mcrypt_encrypt(MCRYPT_BLOWFISH, self::KEY, $id, 'ecb');
        return bin2hex($data);
    }

    public static function decrypt($encrypted_id)
    {
        $data = pack('H*', $encrypted_id); // Translate back to binary
        $data = mcrypt_decrypt(MCRYPT_BLOWFISH, self::KEY, $data, 'ecb');
        return base_convert($data, self::BASE36, self::BASE10);
    }
    /*create Share URL for post
        param @id
     */
    public static function shareUrl($id){
        $postId = self::encrypt($id);
        $postUrl = URL::to('/').'/share/'.$postId;
        return $postUrl;
    }
	static function timeString($pTime){	
		
		$etime = time() - strtotime($pTime);
		if ($etime < 1){
			return '0 seconds';
		}
		$a = array( 365 * 24 * 60 * 60  =>  'year',
					 30 * 24 * 60 * 60  =>  'month',
						  24 * 60 * 60  =>  'day',
							   60 * 60  =>  'hour',
									60  =>  'minute',
									 1  =>  'second'
					);
		$a_plural = array( 'year'   => 'years',
						   'month'  => 'months',
						   'day'    => 'days',
						   'hour'   => 'hours',
						   'minute' => 'minutes',
						   'second' => 'seconds'
					);
		foreach ($a as $secs => $str){
			$d = $etime / $secs;
			if ($d >= 1){
				$r = round($d);
				return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
			}
		}
	}
	
	static function replaceTagMentionLink($sentance){
		// find all #tag
		preg_match_all('/#([^\s]+)/', $sentance, $matches);

		if(!array_key_exists(1, $matches)){
			return;
		}
		// generate Links For #tags
		foreach($matches[1] as $match){
			$sentance = preg_replace("/([^>]|^)#$match\b/","$1<div class='tag'><a href='/tags?searchData=$match'>#$match</a></div>",$sentance);
		}
		
		preg_match_all('/@([^\s]+)/', $sentance, $matches2);
		// generate Links For @mention
		foreach($matches2[1] as $match2){
			$sentance = preg_replace("/([^>]|^)@$match2\b/","$1<div class='tag'><a href='/userprofile/@$match2'>@$match2</a></div>",$sentance);
		}
		return $sentance;
	}
	
	static function getTimeZone($ptime,$timezone = 'America/New_York'){
		$carbonDate = new Carbon($ptime);
		$carbonDate->timezone = $timezone;
		$date = $carbonDate->toDayDateTimeString();
		return date("Y-m-d h:i:s",strtotime($date));
	}
	
}
?>