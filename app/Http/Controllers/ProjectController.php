<?php

namespace App\Http\Controllers;

use App\DTOs\DataMapper;
use App\Http\Controllers\Api\NPMSController;
use App\Models\Projects;
use App\Models\Scholars;
use Illuminate\Http\Request;
use resources\ViewModels\ManageBaseInfoViewModel;

class ProjectController extends Controller
{
    public function Projects()
    {
        $api = new NPMSController();
        $Projects = $api->GetAllProjectInitials();
        return view('Project.Projects',compact('Projects'));
    }
    public function AddProject()
    {
        $api = new NPMSController();
        $Scholars = $api->GetAllProjectScholars();
        $UnitGroups = $api->GetAllUnitGroups();
        $Units = $api->GetAllUnits();
        return view('Project.AddProject',compact('Scholars','UnitGroups','Units'));
    }
    public function SubmitAddProject(Request $Project)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        if($api->AddProject($Project))
        {
            $result->HasValue = true;
            return response()->json($result);
        }else
        {
            $result->HasValue = true;
            $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
            return response()->json($result);
        }
    }
    public function ProjectDetail(string $NidProject)
    {
        $api = new NPMSController();
        $Project = $api->GetProjectDetailDTOById($NidProject);
        $Scholar = $api->GetAllScholarDetails($Project->ScholarId);
        return view('Project.ProjectDetail',compact('Project','Scholar'));
    }
    public function ProjectProgress(string $NidProject)
    {
        $api = new NPMSController();
        $Scholars = $api->GetAllProjectScholars();
        $UnitGroups = $api->GetAllUnitGroups();
        $Units = $api->GetAllUnits();
        $Project = $api->GetProjectDTOById($NidProject);
        return view('Project.ProjectProgress',compact('Scholars','UnitGroups','Units','Project'));
    }
    public function UpdateProject(Request $Project)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        if($api->ProjectProgress($Project))
        {
            $result->HasValue = true;
            return response()->json($result);
        }else
        {
            $result->HasValue = false;
            $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
            return response()->json($result);
        }
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     HttpResponseMessage UpdateProjectResponse = client.PostAsJsonAsync($"Project/ProjectProgress", Project).Result;
        //     if (UpdateProjectResponse.IsSuccessStatusCode)
        //     {
        //         TempData["ProjectSuccessMessage"] = $"طرح با شماره پرونده {Project.ProjectNumber} با موفقیت ویرایش گردید";
        //         return Json(new JsonResults() { HasValue = true });
        //     }
        //     else
        //     {
        //         return Json(new JsonResults() { HasValue = false, Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید" });
        //     }
        // }
    }
    public function ManageBaseInfo()
    {
        $api = new NPMSController();
        $UnitGroups = $api->GetAllUnitGroups();
        $Units = $api->GetAllUnits();
        $Majors = $api->GetMajors();
        $CollaborationTypes = $api->GetCollaborationTypes();
        $MillitaryStatuses = $api->GetMillitaryStatuses();
        $Oreintations = $api->GetOrientations();
        $Colleges = $api->GetColleges();
        $Grades = $api->GetGrades();
        return view('Project.ManageBaseInfo',compact('UnitGroups','Units','Majors','CollaborationTypes','MillitaryStatuses','Oreintations','Colleges','Grades'));
    }
    public function SubmitUnitForm(Request $unit)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        if(empty($unit->NidUnit))
        {
            $unitname = $api->AddUnit($unit);
            $result->Message = sprintf("یگان با نام %s با موفقیت ایجاد گردید",$unitname);
        }else
        {
            $unitname = $api->UpdateUnit($unit);
            $result->Message = sprintf("یگان با نام %s با موفقیت ویرایش گردید",$unitname);
        }
        $units = $api->GetAllUnits();
        $mbivm = new ManageBaseInfoViewModel();
        $mbivm->TblId = 1;
        $mbivm->Units = $units;
        $result->Html = view('Project._BaseInfoTables',$mbivm)->render();
        $result->HasValue = true;
        $result->AltProp = $unit->NidUnit;
        return response()->json($result);
    }
    public function SubmitUnitGroupForm(Request $unitGroup)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        if(empty($unitGroup->NidUnit))
        {
            $unitname = $api->AddUnitGroup($unitGroup);
            $result->Message = sprintf("گروه با نام %s با موفقیت ایجاد گردید",$unitname);
        }else
        {
            $unitname = $api->UpdateUnitGroup($unitGroup);
            $result->Message = sprintf("گروه با نام %s با موفقیت ویرایش گردید",$unitname);
        }
        $mbivm = new ManageBaseInfoViewModel();
        $mbivm->TblId = 2;
        $mbivm->Units = $api->GetAllUnits();
        $mbivm->UnitGroups = $api->GetAllUnitGroups();
        $result->Html = view('Project._BaseInfoTables',$mbivm)->render();
        $result->HasValue = true;
        // $result->AltProp = $unit->NidUnit;
        return response()->json($result);
        // bool state = false;
        // string message = "";
        // string html = "";
        // if (unitGroup.NidGroup == Guid.Empty)//add
        // {
        //     using (var client = new HttpClient())
        //     {
        //         client.BaseAddress = new Uri(ApiBaseAddress);
        //         client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //         unitGroup.NidGroup = Guid.NewGuid();
        //         var response = client.PostAsJsonAsync("BaseInfo/AddUnitGroup", unitGroup).Result;
        //         if (response.IsSuccessStatusCode)
        //         {
        //             state = true;
        //             message = $"گروه با نام {unitGroup.Title} با موفقیت ایجاد گردید";
        //             HttpResponseMessage UnitResponse = client.GetAsync($"Project/GetAllUnits").Result;
        //             ManageBaseInfoViewModel mbivm = new ManageBaseInfoViewModel();
        //             mbivm.TblId = 2;
        //             if (UnitResponse.IsSuccessStatusCode)
        //             {
        //                 mbivm.Units = UnitResponse.Content.ReadAsAsync<List<UnitDTO>>().Result;
        //             }
        //             HttpResponseMessage UnitGroupResponse = client.GetAsync($"Project/GetAllUnitGroups").Result;
        //             if (UnitGroupResponse.IsSuccessStatusCode)
        //             {
        //                 mbivm.UnitGroups = UnitGroupResponse.Content.ReadAsAsync<List<UnitGroupDTO>>().Result;
        //                 html = JsonResults.RenderViewToString(this.ControllerContext, "_BaseInfoTables", mbivm);
        //             }
        //         }
        //         else
        //             message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        //     }
        // }
        // else //edit
        // {
        //     using (var client = new HttpClient())
        //     {
        //         client.BaseAddress = new Uri(ApiBaseAddress);
        //         client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //         var response = client.PostAsJsonAsync("BaseInfo/UpdateUnitGroup", unitGroup).Result;
        //         if (response.IsSuccessStatusCode)
        //         {
        //             state = true;
        //             message = $"گروه با نام {unitGroup.Title} با موفقیت ویرایش گردید";
        //             HttpResponseMessage UnitResponse = client.GetAsync($"Project/GetAllUnits").Result;
        //             ManageBaseInfoViewModel mbivm = new ManageBaseInfoViewModel();
        //             mbivm.TblId = 2;
        //             if (UnitResponse.IsSuccessStatusCode)
        //             {
        //                 mbivm.Units = UnitResponse.Content.ReadAsAsync<List<UnitDTO>>().Result;
        //             }
        //             HttpResponseMessage UnitGroupResponse = client.GetAsync($"Project/GetAllUnitGroups").Result;
        //             if (UnitGroupResponse.IsSuccessStatusCode)
        //             {
        //                 mbivm.UnitGroups = UnitGroupResponse.Content.ReadAsAsync<List<UnitGroupDTO>>().Result;
        //                 html = JsonResults.RenderViewToString(this.ControllerContext, "_BaseInfoTables", mbivm);
        //             }
        //         }
        //         else
        //             message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        //     }
        // }
        // return Json(new JsonResults() { HasValue = state, Message = message, Html = html });
    }
    public function SubmitGradeForm(Request $grade)
    {
        // bool state = false;
        // string message = "";
        // string html = "";
        // if (grade.NidSetting == Guid.Empty)//add
        // {
        //     using (var client = new HttpClient())
        //     {
        //         client.BaseAddress = new Uri(ApiBaseAddress);
        //         client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //         grade.NidSetting = Guid.NewGuid();
        //         var Valueresponse = client.GetAsync($"BaseInfo/GenerateSettingValue?index=1").Result;
        //         if (Valueresponse.IsSuccessStatusCode)
        //             grade.SettingValue = Valueresponse.Content.ReadAsAsync<JsonResults>().Result.Message;
        //         var response = client.PostAsJsonAsync("BaseInfo/AddSetting",grade).Result;
        //         if (response.IsSuccessStatusCode)
        //         {
        //             state = true;
        //             message = $"مقطع تحصیلی با نام {grade.SettingTitle} با موفقیت ایجاد گردید";
        //             HttpResponseMessage GradeResponse = client.GetAsync($"Scholar/GetGrades").Result;
        //             if (GradeResponse.IsSuccessStatusCode)
        //             {
        //                 ManageBaseInfoViewModel mbivm = new ManageBaseInfoViewModel() { TblId = 3, Grades = GradeResponse.Content.ReadAsAsync<List<Setting>>().Result };
        //                 html = JsonResults.RenderViewToString(this.ControllerContext, "_BaseInfoTables", mbivm);
        //             }
        //         }
        //         else
        //             message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        //     }
        // }
        // else //edit
        // {
        //     using (var client = new HttpClient())
        //     {
        //         client.BaseAddress = new Uri(ApiBaseAddress);
        //         client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //         var response = client.PostAsJsonAsync("BaseInfo/UpdateSetting", grade).Result;
        //         if (response.IsSuccessStatusCode)
        //         {
        //             state = true;
        //             message = $"مقطع تحصیلی با نام {grade.SettingTitle} با موفقیت ویرایش گردید";
        //             HttpResponseMessage GradeResponse = client.GetAsync($"Scholar/GetGrades").Result;
        //             if (GradeResponse.IsSuccessStatusCode)
        //             {
        //                 ManageBaseInfoViewModel mbivm = new ManageBaseInfoViewModel() { TblId = 3, Grades = GradeResponse.Content.ReadAsAsync<List<Setting>>().Result };
        //                 html = JsonResults.RenderViewToString(this.ControllerContext, "_BaseInfoTables", mbivm);
        //             }
        //         }
        //         else
        //             message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        //     }
        // }
        // return Json(new JsonResults() { HasValue = state, Message = message, Html = html });
    }
    public function SubmitMajorForm(Request $major)
    {
        // bool state = false;
        // string message = "";
        // string html = "";
        // if (major.NidMajor == Guid.Empty)//add
        // {
        //     using (var client = new HttpClient())
        //     {
        //         client.BaseAddress = new Uri(ApiBaseAddress);
        //         client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //         major.NidMajor = Guid.NewGuid();
        //         var response = client.PostAsJsonAsync("BaseInfo/AddMajor", major).Result;
        //         if (response.IsSuccessStatusCode)
        //         {
        //             state = true;
        //             message = $"رشته تحصیلی با نام {major.Title} با موفقیت ایجاد گردید";
        //             HttpResponseMessage MajorResponse = client.GetAsync($"Scholar/GetMajors").Result;
        //             if (MajorResponse.IsSuccessStatusCode)
        //             {
        //                 ManageBaseInfoViewModel mbivm = new ManageBaseInfoViewModel() { TblId = 4, Majors = MajorResponse.Content.ReadAsAsync<List<MajorDTO>>().Result };
        //                 html = JsonResults.RenderViewToString(this.ControllerContext, "_BaseInfoTables", mbivm);
        //             }
        //         }
        //         else
        //             message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        //     }
        // }
        // else //edit
        // {
        //     using (var client = new HttpClient())
        //     {
        //         client.BaseAddress = new Uri(ApiBaseAddress);
        //         client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //         var response = client.PostAsJsonAsync("BaseInfo/UpdateMajor", major).Result;
        //         if (response.IsSuccessStatusCode)
        //         {
        //             state = true;
        //             message = $"رشته تحصیلی با نام {major.Title} با موفقیت ویرایش گردید";
        //             HttpResponseMessage MajorResponse = client.GetAsync($"Scholar/GetMajors").Result;
        //             if (MajorResponse.IsSuccessStatusCode)
        //             {
        //                 ManageBaseInfoViewModel mbivm = new ManageBaseInfoViewModel() { TblId = 4, Majors = MajorResponse.Content.ReadAsAsync<List<MajorDTO>>().Result };
        //                 html = JsonResults.RenderViewToString(this.ControllerContext, "_BaseInfoTables", mbivm);
        //             }
        //         }
        //         else
        //             message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        //     }
        // }
        // return Json(new JsonResults() { HasValue = state, Message = message, Html = html, AltProp = major.NidMajor.ToString() });
    }
    public function SubmitOreintationForm(Request $oreintation)
    {
        // bool state = false;
        // string message = "";
        // string html = "";
        // if (oreintation.NidOreintation == Guid.Empty)//add
        // {
        //     using (var client = new HttpClient())
        //     {
        //         client.BaseAddress = new Uri(ApiBaseAddress);
        //         client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //         oreintation.NidOreintation = Guid.NewGuid();
        //         var response = client.PostAsJsonAsync("BaseInfo/AddOreintation", oreintation).Result;
        //         if (response.IsSuccessStatusCode)
        //         {
        //             state = true;
        //             message = $"گرایش با نام {oreintation.Title} با موفقیت ایجاد گردید";
        //             ManageBaseInfoViewModel mbivm = new ManageBaseInfoViewModel();
        //             mbivm.TblId = 5;
        //             HttpResponseMessage MajorResponse = client.GetAsync($"Scholar/GetMajors").Result;
        //             if (MajorResponse.IsSuccessStatusCode)
        //             {
        //                 mbivm.Majors = MajorResponse.Content.ReadAsAsync<List<MajorDTO>>().Result;
        //             }
        //             HttpResponseMessage OreintationResponse = client.GetAsync($"Scholar/GetOrientations").Result;
        //             if (OreintationResponse.IsSuccessStatusCode)
        //             {
        //                 mbivm.Oreintations = OreintationResponse.Content.ReadAsAsync<List<OreintationDTO>>().Result;
        //                 html = JsonResults.RenderViewToString(this.ControllerContext, "_BaseInfoTables", mbivm);
        //             }
        //         }
        //         else
        //             message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        //     }
        // }
        // else //edit
        // {
        //     using (var client = new HttpClient())
        //     {
        //         client.BaseAddress = new Uri(ApiBaseAddress);
        //         client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //         var response = client.PostAsJsonAsync("BaseInfo/UpdateOreintation", oreintation).Result;
        //         if (response.IsSuccessStatusCode)
        //         {
        //             state = true;
        //             message = $"گرایش با نام {oreintation.Title} با موفقیت ویرایش گردید";
        //             ManageBaseInfoViewModel mbivm = new ManageBaseInfoViewModel();
        //             mbivm.TblId = 5;
        //             HttpResponseMessage MajorResponse = client.GetAsync($"Scholar/GetMajors").Result;
        //             if (MajorResponse.IsSuccessStatusCode)
        //             {
        //                 mbivm.Majors = MajorResponse.Content.ReadAsAsync<List<MajorDTO>>().Result;
        //             }
        //             HttpResponseMessage OreintationResponse = client.GetAsync($"Scholar/GetOrientations").Result;
        //             if (OreintationResponse.IsSuccessStatusCode)
        //             {
        //                 mbivm.Oreintations = OreintationResponse.Content.ReadAsAsync<List<OreintationDTO>>().Result;
        //                 html = JsonResults.RenderViewToString(this.ControllerContext, "_BaseInfoTables", mbivm);
        //             }
        //         }
        //         else
        //             message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        //     }
        // }
        // return Json(new JsonResults() { HasValue = state, Message = message, Html = html });
    }
    public function SubmitCollegeForm(Request $college)
    {
        // bool state = false;
        // string message = "";
        // string html = "";
        // if (college.NidSetting == Guid.Empty)//add
        // {
        //     using (var client = new HttpClient())
        //     {
        //         client.BaseAddress = new Uri(ApiBaseAddress);
        //         client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //         college.NidSetting = Guid.NewGuid();
        //         var Valueresponse = client.GetAsync($"BaseInfo/GenerateSettingValue?index=2").Result;
        //         if (Valueresponse.IsSuccessStatusCode)
        //             college.SettingValue = Valueresponse.Content.ReadAsAsync<JsonResults>().Result.Message;
        //         var response = client.PostAsJsonAsync("BaseInfo/AddSetting", college).Result;
        //         if (response.IsSuccessStatusCode)
        //         {
        //             state = true;
        //             message = $"دانشکده با نام {college.SettingTitle} با موفقیت ایجاد گردید";
        //             HttpResponseMessage collegeResponse = client.GetAsync($"Scholar/GetColleges").Result;
        //             if (collegeResponse.IsSuccessStatusCode)
        //             {
        //                 ManageBaseInfoViewModel mbivm = new ManageBaseInfoViewModel() { TblId = 6, Colleges = collegeResponse.Content.ReadAsAsync<List<Setting>>().Result };
        //                 html = JsonResults.RenderViewToString(this.ControllerContext, "_BaseInfoTables", mbivm);
        //             }
        //         }
        //         else
        //             message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        //     }
        // }
        // else //edit
        // {
        //     using (var client = new HttpClient())
        //     {
        //         client.BaseAddress = new Uri(ApiBaseAddress);
        //         client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //         var response = client.PostAsJsonAsync("BaseInfo/UpdateSetting", college).Result;
        //         if (response.IsSuccessStatusCode)
        //         {
        //             state = true;
        //             message = $"دانشکده با نام {college.SettingTitle} با موفقیت ویرایش گردید";
        //             HttpResponseMessage collegeResponse = client.GetAsync($"Scholar/GetColleges").Result;
        //             if (collegeResponse.IsSuccessStatusCode)
        //             {
        //                 ManageBaseInfoViewModel mbivm = new ManageBaseInfoViewModel() { TblId = 6, Colleges = collegeResponse.Content.ReadAsAsync<List<Setting>>().Result };
        //                 html = JsonResults.RenderViewToString(this.ControllerContext, "_BaseInfoTables", mbivm);
        //             }
        //         }
        //         else
        //             message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        //     }
        // }
        // return Json(new JsonResults() { HasValue = state, Message = message, Html = html });
    }
    public function SubmitMillitForm(Request $millit)
    {
        // bool state = false;
        // string message = "";
        // string html = "";
        // if (millit.NidSetting == Guid.Empty)//add
        // {
        //     using (var client = new HttpClient())
        //     {
        //         client.BaseAddress = new Uri(ApiBaseAddress);
        //         client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //         millit.NidSetting = Guid.NewGuid();
        //         var Valueresponse = client.GetAsync($"BaseInfo/GenerateSettingValue?index=3").Result;
        //         if (Valueresponse.IsSuccessStatusCode)
        //             millit.SettingValue = Valueresponse.Content.ReadAsAsync<JsonResults>().Result.Message;
        //         var response = client.PostAsJsonAsync("BaseInfo/AddSetting", millit).Result;
        //         if (response.IsSuccessStatusCode)
        //         {
        //             state = true;
        //             message = $"وضعیت خدمتی با نام {millit.SettingTitle} با موفقیت ایجاد گردید";
        //             HttpResponseMessage millitResponse = client.GetAsync($"Scholar/GetMillitaryStatuses").Result;
        //             if (millitResponse.IsSuccessStatusCode)
        //             {
        //                 ManageBaseInfoViewModel mbivm = new ManageBaseInfoViewModel() { TblId = 7, MillitaryStatuses = millitResponse.Content.ReadAsAsync<List<Setting>>().Result };
        //                 html = JsonResults.RenderViewToString(this.ControllerContext, "_BaseInfoTables", mbivm);
        //             }
        //         }
        //         else
        //             message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        //     }
        // }
        // else //edit
        // {
        //     using (var client = new HttpClient())
        //     {
        //         client.BaseAddress = new Uri(ApiBaseAddress);
        //         client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //         var response = client.PostAsJsonAsync("BaseInfo/UpdateSetting", millit).Result;
        //         if (response.IsSuccessStatusCode)
        //         {
        //             state = true;
        //             message = $"وضعیت خدمتی با نام {millit.SettingTitle} با موفقیت ویرایش گردید";
        //             HttpResponseMessage millitResponse = client.GetAsync($"Scholar/GetMillitaryStatuses").Result;
        //             if (millitResponse.IsSuccessStatusCode)
        //             {
        //                 ManageBaseInfoViewModel mbivm = new ManageBaseInfoViewModel() { TblId = 7, MillitaryStatuses = millitResponse.Content.ReadAsAsync<List<Setting>>().Result };
        //                 html = JsonResults.RenderViewToString(this.ControllerContext, "_BaseInfoTables", mbivm);
        //             }
        //         }
        //         else
        //             message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        //     }
        // }
        // return Json(new JsonResults() { HasValue = state, Message = message, Html = html });
    }
    public function SubmitCollabForm(Request $collab)
    {
        // bool state = false;
        // string message = "";
        // string html = "";
        // if (collab.NidSetting == Guid.Empty)//add
        // {
        //     using (var client = new HttpClient())
        //     {
        //         client.BaseAddress = new Uri(ApiBaseAddress);
        //         client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //         collab.NidSetting = Guid.NewGuid();
        //         var Valueresponse = client.GetAsync($"BaseInfo/GenerateSettingValue?index=4").Result;
        //         if (Valueresponse.IsSuccessStatusCode)
        //             collab.SettingValue = Valueresponse.Content.ReadAsAsync<JsonResults>().Result.Message;
        //         var response = client.PostAsJsonAsync("BaseInfo/AddSetting", collab).Result;
        //         if (response.IsSuccessStatusCode)
        //         {
        //             state = true;
        //             message = $"نوع همکاری با نام {collab.SettingTitle} با موفقیت ایجاد گردید";
        //             HttpResponseMessage collabResponse = client.GetAsync($"Scholar/GetCollaborationTypes").Result;
        //             if (collabResponse.IsSuccessStatusCode)
        //             {
        //                 ManageBaseInfoViewModel mbivm = new ManageBaseInfoViewModel() { TblId = 8, CollaborationTypes = collabResponse.Content.ReadAsAsync<List<Setting>>().Result };
        //                 html = JsonResults.RenderViewToString(this.ControllerContext, "_BaseInfoTables", mbivm);
        //             }
        //         }
        //         else
        //             message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        //     }
        // }
        // else //edit
        // {
        //     using (var client = new HttpClient())
        //     {
        //         client.BaseAddress = new Uri(ApiBaseAddress);
        //         client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //         var response = client.PostAsJsonAsync("BaseInfo/UpdateSetting", collab).Result;
        //         if (response.IsSuccessStatusCode)
        //         {
        //             state = true;
        //             message = $"نوع همکاری با نام {collab.SettingTitle} با موفقیت ویرایش گردید";
        //             HttpResponseMessage collabResponse = client.GetAsync($"Scholar/GetCollaborationTypes").Result;
        //             if (collabResponse.IsSuccessStatusCode)
        //             {
        //                 ManageBaseInfoViewModel mbivm = new ManageBaseInfoViewModel() { TblId = 8, CollaborationTypes = collabResponse.Content.ReadAsAsync<List<Setting>>().Result };
        //                 html = JsonResults.RenderViewToString(this.ControllerContext, "_BaseInfoTables", mbivm);
        //             }
        //         }
        //         else
        //             message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        //     }
        // }
        // return Json(new JsonResults() { HasValue = state, Message = message, Html = html });
    }
    public function SubmitDeleteUnit(string $NidUnit)
    {
        // bool state = false;
        // string message = "";
        // string html = "";
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     var response = client.GetAsync($"BaseInfo/DeleteUnit?NidUnit={NidUnit}").Result;
        //     if (response.IsSuccessStatusCode)
        //     {
        //         JsonResults res = response.Content.ReadAsAsync<JsonResults>().Result;
        //         switch (res.Message)
        //         {
        //             case "1":
        //                 message = "یگان مورد نظر دارای گروه می باشد.امکان حذف وجود ندارد";
        //                 break;
        //             case "2":
        //                 state = true;
        //                 message = "یگان با موفقیت حذف گردید";
        //                 HttpResponseMessage UnitResponse = client.GetAsync($"Project/GetAllUnits").Result;
        //                 if (UnitResponse.IsSuccessStatusCode)
        //                 {
        //                     ManageBaseInfoViewModel mbivm = new ManageBaseInfoViewModel() { TblId = 1, Units = UnitResponse.Content.ReadAsAsync<List<UnitDTO>>().Result };
        //                     html = JsonResults.RenderViewToString(this.ControllerContext, "_BaseInfoTables", mbivm);
        //                 }
        //                 break;
        //             case "3":
        //                 message = "خطا در سرور لطفا مجددا امتحان کنید";
        //                 break;
        //         }
        //     }
        //     else
        //         message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        // }
        // return Json(new JsonResults() { HasValue = state, Message = message, Html = html });
    }
    public function SubmitDeleteUnitGroup(string $NidUnitGroup)
    {
        // bool state = false;
        // string message = "";
        // string html = "";
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     var response = client.GetAsync($"BaseInfo/DeleteUnitGroup?NidUnitGroup={NidUnitGroup}").Result;
        //     if (response.IsSuccessStatusCode)
        //     {
        //         JsonResults res = response.Content.ReadAsAsync<JsonResults>().Result;
        //         if(res.HasValue)
        //         {
        //             state = true;
        //             message = "گروه با موفقیت حذف گردید";
        //             HttpResponseMessage UnitResponse = client.GetAsync($"Project/GetAllUnits").Result;
        //             ManageBaseInfoViewModel mbivm = new ManageBaseInfoViewModel();
        //             mbivm.TblId = 2;
        //             if (UnitResponse.IsSuccessStatusCode)
        //             {
        //                 mbivm.Units = UnitResponse.Content.ReadAsAsync<List<UnitDTO>>().Result;
        //             }
        //             HttpResponseMessage UnitGroupResponse = client.GetAsync($"Project/GetAllUnitGroups").Result;
        //             if (UnitGroupResponse.IsSuccessStatusCode)
        //             {
        //                 mbivm.UnitGroups = UnitGroupResponse.Content.ReadAsAsync<List<UnitGroupDTO>>().Result;
        //                 html = JsonResults.RenderViewToString(this.ControllerContext, "_BaseInfoTables", mbivm);
        //             }
        //         }
        //         else
        //             message = "خطا در سرور. لطفا مجددا امتحان کنید";
        //     }
        //     else
        //         message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        // }
        // return Json(new JsonResults() { HasValue = state, Message = message, Html = html });
    }
    public function SubmitDeleteGrade(string $NidGrade)
    {
        // bool state = false;
        // string message = "";
        // string html = "";
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     var response = client.GetAsync($"BaseInfo/DeleteSetting?NidSetting={NidGrade}").Result;
        //     if (response.IsSuccessStatusCode)
        //     {
        //         JsonResults res = response.Content.ReadAsAsync<JsonResults>().Result;
        //         if (res.HasValue)
        //         {
        //             state = true;
        //             message = "مقطع تحصیلی با موفقیت حذف گردید";
        //             HttpResponseMessage GradeResponse = client.GetAsync($"Scholar/GetGrades").Result;
        //             if (GradeResponse.IsSuccessStatusCode)
        //             {
        //                 ManageBaseInfoViewModel mbivm = new ManageBaseInfoViewModel() { TblId = 3, Grades = GradeResponse.Content.ReadAsAsync<List<Setting>>().Result };
        //                 html = JsonResults.RenderViewToString(this.ControllerContext, "_BaseInfoTables", mbivm);
        //             }
        //         }
        //         else
        //             message = "خطا در سرور. لطفا مجددا امتحان کنید";
        //     }
        //     else
        //         message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        // }
        // return Json(new JsonResults() { HasValue = state, Message = message, Html = html });
    }
    public function SubmitDeleteMajor(string $NidMajor)
    {
        // bool state = false;
        // string message = "";
        // string html = "";
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     var response = client.GetAsync($"BaseInfo/DeleteMajor?NidMajor={NidMajor}").Result;
        //     if (response.IsSuccessStatusCode)
        //     {
        //         JsonResults res = response.Content.ReadAsAsync<JsonResults>().Result;
        //         switch (res.Message)
        //         {
        //             case "1":
        //                 message = "رشته تحصیلی مورد نظر دارای گرایش می باشد.امکان حذف وجود ندارد";
        //                 break;
        //             case "2":
        //                 state = true;
        //                 message = "رشته تحصیلی با موفقیت حذف گردید";
        //                 HttpResponseMessage MajorResponse = client.GetAsync($"Scholar/GetMajors").Result;
        //                 if (MajorResponse.IsSuccessStatusCode)
        //                 {
        //                     ManageBaseInfoViewModel mbivm = new ManageBaseInfoViewModel() { TblId = 4, Majors = MajorResponse.Content.ReadAsAsync<List<MajorDTO>>().Result };
        //                     html = JsonResults.RenderViewToString(this.ControllerContext, "_BaseInfoTables", mbivm);
        //                 }
        //                 break;
        //             case "3":
        //                 message = "خطا در سرور لطفا مجددا امتحان کنید";
        //                 break;
        //         }
        //     }
        //     else
        //         message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        // }
        // return Json(new JsonResults() { HasValue = state, Message = message, Html = html });
    }
    public function SubmitDeleteOreintation(string $NidOreintation)
    {
        // bool state = false;
        // string message = "";
        // string html = "";
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     var response = client.GetAsync($"BaseInfo/DeleteOreintation?NidOreintation={NidOreintation}").Result;
        //     if (response.IsSuccessStatusCode)
        //     {
        //         JsonResults res = response.Content.ReadAsAsync<JsonResults>().Result;
        //         if (res.HasValue)
        //         {
        //             state = true;
        //             message = "گرایش با موفقیت حذف گردید";
        //             ManageBaseInfoViewModel mbivm = new ManageBaseInfoViewModel();
        //             mbivm.TblId = 5;
        //             HttpResponseMessage MajorResponse = client.GetAsync($"Scholar/GetMajors").Result;
        //             if (MajorResponse.IsSuccessStatusCode)
        //             {
        //                 mbivm.Majors = MajorResponse.Content.ReadAsAsync<List<MajorDTO>>().Result;
        //             }
        //             HttpResponseMessage OreintationResponse = client.GetAsync($"Scholar/GetOrientations").Result;
        //             if (OreintationResponse.IsSuccessStatusCode)
        //             {
        //                 mbivm.Oreintations = OreintationResponse.Content.ReadAsAsync<List<OreintationDTO>>().Result;
        //                 html = JsonResults.RenderViewToString(this.ControllerContext, "_BaseInfoTables", mbivm);
        //             }
        //         }
        //         else
        //             message = "خطا در سرور. لطفا مجددا امتحان کنید";
        //     }
        //     else
        //         message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        // }
        // return Json(new JsonResults() { HasValue = state, Message = message, Html = html });
    }
    public function SubmitDeleteCollege(string $NidCollege)
    {
        // bool state = false;
        // string message = "";
        // string html = "";
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     var response = client.GetAsync($"BaseInfo/DeleteSetting?NidSetting={NidCollege}").Result;
        //     if (response.IsSuccessStatusCode)
        //     {
        //         JsonResults res = response.Content.ReadAsAsync<JsonResults>().Result;
        //         if (res.HasValue)
        //         {
        //             state = true;
        //             message = "دانشکده با موفقیت حذف گردید";
        //             HttpResponseMessage collegeResponse = client.GetAsync($"Scholar/GetColleges").Result;
        //             if (collegeResponse.IsSuccessStatusCode)
        //             {
        //                 ManageBaseInfoViewModel mbivm = new ManageBaseInfoViewModel() { TblId = 6, Colleges = collegeResponse.Content.ReadAsAsync<List<Setting>>().Result };
        //                 html = JsonResults.RenderViewToString(this.ControllerContext, "_BaseInfoTables", mbivm);
        //             }
        //         }
        //         else
        //             message = "خطا در سرور. لطفا مجددا امتحان کنید";
        //     }
        //     else
        //         message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        // }
        // return Json(new JsonResults() { HasValue = state, Message = message, Html = html });
    }
    public function SubmitDeleteMillit(string $NidMillit)
    {
        // bool state = false;
        // string message = "";
        // string html = "";
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     var response = client.GetAsync($"BaseInfo/DeleteSetting?NidSetting={NidMillit}").Result;
        //     if (response.IsSuccessStatusCode)
        //     {
        //         JsonResults res = response.Content.ReadAsAsync<JsonResults>().Result;
        //         if (res.HasValue)
        //         {
        //             state = true;
        //             message = "وضعیت خدمت با موفقیت حذف گردید";
        //             HttpResponseMessage millitResponse = client.GetAsync($"Scholar/GetMillitaryStatuses").Result;
        //             if (millitResponse.IsSuccessStatusCode)
        //             {
        //                 ManageBaseInfoViewModel mbivm = new ManageBaseInfoViewModel() { TblId = 7, MillitaryStatuses = millitResponse.Content.ReadAsAsync<List<Setting>>().Result };
        //                 html = JsonResults.RenderViewToString(this.ControllerContext, "_BaseInfoTables", mbivm);
        //             }
        //         }
        //         else
        //             message = "خطا در سرور. لطفا مجددا امتحان کنید";
        //     }
        //     else
        //         message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        // }
        // return Json(new JsonResults() { HasValue = state, Message = message, Html = html });
    }
    public function SubmitDeleteCollab(string $NidCollab)
    {
        // bool state = false;
        // string message = "";
        // string html = "";
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     var response = client.GetAsync($"BaseInfo/DeleteSetting?NidSetting={NidCollab}").Result;
        //     if (response.IsSuccessStatusCode)
        //     {
        //         JsonResults res = response.Content.ReadAsAsync<JsonResults>().Result;
        //         if (res.HasValue)
        //         {
        //             state = true;
        //             message = "نوع همکاری با موفقیت حذف گردید";
        //             HttpResponseMessage collabResponse = client.GetAsync($"Scholar/GetCollaborationTypes").Result;
        //             if (collabResponse.IsSuccessStatusCode)
        //             {
        //                 ManageBaseInfoViewModel mbivm = new ManageBaseInfoViewModel() { TblId = 8, CollaborationTypes = collabResponse.Content.ReadAsAsync<List<Setting>>().Result };
        //                 html = JsonResults.RenderViewToString(this.ControllerContext, "_BaseInfoTables", mbivm);
        //             }
        //         }
        //         else
        //             message = "خطا در سرور. لطفا مجددا امتحان کنید";
        //     }
        //     else
        //         message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        // }
        // return Json(new JsonResults() { HasValue = state, Message = message, Html = html });
    }
}
