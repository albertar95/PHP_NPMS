<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MobileFormat implements Rule
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
        if(strlen($value) >= 11 && substr($value,0,2) == "09")
        return true;
        else
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'فرمت شماره همراه وارد شده صحیح نمی باشد';
    }
}
