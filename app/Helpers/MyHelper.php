<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;

class MyHelper
{
    public static function generatePageLink($active, $totalPage)
    {
        if($active == 1) { $status = 'active'; $prev = 'disabled'; }
        else { $status = ''; $prev = ''; }$page = '';

        $page .= '
            <li class="page-item '.$prev.'"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item '.$status.'"><a class="page-link" href="#">1</a></li>
        ';

        for ($i = 2; $i <= $totalPage; $i++) {
            $status = ($active == $i) ? 'active' : '';
            $page .= '<li class="page-item '.$status.'"><a class="page-link" href="#">'.$i.'</a></li>';
        }

        if($active == $totalPage) $next = 'disabled'; else $next = '';
        $page .= '<li class="page-item '.$next.'"><a class="page-link" href="#">Next</a></li>';

        return $page;
    }

    public static function getFormFields($form_name)
    {
        $fieldArray = Config::get('formField.' . $form_name);
        return $fieldArray;
    }

    public static function encryptFormField($field_keys)
    {
        $return_enc_fields = array();
        foreach ($field_keys as $key => $value) {

            $encrypt_val             = '';
            $encrypt_val             = self::encrypt($value);
            $return_enc_fields[$key] = $encrypt_val;
        }

        return $return_enc_fields;
    }

    public static function decryptForm($post_data = array(), $white_list = array(), $ignore_keys = array())
    {
        $return_post_data = array();
        foreach ($post_data as $key => $value) {
            if (!in_array($key, $ignore_keys)) {
                $dycrypt_val = '';
                $dycrypt_val = self::decrypt($key);

                if ($dycrypt_val != '') {
                    if (in_array($dycrypt_val, $white_list)) {
                        $return_post_data[$dycrypt_val] = $value;
                    } else {
                        return false;
                    }
                }
            }
        }
        return $return_post_data;
    }

    public static function encrypt($name)
    {
        $name     = trim($name);
        $charArr  = str_split(trim($name));
        $ascii    = '';
        $numRange = range(0, count($charArr) - 1);
        shuffle($numRange);
        foreach ($numRange as $k => $v) {
            $ascii .= dechex(ord($charArr[$v])) . self::genChar('G', 'Z', 1);
        }

        $firstBit = 'ft';
        foreach ($numRange as $kk => $vv) {
            $firstBit .= $vv . self::genChar('g', 'z', 1);
        }
        $finalEnc = $firstBit . self::genChar('G', 'Z', rand(6, 12)) . $ascii;
        return $finalEnc;
    }

    private static function genChar($rangefrom, $rangeto, $length = 1)
    {
        $alphabets   = range($rangefrom, $rangeto);
        $final_array = array_merge($alphabets);
        $char        = '';
        while ($length--) {
            $key = array_rand($final_array);
            $char .= $final_array[$key];
        }
        return $char;
    }

    public static function decrypt($finalEnc)
    {
        $temp = str_replace('ft', '', $finalEnc);
        if ($temp == $finalEnc) {
            return false;
        }
        $finalEnc   = $temp;
        $alphabets  = range('G', 'Z');
        $alphabets1 = range('g', 'z');
        $temp       = str_replace($alphabets, '|', $finalEnc);
        if ($temp == $finalEnc) {
            return false;
        }
        $finalEnc    = $temp;
        $finalEncArr = explode('|', $finalEnc);
        $shuffled    = $finalEncArr[0];
        $temp        = str_replace($alphabets1, '|', $shuffled);
        if ($temp == $shuffled) {
            return false;
        }
        $shuffled    = $temp;
        $shuffledArr = explode('|', $shuffled);
        unset($finalEncArr[0]);
        $finalNameDecr = '';
        foreach ($finalEncArr as $k1 => $v1) {
            if ($v1 != '') {
                $finalNameDecr .= chr(hexdec($v1));
            }
        }

        $charArr1      = str_split(trim($finalNameDecr));
        $finalNameDecr = '';
        $i             = 0;
        $shuffledArr1  = array();
        foreach ($shuffledArr as $v2) {
            if ($v2 != '') {
                $shuffledArr1[$v2] = $charArr1[$i];
                $i++;
            }
        }
        ksort($shuffledArr1);
        foreach ($shuffledArr1 as $k3 => $v3) {
            $finalNameDecr .= $v3;
        }
        return $finalNameDecr;
    }
}
