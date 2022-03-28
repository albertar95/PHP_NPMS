<?php

namespace App\Rules;

use App\Helpers\Casts;
use Illuminate\Contracts\Validation\Rule;
use PhpParser\Node\Expr\Cast;

class PersianDateFormat implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (Casts::hasPersianDigit($value)) {
            if (strlen($value) >= 10) {
                // if(is_numeric(Casts::PersianToEnglishDigits(substr($value,0,8))) && is_numeric(Casts::PersianToEnglishDigits(substr(substr($value,0,13),-4))) && is_numeric(Casts::PersianToEnglishDigits(substr($value,-4))))//  && substr($value,4,1) == '/' && substr($value,7,1) == '/')
                // return true;
                // else
                // return false;
                //intval(Casts::PersianToEnglishDigits(substr($Datee,0,8))),intval(Casts::PersianToEnglishDigits(substr(substr($Datee,0,13),-4))),intval(Casts::PersianToEnglishDigits(substr($Datee,-4)))
                if (is_numeric(Casts::PersianToEnglishDigits(substr($value, 0, 8))) && is_numeric(Casts::PersianToEnglishDigits(substr(substr($value, 0, 13), -4))) && is_numeric(Casts::PersianToEnglishDigits(substr($value, -4))))
                    return true;
                else
                    return false;
            } else
                return false;
        } else {
            if (is_numeric(substr($value,0,4)) && is_numeric(substr($value,5,2)) && is_numeric(substr($value,8,2)))
            return true;
        else
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'فرمت تاریخ وارد شده صحیح نمی باشد';
    }
}
