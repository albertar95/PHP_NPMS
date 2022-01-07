<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use PersianValidator\NationalCode;
use PersianValidator\NationalCode\NationalCode as NationalCodeNationalCode;

class NationalCodeLength implements Rule
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
        $nationalCode = NationalCodeNationalCode::make($value);
        return $nationalCode->isValid();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'کد ملی وارد شده صحیح نمی باشد';
    }
}
