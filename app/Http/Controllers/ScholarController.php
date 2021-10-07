<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\NPMSController;
use Facade\FlareClient\Api;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Http;
use resources\ViewModels;
use Resources\ViewModels\ScholarViewModel;

class ScholarController extends Controller
{
    public function AddScholar()
    {
        $api = new NPMSController();
        $Majors = $api->GetMajors();
        $CollaborationTypes = $api->GetCollaborationTypes();
        $Grades = $api->GetGrades();
        $MillitaryStatuses = $api->GetMillitaryStatuses();
        $Colleges = $api->GetColleges();
        return view('Scholar.AddScholar',compact('Majors','CollaborationTypes','Grades','MillitaryStatuses','Colleges'));
    }
    public function Scholars()
    {
        $api = new NPMSController();
        $Scholar = $api->GetAllScholarLists(0);
        return view('Scholar.Scholars',compact('Scholar'));
    }
    public function ScholarDetail(string $NidScholar)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $result->HasValue = true;
        $Scholar = $api->GetAllScholarDetails($NidScholar);
        $result->Html = view('Scholar._ScholarDetail',compact('Scholar'))->render();
        return response()->json($result);
    }
    public function EditScholar(string $NidScholar)
    {
        $api = new NPMSController();
        $Majors = $api->GetMajors();
        $CollaborationTypes = $api->GetCollaborationTypes();
        $Grades = $api->GetGrades();
        $MillitaryStatuses = $api->GetMillitaryStatuses();
        $Colleges = $api->GetColleges();
        $Scholar = $api->GetScholarDTO($NidScholar);
        if(is_null($Scholar))
        {
            $Oreintations = $api->GetOreintationsByMajorId($Scholar->MajorId);
        }else
        {
            $Oreintations = new Collection();
        }
        return view('Scholar.EditScholar',compact('Majors','CollaborationTypes','Grades','MillitaryStatuses','Colleges','Scholar','Oreintations'));
    }
    public function SubmitEditScholar(Request $scholar) //ScholarDTO
    {
        $api = new NPMSController();
        $Scholar = $api->UpdateScholar($scholar);
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     var UpdateScholarResult = client.PostAsJsonAsync("scholar/UpdateScholarDTO", scholar).Result;
        //     if(UpdateScholarResult.IsSuccessStatusCode)
        //     {
        //         //var Response = UpdateScholarResult.Content.ReadAsAsync<ScholarDTO>().Result;
        //         TempData["EditScholarSuccessMessage"] = $"محقق با نام {scholar.FirstName} {scholar.LastName} با موفقیت ویرایش گردید";
        //     }
        //     else
        //         TempData["EditScholarErrorMessage"] = $"خطا در انجام عملیات لطفا مجدد امتحان کنید";
        // }
        // return RedirectToAction("Scholars");
        return redirect('Scholars');
    }
    public function DeleteScholar(string $NidScholar)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $state = 0;
        $Scholar = $api->DeleteScholar($NidScholar);
        if(json_decode($Scholar->getContent(),true)['Message'] == "-1")
        {
            $result->Message = "1";
            $result->Html = sprintf('محقق با نام %s با موفقیت حذف گردید',json_decode($Scholar->getContent(),true)['Html']);
        }elseif(json_decode($Scholar->getContent(),true)['Message'] == "0")
        {
            $result->Message = "2";
            $result->Html = sprintf('خطا در انجام عملیات.لطفا مجددا امتحان کنید');
        }else
        {
            $result->Message = "3";
            $result->Html = sprintf('محقق دارای %s طرح ثبت شده در سیستم می باشد.امکان حذف وجود ندارد',json_decode($Scholar->getContent(),true)['Message']);
        }
        return response()->json($result);
    }
}
