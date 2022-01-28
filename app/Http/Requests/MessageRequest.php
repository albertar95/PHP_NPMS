<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            "Title" => 'max:200',
            "MessageContent" => 'required|max:8000'
        ];
    }
    public function messages()
    {
        return[
            'MessageContent.max' => 'متن پیام باید کمتر از 8000 کاراکتر باشد',
            'MessageContent.required' => 'متن الزامی می باشد',
            'Title.max' => 'طول عنوان باید کمتر از 100 کاراکتر باشد',
        ];
    }
}
