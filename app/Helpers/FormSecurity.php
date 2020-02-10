<?php

namespace App\Helpers;

class FormSecurity
{
    
    /**
     * @link http://php.net/manual/en/function.openssl-get-cipher-methods.php Available methods.
     * @var string Cipher method. Recommended AES-128-CBC, AES-192-CBC, AES-256-CBC
    */
    //$encryptMethod = 'AES-256-CBC';


    public static function decrypt($encryptedString, $key)
    {
        $encryptMethod = 'AES-256-CBC';

        $json = json_decode(base64_decode($encryptedString), true);

        try {
            $salt = hex2bin($json["salt"]);
            $iv = hex2bin($json["iv"]);
        } catch (Exception $e) {
            return null;
        }

        $cipherText = base64_decode($json['ciphertext']);

        $iterations = intval(abs($json['iterations']));
        if ($iterations <= 0) {
            $iterations = 999;
        }
        $hashKey = hash_pbkdf2('sha512', $key, $salt, $iterations, (Self::encryptMethodLength() / 4));
        unset($iterations, $json, $salt);

        $decrypted= openssl_decrypt($cipherText , $encryptMethod, hex2bin($hashKey), OPENSSL_RAW_DATA, $iv);
        unset($cipherText, $hashKey, $iv);

        return $decrypted;
    }// decrypt


    public static function encrypt($string, $key)
    {
        $encryptMethod = 'AES-256-CBC';

        $ivLength = openssl_cipher_iv_length($encryptMethod);
        $iv = openssl_random_pseudo_bytes($ivLength);
 
        $salt = openssl_random_pseudo_bytes(256);
        $iterations = 999;
        $hashKey = hash_pbkdf2('sha512', $key, $salt, $iterations, (Self::encryptMethodLength() / 4));

        $encryptedString = openssl_encrypt($string, $encryptMethod, hex2bin($hashKey), OPENSSL_RAW_DATA, $iv);

        $encryptedString = base64_encode($encryptedString);
        unset($hashKey);

        $output = ['ciphertext' => $encryptedString, 'iv' => bin2hex($iv), 'salt' => bin2hex($salt), 'iterations' => $iterations];
        unset($encryptedString, $iterations, $iv, $ivLength, $salt);

        return base64_encode(json_encode($output));
    }// encrypt


    /**
     * Get encrypt method length number (128, 192, 256).
     * 
     * @return integer.
     */
    protected static function encryptMethodLength()
    {
        $number = filter_var('AES-256-CBC', FILTER_SANITIZE_NUMBER_INT);

        return intval(abs($number));
    }// encryptMethodLength

    public static function encryptFormField($formFileds)
    {
        foreach ($formFileds as $key => $value)
            $formFileds[$key] = Self::encrypt($value, 169);
        
        return $formFileds;
    }

}