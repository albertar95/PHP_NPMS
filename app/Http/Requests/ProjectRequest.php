<?php

namespace App\Http\Requests;

use App\Rules\MobileFormat;
use App\Rules\PersianDateFormat;
use App\Rules\ProjectNumberCheck;
use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            "Subject" => 'required|max:2500',
            "Supervisor" => 'max:150',
            "SupervisorMobile" => new MobileFormat(),
            "Advisor" => 'max:150',
            "AdvisorMobile" => new MobileFormat(),
            "Referee1" => 'max:150',
            "Referee2" => 'max:150',
            "TenPercentLetterDate" => new PersianDateFormat(),
            "PreImploymentLetterDate" => new PersianDateFormat(),
            "ImploymentDate" => new PersianDateFormat(),
            "SecurityLetterDate" => new PersianDateFormat(),
            "ThesisDefenceDate" => new PersianDateFormat(),
            "ThesisDefenceLetterDate" => new PersianDateFormat(),
            "ReducePeriod" => 'integer|min:0',
            "ThirtyPercentLetterDate" => new PersianDateFormat(),
            "SixtyPercentLetterDate" => new PersianDateFormat(),
            "ATFLetterDate" => new PersianDateFormat(),
            "ProjectNumber" => new ProjectNumberCheck()
        ];
    }
    public function messages()
    {
        return[
            'Subject.max' => 'موضوع طرح باید کمتر از 2500 کاراکتر باشد',
            'Supervisor.max' => 'طول نام استاد راهنما باید کمتر از 150 کاراکتر باشد',
            'Advisor.max' => 'طول نام استاد مشاور باید کمتر از 150 کاراکتر باشد',
            'Referee1.max' => 'طول نام داور 1 باید کمتر از 150 کاراکتر باشد',
            'Referee2.max' => 'طول نام داور 2 باید کمتر از 150 کاراکتر باشد',
            'Referee2.required' => 'موضوع طرح الزامی می باشد',
            'ProjectNumber.required' => 'شماره پرونده الزامی می باشد',
            'ReducePeriod.min' => 'مدت کسری نباید کمتر از 0 باشد',
        ];
    }
}
