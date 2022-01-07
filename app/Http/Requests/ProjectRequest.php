<?php

namespace App\Http\Requests;

use App\Rules\MobileFormat;
use App\Rules\PersianDateFormat;
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
            "PersianCreateDate" => new PersianDateFormat(),
            "TenPercentLetterDate" => new PersianDateFormat(),
            "PreImploymentLetterDate" => new PersianDateFormat(),
            "ImploymentDate" => new PersianDateFormat(),
            "SecurityLetterDate" => new PersianDateFormat(),
            "ThesisDefenceDate" => new PersianDateFormat(),
            "ThesisDefenceLetterDate" => new PersianDateFormat(),
            "ReducePeriod" => 'integer|min:0',
            "ThirtyPercentLetterDate" => new PersianDateFormat(),
            "SixtyPercentLetterDate" => new PersianDateFormat(),
            "ATFLetterDate" => new PersianDateFormat()
        ];
    }
}
