<?php

namespace App\Http\Controllers;

use App\DTOs\DataMapper;
use App\Http\Controllers\Api\NPMSController;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\TitleRequest;
use App\Models\Projects;
use App\Models\Scholars;
use Illuminate\Http\Request;
use resources\ViewModels\ManageBaseInfoViewModel;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('XSS');
    }
    public function Projects(Request $request)
    {
        try
        {
            $api = new NPMSController();
            $Projects = $api->GetAllProjectInitials();
            $api->AddLog(auth()->user(),$request->ip(),1,0,1,1,"مدیریت طرح ها");
            return view('Project.Projects',compact('Projects'));
        }catch(\Exception $e)
        {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function AddProject(Request $request)
    {
        $api = new NPMSController();
        $Scholars = $api->GetAllProjectScholars();
        $UnitGroups = $api->GetAllUnitGroups();
        $Units = $api->GetAllUnits();
        $api->AddLog(auth()->user(),$request->ip(),1,0,2,1,"ایجاد طرح");
        return view('Project.AddProject',compact('Scholars','UnitGroups','Units'));
    }
    public function SubmitAddProject(ProjectRequest $Project)
    {
        $Project->validated();
        $api = new NPMSController();
        $result = new JsonResults();
        if($api->AddProject($Project))
        {
            $result->HasValue = true;
            $api->AddLog(auth()->user(),$Project->ip(),2,0,3,1,"ایجاد طرح موفق");
            return response()->json($result);
        }else
        {
            $result->HasValue = false;
            $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
            $api->AddLog(auth()->user(),$Project->ip(),2,1,3,1,"ایجاد طرح ناموفق");
            return response()->json($result);
        }
    }
    public function ProjectDetail(string $NidProject,Request $request)
    {
        $api = new NPMSController();
        $Project = $api->GetProjectDetailDTOById($NidProject);
        $Scholar = $api->GetAllScholarDetails($Project->ScholarId);
        $api->AddLog(auth()->user(),$request->ip(),1,0,2,1,"جزییات طرح");
        return view('Project.ProjectDetail',compact('Project','Scholar'));
    }
    public function ProjectProgress(string $NidProject,Request $request)
    {
        $api = new NPMSController();
        $Scholars = $api->GetAllProjectScholars();
        $UnitGroups = $api->GetAllUnitGroups();
        $Units = $api->GetAllUnits();
        $Project = $api->GetProjectDTOById($NidProject);
        $api->AddLog(auth()->user(),$request->ip(),1,0,2,1,"پیشرفت طرح");
        return view('Project.ProjectProgress',compact('Scholars','UnitGroups','Units','Project'));
    }
    public function UpdateProject(ProjectRequest $Project)
    {
        $Project->validated();
        $api = new NPMSController();
        $result = new JsonResults();
        if($api->ProjectProgress($Project))
        {
            $result->HasValue = true;
            $result->Message = "طرح با موفقیت ویرایش گردید";
            $api->AddLog(auth()->user(),$Project->ip(),3,0,3,1,"پیشرفت طرح موفق");
            return response()->json($result);
        }else
        {
            $result->HasValue = false;
            $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
            $api->AddLog(auth()->user(),$Project->ip(),3,1,3,1,"پیشرفت طرح ناموفق");
            return response()->json($result);
        }
        // return $Project;
    }
    public function ManageBaseInfo(Request $request)
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
        $api->AddLog(auth()->user(),$request->ip(),1,0,1,1,"مدیریت اطلاعات پایه");
        return view('Project.ManageBaseInfo',compact('UnitGroups','Units','Majors','CollaborationTypes','MillitaryStatuses','Oreintations','Colleges','Grades'));
    }
    public function SubmitUnitForm(TitleRequest $unit)
    {
        $unit->validated();
        $api = new NPMSController();
        $result = new JsonResults();
        if(empty($unit->NidUnit))
        {
            $unitname = $api->AddUnit($unit);
            $api->AddLog(auth()->user(),$unit->ip(),4,0,3,1,"ایجاد اطلاعات پایه موفق");
            $result->Message = sprintf("یگان با نام %s با موفقیت ایجاد گردید",$unit->Title);
        }else
        {
            $unitname = $api->UpdateUnit($unit);
            $api->AddLog(auth()->user(),$unit->ip(),5,0,3,1,"ویرایش اطلاعات پایه موفق");
            $result->Message = sprintf("یگان با نام %s با موفقیت ویرایش گردید",$unit->Title);
        }
        $TblId = 1;
        $Units = $api->GetAllUnits();
        $result->Html = view('Project._BaseInfoTables',compact('TblId','Units'))->render();
        $result->HasValue = true;
        $result->AltProp = $unit->NidUnit;
        return response()->json($result);
    }
    public function SubmitUnitGroupForm(TitleRequest $unitGroup)
    {
        $unitGroup->validated();
        $api = new NPMSController();
        $result = new JsonResults();
        if(empty($unitGroup->NidGroup))
        {
            $unitgroupname = $api->AddUnitGroup($unitGroup);
            $api->AddLog(auth()->user(),$unitGroup->ip(),4,0,3,1,"ایجاد اطلاعات پایه موفق");
            $result->Message = sprintf("گروه با نام %s با موفقیت ایجاد گردید",$unitGroup->Title);
        }else
        {
            $unitgroupname = $api->UpdateUnitGroup($unitGroup);
            $api->AddLog(auth()->user(),$unitGroup->ip(),5,0,3,1,"ویرایش اطلاعات پایه موفق");
            $result->Message = sprintf("گروه با نام %s با موفقیت ویرایش گردید",$unitGroup->Title);
        }
        $TblId = 2;
        $Units = $api->GetAllUnits();
        $UnitGroups = $api->GetAllUnitGroups();
        $result->Html = view('Project._BaseInfoTables',compact('TblId','Units','UnitGroups'))->render();
        $result->HasValue = true;
        // $result->AltProp = $unit->NidUnit;
        return response()->json($result);
    }
    public function SubmitGradeForm(Request $grade)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        if(empty($grade->NidSetting))
        {
            $grade->SettingValue = $api->GenerateSettingValue(1);
            if($api->AddSetting($grade))
            {
                $result->Message = sprintf("مقطع تحصیلی با نام %s با موفقیت ایجاد گردید",$grade->SettingTitle);
                $api->AddLog(auth()->user(),$grade->ip(),4,0,3,1,"ایجاد اطلاعات پایه موفق");
            }else
            {
                $result->HasValue = false;
                $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
                $api->AddLog(auth()->user(),$grade->ip(),4,1,3,1,"ایجاد اطلاعات پایه ناموفق");
                return response()->json($result);
            }
        }else
        {
            $grade->IsDeleted = false;
            if($api->UpdateSetting($grade))
            {
                $result->Message = sprintf("مقطع تحصیلی با نام %s با موفقیت ویرایش گردید",$grade->SettingTitle);
                $api->AddLog(auth()->user(),$grade->ip(),5,0,3,1,"ویرایش اطلاعات پایه موفق");
            }else
            {
                $result->HasValue = false;
                $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
                $api->AddLog(auth()->user(),$grade->ip(),5,1,3,1,"ویرایش اطلاعات پایه ناموفق");
                return response()->json($result);
            }
        }
        $TblId = 3;
        $Grades = $api->GetGrades();
        $result->Html = view('Project._BaseInfoTables',compact('TblId','Grades'))->render();
        $result->HasValue = true;
        return response()->json($result);
    }
    public function SubmitMajorForm(TitleRequest $major)
    {
        $major->validated();
        $api = new NPMSController();
        $result = new JsonResults();
        if(empty($major->NidMajor))
        {
            $api->AddMajor($major);
            $result->Message = sprintf("رشته تحصیلی با نام %s با موفقیت ایجاد گردید",$major->Title);
            $api->AddLog(auth()->user(),$major->ip(),4,0,3,1,"ایجاد اطلاعات پایه موفق");
        }else
        {
            $api->UpdateMajor($major);
            $result->Message = sprintf("رشته تحصیلی با نام %s با موفقیت ویرایش گردید",$major->Title);
            $api->AddLog(auth()->user(),$major->ip(),5,0,3,1,"ویرایش اطلاعات پایه موفق");
        }
        $TblId = 4;
        $Majors = $api->GetMajors();
        $result->Html = view('Project._BaseInfoTables',compact('TblId','Majors'))->render();
        $result->HasValue = true;
        $result->AltProp = $major->NidMajor;
        return response()->json($result);
    }
    public function SubmitOreintationForm(TitleRequest $oreintation)
    {
        $oreintation->validated();
        $api = new NPMSController();
        $result = new JsonResults();
        if(empty($oreintation->NidOreintation))
        {
            $api->AddOreintation($oreintation);
            $result->Message = sprintf("گرایش با نام %s با موفقیت ایجاد گردید",$oreintation->Title);
            $api->AddLog(auth()->user(),$oreintation->ip(),4,0,3,1,"ایجاد اطلاعات پایه موفق");

        }else
        {
            $api->UpdateOreintation($oreintation);
            $result->Message = sprintf("گرایش با نام %s با موفقیت ویرایش گردید",$oreintation->Title);
            $api->AddLog(auth()->user(),$oreintation->ip(),5,0,3,1,"ویرایش اطلاعات پایه موفق");
        }
        $TblId = 5;
        $Majors = $api->GetMajors();
        $Oreintations = $api->GetOrientations();
        $result->Html = view('Project._BaseInfoTables',compact('TblId','Majors','Oreintations'))->render();
        $result->HasValue = true;
        return response()->json($result);
    }
    public function SubmitCollegeForm(Request $college)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        if(empty($college->NidSetting))
        {
            $college->SettingValue = $api->GenerateSettingValue(2);
            if($api->AddSetting($college))
            {
                $result->Message = sprintf("دانشکده با نام %s با موفقیت ایجاد گردید",$college->SettingTitle);
                $api->AddLog(auth()->user(),$college->ip(),4,0,3,1,"ایجاد اطلاعات پایه موفق");
            }else
            {
                $result->HasValue = false;
                $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
                $api->AddLog(auth()->user(),$college->ip(),4,1,3,1,"ایجاد اطلاعات پایه ناموفق");
                return response()->json($result);
            }
        }else
        {
            $college->IsDeleted = false;
            if($api->UpdateSetting($college))
            {
                $result->Message = sprintf("دانشکده با نام %s با موفقیت ویرایش گردید",$college->SettingTitle);
                $api->AddLog(auth()->user(),$college->ip(),5,0,3,1,"ویرایش اطلاعات پایه موفق");
            }else
            {
                $result->HasValue = false;
                $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
                $api->AddLog(auth()->user(),$college->ip(),5,1,3,1,"ویرایش اطلاعات پایه ناموفق");
                return response()->json($result);
            }
        }
        $TblId = 6;
        $Colleges = $api->GetColleges();
        $result->Html = view('Project._BaseInfoTables',compact('TblId','Colleges'))->render();
        $result->HasValue = true;
        return response()->json($result);
    }
    public function SubmitMillitForm(Request $millit)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        if(empty($millit->NidSetting))
        {
            $millit->SettingValue = $api->GenerateSettingValue(3);
            if($api->AddSetting($millit))
            {
                $result->Message = sprintf("وضعیت خدمت با نام %s با موفقیت ایجاد گردید",$millit->SettingTitle);
                $api->AddLog(auth()->user(),$millit->ip(),4,0,3,1,"ایجاد اطلاعات پایه موفق");
            }else
            {
                $result->HasValue = false;
                $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
                $api->AddLog(auth()->user(),$millit->ip(),4,1,3,1,"ایجاد اطلاعات پایه ناموفق");
                return response()->json($result);
            }
        }else
        {
            $millit->IsDeleted = false;
            if($api->UpdateSetting($millit))
            {
                $result->Message = sprintf("وضعیت خدمت با نام %s با موفقیت ویرایش گردید",$millit->SettingTitle);
                $api->AddLog(auth()->user(),$millit->ip(),5,0,3,1,"ویرایش اطلاعات پایه موفق");
            }else
            {
                $result->HasValue = false;
                $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
                $api->AddLog(auth()->user(),$millit->ip(),5,1,3,1,"ویرایش اطلاعات پایه ناموفق");
                return response()->json($result);
            }
        }
        $TblId = 7;
        $MillitaryStatuses = $api->GetMillitaryStatuses();
        $result->Html = view('Project._BaseInfoTables',compact('TblId','MillitaryStatuses'))->render();
        $result->HasValue = true;
        return response()->json($result);
    }
    public function SubmitCollabForm(Request $collab)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        if(empty($collab->NidSetting))
        {
            $collab->SettingValue = $api->GenerateSettingValue(4);
            if($api->AddSetting($collab))
            {
                $result->Message = sprintf("نوع همکاری با نام %s با موفقیت ایجاد گردید",$collab->SettingTitle);
                $api->AddLog(auth()->user(),$collab->ip(),4,0,3,1,"ایجاد اطلاعات پایه موفق");
            }else
            {
                $result->HasValue = false;
                $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
                $api->AddLog(auth()->user(),$collab->ip(),4,1,3,1,"ایجاد اطلاعات پایه ناموفق");
                return response()->json($result);
            }
        }else
        {
            $collab->IsDeleted = false;
            if($api->UpdateSetting($collab))
            {
                $result->Message = sprintf("نوع همکاری با نام %s با موفقیت ویرایش گردید",$collab->SettingTitle);
                $api->AddLog(auth()->user(),$collab->ip(),5,0,3,1,"ویرایش اطلاعات پایه موفق");
            }else
            {
                $result->HasValue = false;
                $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
                $api->AddLog(auth()->user(),$collab->ip(),5,1,3,1,"ویرایش اطلاعات پایه ناموفق");
                return response()->json($result);
            }
        }
        $TblId = 8;
        $CollaborationTypes = $api->GetCollaborationTypes();
        $result->Html = view('Project._BaseInfoTables',compact('TblId','CollaborationTypes'))->render();
        $result->HasValue = true;
        return response()->json($result);
    }
    public function SubmitDeleteUnit(string $NidUnit,Request $request)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $tmpResult = $api->DeleteUnit($NidUnit);
        $tmpstatus = json_decode($tmpResult->getContent(),true)['Message'];
        $result->HasValue = false;
        switch($tmpstatus)
        {
            case "1":
                $result->Message = "یگان مورد نظر دارای گروه می باشد.امکان حذف وجود ندارد";
                $api->AddLog(auth()->user(),$request->ip(),6,1,3,1,"حذف اطلاعات پایه ناموفق");
                return response()->json($result);
                break;
            case "2":
                $result->HasValue = true;
                $result->Message = "یگان با موفقیت حذف گردید";
                $api->AddLog(auth()->user(),$request->ip(),6,0,3,1,"حذف اطلاعات پایه موفق");
                $TblId = 1;
                $Units = $api->GetAllUnits();
                $result->Html = view('Project._BaseInfoTables',compact('TblId','Units'))->render();
                return response()->json($result);
                break;
            case "3":
                $result->Message = "خطا در سرور لطفا مجددا امتحان کنید";
                $api->AddLog(auth()->user(),$request->ip(),6,1,3,1,"حذف اطلاعات پایه ناموفق");
                return response()->json($result);
                break;
        }
    }
    public function SubmitDeleteUnitGroup(string $NidUnitGroup,Request $request)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $result->HasValue = false;
        $tmpResult = $api->DeleteUnitGroup($NidUnitGroup);
        if(json_decode($tmpResult->getContent(),true)['HasValue'])
        {
            $result->HasValue = true;
            $result->Message = "گروه با موفقیت حذف گردید";
            $api->AddLog(auth()->user(),$request->ip(),6,0,3,1,"حذف اطلاعات پایه موفق");
            $TblId = 2;
            $Units = $api->GetAllUnits();
            $UnitGroups = $api->GetAllUnitGroups();
            $result->Html = view('Project._BaseInfoTables',compact('TblId','Units','UnitGroups'))->render();
            return response()->json($result);
        }else
        {
            $result->Message = "خطا در سرور لطفا مجددا امتحان کنید";
            $api->AddLog(auth()->user(),$request->ip(),6,1,3,1,"حذف اطلاعات پایه ناموفق");
            return response()->json($result);
        }
    }
    public function SubmitDeleteGrade(string $NidGrade,Request $request)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $result->HasValue = false;
        $tmpResult = $api->DeleteSetting($NidGrade);
        if(json_decode($tmpResult->getContent(),true)['HasValue'])
        {
            $result->HasValue = true;
            $result->Message = "مقطع تحصیلی با موفقیت حذف گردید";
            $api->AddLog(auth()->user(),$request->ip(),6,0,3,1,"حذف اطلاعات پایه موفق");
            $TblId = 3;
            $Grades = $api->GetGrades();
            $result->Html = view('Project._BaseInfoTables',compact('TblId','Grades'))->render();
            return response()->json($result);
        }else
        {
            $result->Message = "خطا در سرور لطفا مجددا امتحان کنید";
            $api->AddLog(auth()->user(),$request->ip(),6,1,3,1,"حذف اطلاعات پایه ناموفق");
            return response()->json($result);
        }
    }
    public function SubmitDeleteMajor(string $NidMajor,Request $request)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $tmpResult = $api->DeleteMajor($NidMajor);
        $tmpstatus = json_decode($tmpResult->getContent(),true)['Message'];
        $result->HasValue = false;
        switch($tmpstatus)
        {
            case "1":
                $result->Message = "رشته تحصیلی مورد نظر دارای گرایش می باشد.امکان حذف وجود ندارد";
                return response()->json($result);
                break;
            case "2":
                $result->HasValue = true;
                $result->Message = "رشته تحصیلی با موفقیت حذف گردید";
                $TblId = 4;
                $Majors = $api->GetMajors();
                $result->Html = view('Project._BaseInfoTables',compact('TblId','Majors'))->render();
                return response()->json($result);
                break;
            case "3":
                $result->Message = "خطا در سرور لطفا مجددا امتحان کنید";
                return response()->json($result);
                break;
        }
    }
    public function SubmitDeleteOreintation(string $NidOreintation,Request $request)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $result->HasValue = false;
        $tmpResult = $api->DeleteOreintation($NidOreintation);
        if(json_decode($tmpResult->getContent(),true)['HasValue'])
        {
            $result->HasValue = true;
            $result->Message = "گرایش با موفقیت حذف گردید";
            $api->AddLog(auth()->user(),$request->ip(),6,0,3,1,"حذف اطلاعات پایه موفق");
            $TblId = 5;
            $Majors = $api->GetMajors();
            $Oreintations = $api->GetOrientations();
            $result->Html = view('Project._BaseInfoTables',compact('TblId','Majors','Oreintations'))->render();
            return response()->json($result);
        }else
        {
            $result->Message = "خطا در سرور لطفا مجددا امتحان کنید";
            $api->AddLog(auth()->user(),$request->ip(),6,1,3,1,"حذف اطلاعات پایه ناموفق");
            return response()->json($result);
        }
    }
    public function SubmitDeleteCollege(string $NidCollege,Request $request)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $result->HasValue = false;
        $tmpResult = $api->DeleteSetting($NidCollege);
        if(json_decode($tmpResult->getContent(),true)['HasValue'])
        {
            $result->HasValue = true;
            $result->Message = "دانشکده با موفقیت حذف گردید";
            $api->AddLog(auth()->user(),$request->ip(),6,0,3,1,"حذف اطلاعات پایه موفق");
            $TblId = 6;
            $Colleges = $api->GetColleges();
            $result->Html = view('Project._BaseInfoTables',compact('TblId','Colleges'))->render();
            return response()->json($result);
        }else
        {
            $result->Message = "خطا در سرور لطفا مجددا امتحان کنید";
            $api->AddLog(auth()->user(),$request->ip(),6,1,3,1,"حذف اطلاعات پایه ناموفق");
            return response()->json($result);
        }
    }
    public function SubmitDeleteMillit(string $NidMillit,Request $request)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $result->HasValue = false;
        $tmpResult = $api->DeleteSetting($NidMillit);
        if(json_decode($tmpResult->getContent(),true)['HasValue'])
        {
            $result->HasValue = true;
            $result->Message = "وضعیت خدمت با موفقیت حذف گردید";
            $api->AddLog(auth()->user(),$request->ip(),6,0,3,1,"حذف اطلاعات پایه موفق");
            $TblId = 7;
            $MillitaryStatuses = $api->GetMillitaryStatuses();
            $result->Html = view('Project._BaseInfoTables',compact('TblId','MillitaryStatuses'))->render();
            return response()->json($result);
        }else
        {
            $result->Message = "خطا در سرور لطفا مجددا امتحان کنید";
            $api->AddLog(auth()->user(),$request->ip(),6,1,3,1,"حذف اطلاعات پایه ناموفق");
            return response()->json($result);
        }
    }
    public function SubmitDeleteCollab(string $NidCollab,Request $request)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $result->HasValue = false;
        $tmpResult = $api->DeleteSetting($NidCollab);
        if(json_decode($tmpResult->getContent(),true)['HasValue'])
        {
            $result->HasValue = true;
            $result->Message = "نوع همکاری با موفقیت حذف گردید";
            $api->AddLog(auth()->user(),$request->ip(),6,0,3,1,"حذف اطلاعات پایه موفق");
            $TblId = 8;
            $CollaborationTypes = $api->GetCollaborationTypes();
            $result->Html = view('Project._BaseInfoTables',compact('TblId','CollaborationTypes'))->render();
            return response()->json($result);
        }else
        {
            $result->Message = "خطا در سرور لطفا مجددا امتحان کنید";
            $api->AddLog(auth()->user(),$request->ip(),6,1,3,1,"حذف اطلاعات پایه ناموفق");
            return response()->json($result);
        }
    }
}
