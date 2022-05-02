<?php

namespace App\Rules;

use App\Http\Controllers\Api\NPMSController;
use Illuminate\Contracts\Validation\Rule;

class ProjectNumberCheck implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public int $MessageLevel = 0;
    public function __construct()
    {
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
        if(!is_numeric($value))
        {
            $this->MessageLevel = 1;
            return false;
        }else
        {
            $api = new NPMSController();
            if(!$api->CheckProjectNumber($value))
            {
                $this->MessageLevel = 2;
                return false;
            }else
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if($this->MessageLevel == 1)
        return 'مقدار شماره پرونده باید عددی باشد';
        else if($this->MessageLevel == 2)
        return 'شماره پرونده وارد شده در سامانه موجود می باشد';
    }
}
