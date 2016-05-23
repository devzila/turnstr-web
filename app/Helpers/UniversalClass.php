<?php
namespace App\Helpers;
use Universal;
use URL;
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
}
?>