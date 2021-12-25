<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\NPMSController;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function AdvanceSearch()
    {
        return view('Search.AdvanceSearch');
    }
    public function SearchSectionChange(int $SectionId,int $cascadeId = 0)
    {
        $result = "<option value='0' selected>تمامی موارد</option>";
        switch ($SectionId)
        {
            case 1:
                switch ($cascadeId)
                {
                    case 0:
                        $result = Str::of($result)->append("<option value='1'>نام محقق</option>");
                        $result = Str::of($result)->append("<option value='2'>کد ملی</option>");
                        $result = Str::of($result)->append("<option value='3'>شماره همراه</option>");
                        $result = Str::of($result)->append("<option value='4'>وضعیت خدمتی</option>");
                        $result = Str::of($result)->append("<option value='5'>نوع همکاری</option>");
                        $result = Str::of($result)->append("<option value='6'>رشته تحصیلی</option>");
                        $result = Str::of($result)->append("<option value='7'>گرایش تحصیلی</option>");
                        $result = Str::of($result)->append("<option value='8'>مقطع تحصیلی</option>");
                        $result = Str::of($result)->append("<option value='9'>دانشکده</option>");
                        break;
                    case 1:
                        $result = Str::of($result)->append("<option value='1'>نام محقق</option>");
                        $result = Str::of($result)->append("<option value='2'>کد ملی</option>");
                        $result = Str::of($result)->append("<option value='3'>شماره همراه</option>");
                        $result = Str::of($result)->append("<option value='4'>وضعیت خدمتی</option>");
                        $result = Str::of($result)->append("<option value='5'>نوع همکاری</option>");
                        break;
                    case 2:
                        $result = Str::of($result)->append("<option value='6'>رشته تحصیلی</option>");
                        $result = Str::of($result)->append("<option value='7'>گرایش تحصیلی</option>");
                        $result = Str::of($result)->append("<option value='8'>مقطع تحصیلی</option>");
                        $result = Str::of($result)->append("<option value='9'>دانشکده</option>");
                        break;
                }
                break;
            case 2:
                switch ($cascadeId)
                {
                    case 0:
                        $result = Str::of($result)->append("<option value='1'>موضوع طرح</option>");
                        $result = Str::of($result)->append("<option value='2'>یگان تخصصی</option>");
                        $result = Str::of($result)->append("<option value='3'>گروه تخصصی</option>");
                        $result = Str::of($result)->append("<option value='4'>شماره پرونده</option>");
                        $result = Str::of($result)->append("<option value='5'>نام محقق</option>");
                        $result = Str::of($result)->append("<option value='6'>تاریخ بکارگیری</option>");
                        $result = Str::of($result)->append("<option value='7'>تاریخ نامه 10 درصد</option>");
                        $result = Str::of($result)->append("<option value='8'>تاریخ روگرفت</option>");
                        $result = Str::of($result)->append("<option value='9'>تاریخ فرم 30 درصد</option>");
                        $result = Str::of($result)->append("<option value='10'>تاریخ فرم 60 درصد</option>");
                        $result = Str::of($result)->append("<option value='11'>تاریخ نامه حفاظت</option>");
                        $result = Str::of($result)->append("<option value='12'>استاد راهنما</option>");
                        $result = Str::of($result)->append("<option value='13'>استاد مشاور</option>");
                        $result = Str::of($result)->append("<option value='14'>داور 1</option>");
                        $result = Str::of($result)->append("<option value='15'>داور 2</option>");
                        $result = Str::of($result)->append("<option value='16'>تاریخ دفاعیه</option>");
                        break;
                    case 1:
                        $result = Str::of($result)->append("<option value='1'>موضوع طرح</option>");
                        $result = Str::of($result)->append("<option value='2'>یگان تخصصی</option>");
                        $result = Str::of($result)->append("<option value='3'>گروه تخصصی</option>");
                        $result = Str::of($result)->append("<option value='4'>شماره پرونده</option>");
                        $result = Str::of($result)->append("<option value='5'>نام محقق</option>");
                        break;
                    case 2:
                        $result = Str::of($result)->append("<option value='6'>تاریخ بکارگیری</option>");
                        $result = Str::of($result)->append("<option value='7'>تاریخ نامه 10 درصد</option>");
                        $result = Str::of($result)->append("<option value='8'>تاریخ روگرفت</option>");
                        $result = Str::of($result)->append("<option value='9'>تاریخ فرم 30 درصد</option>");
                        $result = Str::of($result)->append("<option value='10'>تاریخ فرم 60 درصد</option>");
                        $result = Str::of($result)->append("<option value='11'>تاریخ نامه حفاظت</option>");
                        break;
                    case 3:
                        $result = Str::of($result)->append("<option value='12'>استاد راهنما</option>");
                        $result = Str::of($result)->append("<option value='13'>استاد مشاور</option>");
                        $result = Str::of($result)->append("<option value='14'>داور 1</option>");
                        $result = Str::of($result)->append("<option value='15'>داور 2</option>");
                        $result = Str::of($result)->append("<option value='16'>تاریخ دفاعیه</option>");
                        break;
                }
                break;
            case 3:
                $result = Str::of($result)->append("<option value='1'>نام کاربری</option>");
                $result = Str::of($result)->append("<option value='2'>مشخصات کاربر</option>");
                $result = Str::of($result)->append("<option value='3'>دسترسی های کاربر</option>");
                break;
            case 4:
                $result = Str::of($result)->append("<option value='1'>عنوان</option>");
                break;
        }
        $results = new JsonResults();
        $results->HasValue = true;
        $results->Html = $result;
        return response()->json($results);
    }
    public function SubmitAdvanceSearch(string $SearchInputs)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $result->HasValue = true;
        $inps = explode(',',$SearchInputs);
        $response = $api->AdvancedSearch($inps[0],$inps[1],$inps[2],$inps[3]);
        $Projects = $response->Projects;
        $Scholars = $response->Scholars;
        $Users = $response->Users;
        $BaseInfo = $response->BaseInfo;
        $result->Html = view('Search._AdvancedSearchResult',compact('Projects','Scholars','Users','BaseInfo'))->render();
        // $api->AddLog(auth()->user(),$request->ip(),1,0,2,1,"ایجاد محقق");
        return response()->json($result);
        // return $response;
    }
    public function ComplexSearch(string $Text)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $result->HasValue = true;
        $response = $api->ComplexSearch($Text);
        $Projects = $response->Projects;
        $Scholars = $response->Scholars;
        $Users = $response->Users;
        $result->Html = view('Search._ComplexSearchResult',compact('Projects','Scholars','Users'))->render();
        // $api->AddLog(auth()->user(),$request->ip(),1,0,2,1,"ایجاد محقق");
        return response()->json($result);
    }
}
