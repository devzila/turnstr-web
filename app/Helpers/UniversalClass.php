<?php
namespace App\Helpers;
use Universal;

class UniversalClass{


   public static function encrypt($id)
    {
        $key = "123456";
        $id = base_convert($id, 10, 36); // Save some space
        $data = mcrypt_encrypt(MCRYPT_BLOWFISH, $key, $id, 'ecb');
        $data = bin2hex($data);

        return $data;
    }

    public static function decrypt($encrypted_id)
    {
        $key = "123456";
        $data = pack('H*', $encrypted_id); // Translate back to binary
        $data = mcrypt_decrypt(MCRYPT_BLOWFISH, $key, $data, 'ecb');
        $data = base_convert($data, 36, 10);

        return $data;
    }

}
?>