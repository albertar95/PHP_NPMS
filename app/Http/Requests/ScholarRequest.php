<?php

namespace App\Http\Requests;

use App\Rules\MobileFormat;
use App\Rules\NationalCodeLength;
use App\Rules\PersianDateFormat;
use Illuminate\Foundation\Http\FormRequest;

class ScholarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "FirstName" => 'required|max:75',
            "LastName" => 'required|max:75',
            "NationalCode" => new NationalCodeLength(),
            "BirthDate" => new PersianDateFormat(),
            "FatherName" => 'max:75',
            "ProfilePicture" => 'max:8000',
            "Mobile" => new MobileFormat()
        ];
    }
     public function messages()
    {
        return[
            'FirstName.max' => 'طول نام محقق باید کمتر از 75 کاراکتر باشد',
            'LastName.max' => 'طول نام خانوادگی محقق باید کمتر از 75 کاراکتر باشد',
            'FatherName.max' => 'طول نام پدر محقق باید کمتر از 75 کاراکتر باشد',
            'FirstName.required' => 'نام محقق الزامی می باشد',
            'LastName.required' => 'نام خانوادگی محقق الزامی می باشد',
        ];
    }
}
