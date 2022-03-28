<?php

namespace App\Helpers;

use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
class Casts
{
    public static function PersianToEnglishDigits($string)
    {
        $newNumbers = range(0, 9);
        // 1. Persian HTML decimal
        $persianDecimal = array('&#1776;', '&#1777;', '&#1778;', '&#1779;', '&#1780;', '&#1781;', '&#1782;', '&#1783;', '&#1784;', '&#1785;');
        // 4. Persian Numeric
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        return str_replace($persian, $newNumbers, $string);
    }
    public static function EnglishToPersianDigits($string) {
        $newNumbers = range(0, 9);
        // 1. Persian HTML decimal
        $persianDecimal = array('&#1776;', '&#1777;', '&#1778;', '&#1779;', '&#1780;', '&#1781;', '&#1782;', '&#1783;', '&#1784;', '&#1785;');
        // 4. Persian Numeric
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        return str_replace($newNumbers, $persian, $string);
    }
    public static function hasPersianDigit($string){
        $res = false;
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        foreach ($persian as $digit) {
            //if (strstr($string, $url)) { // mine version
            if (strpos($string, $digit) !== FALSE) { // Yoshi version
                $res = true;
            }
        }
        return $res;
    }
}
