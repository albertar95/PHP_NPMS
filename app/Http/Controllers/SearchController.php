<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        // string result = "<option value='0' selected>تمامی موارد</option>";
        // switch (SectionId)
        // {
        //     case 1:
        //         switch (cascadeId)
        //         {
        //             case 0:
        //                 result += "<option value='1'>نام محقق</option>";
        //                 result += "<option value='2'>کد ملی</option>";
        //                 result += "<option value='3'>شماره همراه</option>";
        //                 result += "<option value='4'>وضعیت خدمتی</option>";
        //                 result += "<option value='5'>نوع همکاری</option>";
        //                 result += "<option value='6'>رشته تحصیلی</option>";
        //                 result += "<option value='7'>گرایش تحصیلی</option>";
        //                 result += "<option value='8'>مقطع تحصیلی</option>";
        //                 result += "<option value='9'>دانشکده</option>";
        //                 break;
        //             case 1:
        //                 result += "<option value='1'>نام محقق</option>";
        //                 result += "<option value='2'>کد ملی</option>";
        //                 result += "<option value='3'>شماره همراه</option>";
        //                 result += "<option value='4'>وضعیت خدمتی</option>";
        //                 result += "<option value='5'>نوع همکاری</option>";
        //                 break;
        //             case 2:
        //                 result += "<option value='6'>رشته تحصیلی</option>";
        //                 result += "<option value='7'>گرایش تحصیلی</option>";
        //                 result += "<option value='8'>مقطع تحصیلی</option>";
        //                 result += "<option value='9'>دانشکده</option>";
        //                 break;
        //         }
        //         break;
        //     case 2:
        //         switch (cascadeId)
        //         {
        //             case 0:
        //                 result += "<option value='1'>موضوع طرح</option>";
        //                 result += "<option value='2'>یگان تخصصی</option>";
        //                 result += "<option value='3'>گروه تخصصی</option>";
        //                 result += "<option value='4'>شماره پرونده</option>";
        //                 result += "<option value='5'>نام محقق</option>";
        //                 result += "<option value='6'>تاریخ بکارگیری</option>";
        //                 result += "<option value='7'>تاریخ نامه 10 درصد</option>";
        //                 result += "<option value='8'>تاریخ روگرفت</option>";
        //                 result += "<option value='9'>تاریخ فرم 30 درصد</option>";
        //                 result += "<option value='10'>تاریخ فرم 60 درصد</option>";
        //                 result += "<option value='11'>تاریخ نامه حفاظت</option>";
        //                 result += "<option value='12'>استاد راهنما</option>";
        //                 result += "<option value='13'>استاد مشاور</option>";
        //                 result += "<option value='14'>داور 1</option>";
        //                 result += "<option value='15'>داور 2</option>";
        //                 result += "<option value='16'>تاریخ دفاعیه</option>";
        //                 break;
        //             case 1:
        //                 result += "<option value='1'>موضوع طرح</option>";
        //                 result += "<option value='2'>یگان تخصصی</option>";
        //                 result += "<option value='3'>گروه تخصصی</option>";
        //                 result += "<option value='4'>شماره پرونده</option>";
        //                 result += "<option value='5'>نام محقق</option>";
        //                 break;
        //             case 2:
        //                 result += "<option value='6'>تاریخ بکارگیری</option>";
        //                 result += "<option value='7'>تاریخ نامه 10 درصد</option>";
        //                 result += "<option value='8'>تاریخ روگرفت</option>";
        //                 result += "<option value='9'>تاریخ فرم 30 درصد</option>";
        //                 result += "<option value='10'>تاریخ فرم 60 درصد</option>";
        //                 result += "<option value='11'>تاریخ نامه حفاظت</option>";
        //                 break;
        //             case 3:
        //                 result += "<option value='12'>استاد راهنما</option>";
        //                 result += "<option value='13'>استاد مشاور</option>";
        //                 result += "<option value='14'>داور 1</option>";
        //                 result += "<option value='15'>داور 2</option>";
        //                 result += "<option value='16'>تاریخ دفاعیه</option>";
        //                 break;
        //         }
        //         break;
        //     case 3:
        //         result += "<option value='1'>نام کاربری</option>";
        //         result += "<option value='2'>مشخصات کاربر</option>";
        //         result += "<option value='3'>دسترسی های کاربر</option>";
        //         break;
        //     case 4:
        //         result += "<option value='1'>عنوان</option>";
        //         break;
        // }
        // return Json(new JsonResults() { HasValue = true, Html = result });
    }
    public function SubmitAdvanceSearch(string $searchText,int $SectionId = 0,int $ById = 0,bool $Similar = true)
    {
        // bool state = false;
        // string html = "";
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     HttpResponseMessage response = client.GetAsync($"Search/AdvancedSearch?searchText={searchText}&SectionId={SectionId}&ById={ById}&Similar={Similar}").Result;
        //     if (response.IsSuccessStatusCode)
        //     {
        //         DataAccessLibrary.Repositories.SearchRepository res = response.Content.ReadAsAsync<DataAccessLibrary.Repositories.SearchRepository>().Result;
        //         state = true;
        //         html = JsonResults.RenderViewToString(this.ControllerContext, "_AdvancedSearchResult", res);
        //     }
        // }
        // return Json(new JsonResults() { HasValue = state, Html = html });
    }
    public function ComplexSearch(string $Text)
    {
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     HttpResponseMessage response = client.GetAsync($"Search/ComplexSearch?searchText={Text}").Result;
        //     if (response.IsSuccessStatusCode)
        //     {
        //         DataAccessLibrary.Repositories.SearchRepository res = response.Content.ReadAsAsync<DataAccessLibrary.Repositories.SearchRepository>().Result;
        //         return Json(new JsonResults() { HasValue = true, Html = JsonResults.RenderViewToString(this.ControllerContext, "_ComplexSearchResult", res)});
        //     }
        //     else
        //     {
        //         return Json(new JsonResults() { HasValue = false, Html = "" });
        //     }
        // }
    }
}
