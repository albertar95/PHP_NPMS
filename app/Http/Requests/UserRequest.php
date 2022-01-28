<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            "FirstName" => 'required|max:100',
            "LastName" => 'required|max:100',
            "UserName" => 'required|max:100',
            "Password" => 'required'
        ];
    }
    public function messages()
    {
        return[
            'FirstName.max' => 'طول نام باید کمتر از 100 کاراکتر باشد',
            'FirstName.required' => 'نام الزامی می باشد',
            'LastName.max' => 'طول نام خانوادگی باید کمتر از 100 کاراکتر باشد',
            'LastName.required' => 'نام خانوادگی الزامی می باشد',
            'UserName.max' => 'طول نام کاربری باید کمتر از 100 کاراکتر باشد',
            'UserName.required' => 'نام کاربری الزامی می باشد',
            'Password.required' => 'کلمه عبور الزامی می باشد',
        ];
    }
}
