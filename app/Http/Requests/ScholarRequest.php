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
}
