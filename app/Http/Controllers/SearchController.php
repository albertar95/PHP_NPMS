<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\NPMSController;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use Hekmatinasser\Verta\Verta as VertaVerta;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('XSS');
    }
    public function AdvanceSearch(Request $request)
    {
        try {
            $api = new NPMSController();
            $api->AddLog(auth()->user(),$request->ip(),1,0,2,1,"جستجو پیشرفته");
            return view('Search.AdvanceSearch');
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SearchSectionChange(Request $request)
    {
        try {
            $result = "<option value='0' selected>تمامی موارد</option>";
            switch ($request->SectionId)
            {
                case 1:
                    switch ($request->cascadeId)
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
                            $result = Str::of($result)->append("<option value='10'>تاریخ نامه حفاظت</option>");
                            break;
                        case 1:
                            $result = Str::of($result)->append("<option value='1'>نام محقق</option>");
                            $result = Str::of($result)->append("<option value='2'>کد ملی</option>");
                            $result = Str::of($result)->append("<option value='3'>شماره همراه</option>");
                            $result = Str::of($result)->append("<option value='4'>وضعیت خدمتی</option>");
                            $result = Str::of($result)->append("<option value='5'>نوع همکاری</option>");
                            $result = Str::of($result)->append("<option value='10'>تاریخ نامه حفاظت</option>");
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
                    switch ($request->cascadeId)
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
                            // $result = Str::of($result)->append("<option value='11'>تاریخ نامه حفاظت</option>");
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
                            // $result = Str::of($result)->append("<option value='11'>تاریخ نامه حفاظت</option>");
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
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function SubmitAdvanceSearch(Request $request,string $SearchInputs)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $result->HasValue = true;
        $inps = explode(',',$SearchInputs);
        $response = $api->AdvancedSearch($inps[0],$inps[1],$inps[2],$inps[3]);
        $Projects = $response[1];
        $Scholars = $response[0];
        $Users = $response[2];
        $BaseInfo = $response[3];
        $result->Html = view('Search._AdvancedSearchResult',compact('Projects','Scholars','Users','BaseInfo'))->render();
        $api->AddLog(auth()->user(),$request->ip(),33,0,3,1,"");
        return response()->json($result);
        // dd($response);
        try {

        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function DownloadAdvanceSearchResult(Request $SearchInputs)
    {
        try {
            $api = new NPMSController();
            $result = new JsonResults();
            $result->HasValue = true;
            $response = $api->AdvancedSearch($SearchInputs->searchText,$SearchInputs->Section,$SearchInputs->SearchBy,$SearchInputs->Similar);
            $Projects = $response[1];
            $Scholars = $response[0];
            $Users = $response[2];
            $BaseInfo = $response[3];
            $exportOptions = $SearchInputs->ExportOptions;
            $ReportDate = substr(new VertaVerta(Carbon::now()),0,10);
            $ReportTime = substr(new VertaVerta(Carbon::now()),10,10);
            $ConfidentLevel = 0;
            if(($Scholars->count() + $Projects->count() + $BaseInfo->count() + $Users->count()) > 2500)
            {
                try {
                    ini_set("pcre.backtrack_limit", "100000000");
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
            $pdf = PDF::loadView('Search._DownloadAdvancedSearchResult',compact('Projects','Scholars','Users','BaseInfo','ReportDate','ReportTime','ConfidentLevel','exportOptions'));
            $api->AddLog(auth()->user(),$SearchInputs->ip(),34,0,3,1,"");
            return response()->download($pdf->download());
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function PrintAdvanceSearchResult(Request $SearchInputs)
    {
        try {
            $api = new NPMSController();
            $result = new JsonResults();
            $result->HasValue = true;
            $response = $api->AdvancedSearch($SearchInputs->searchText,$SearchInputs->Section,$SearchInputs->SearchBy,$SearchInputs->Similar);
            $Projects = $response[1];
            $Scholars = $response[0];
            $Users = $response[2];
            $BaseInfo = $response[3];
            $ReportDate = substr(new VertaVerta(Carbon::now()),0,10);
            $ReportTime = substr(new VertaVerta(Carbon::now()),10,10);
            $ConfidentLevel = 0;
            $result->HasValue = true;
            $result->Html = view('Search._DownloadAdvancedSearchResult',compact('Projects','Scholars','Users','BaseInfo','ReportDate','ReportTime','ConfidentLevel'))->render();
            $api->AddLog(auth()->user(),$SearchInputs->ip(),35,0,3,1,"");
            return response()->json($result);
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function ComplexSearch(string $Text)
    {
        try {
            $api = new NPMSController();
            $result = new JsonResults();
            $result->HasValue = true;
            $response = $api->ComplexSearch($Text);
            $Projects = $response[0];
            $Scholars = $response[1];
            $Users = $response[2];
            $result->Html = view('Search._ComplexSearchResult',compact('Projects','Scholars','Users'))->render();
            // $api->AddLog(auth()->user(),$request->ip(),1,0,2,1,"ایجاد محقق");
            return response()->json($result);
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
}
