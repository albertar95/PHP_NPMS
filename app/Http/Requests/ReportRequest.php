<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
            "ReportName" => 'required|max:50',
            "ContextId" => 'required',
            "FieldId" => 'required',
        ];
    }
    public function messages()
    {
        return[
            'ReportName.max' => 'طول نام گزارش باید کمتر از 50 کاراکتر باشد',
            'ReportName.required' => 'نام گزارش الزامی می باشد',
            'FieldId.required' => 'یک گزینه را برای جستجو بر اساس آن انتخاب نمایید',
            'ContextId.required' => 'موجودیت را انتخاب نمایید',
        ];
    }
}
