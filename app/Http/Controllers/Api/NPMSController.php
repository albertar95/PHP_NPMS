<?php

namespace App\Http\Controllers\Api;

use App\Domains\Repositories\AlarmRepository;
use App\Domains\Repositories\MessageRepository;
use App\Domains\Repositories\ProjectRepository;
use App\Domains\Repositories\ReportRawData;
use App\Domains\Repositories\ReportRepository;
use App\Domains\Repositories\ScholarRepository;
use App\Domains\Repositories\ScholarRepositoryFactory;
use App\Domains\Repositories\SearchRepository;
use App\Domains\Repositories\UnitRepository;
use App\Domains\Repositories\UserRepository;
use App\DTOs\DataMapper;
use App\DTOs\scholarDTO;
use App\DTOs\unitDTO;
use App\Helpers\Casts;
use App\Http\Controllers\Controller;
use App\Http\Requests\ScholarRequest;
use App\Models\Alarms;
use App\Models\Messages;
use App\Models\Projects;
use App\Models\Reports;
use App\Models\Scholars;
use App\Models\Units;
use App\Models\Users;
use Carbon\Carbon;
use Dflydev\DotAccessData\Data;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
class NPMSController extends Controller
{
    //scholar section
    public function AddScholar(Request $scholar)
    {
        $scholar->NidScholar = Str::uuid();
        $scholar = DataMapper::MapToScholar($scholar);
        $repo = new ScholarRepository(new Scholars());
        return $repo->AddScholar($scholar);
    }
    public function GetCollaborationTypes(bool $IncludeDeleted = false)
    {
        $repo = new ScholarRepository(new Scholars());
        return $repo->GetCollaborationTypes(0,$IncludeDeleted);
    }
    public function GetColleges(bool $IncludeDeleted = false)
    {
        $repo = new ScholarRepository(new Scholars());
        return $repo->GetColleges(0,$IncludeDeleted);
    }
    public function GetGrades(bool $IncludeDeleted = false)
    {
        $repo = new ScholarRepository(new Scholars());
        return $repo->GetGrades(0,$IncludeDeleted);
    }
    public function GetMillitaryStatuses(bool $IncludeDeleted = false)
    {
        $repo = new ScholarRepository(new Scholars());
        return $repo->GetMillitaryStatuses(0,$IncludeDeleted);
    }
    public function GetMajors()
    {
        $repo = new ScholarRepository(new Scholars());
        return $repo->GetMajors(0);
    }
    public function GetOrientations()
    {
        $repo = new ScholarRepository(new Scholars());
        return $repo->GetOreintations(0);
    }
    public function GetScholar(string $ScholarId)
    {
        $repo = new ScholarRepository(new Scholars());
        return $repo->GetScholarById($ScholarId);
    }
    public function GetScholarDTO(string $ScholarId)
    {
        $repo = new ScholarRepository(new Scholars());
        return $repo->GetScholarDTOById($ScholarId);
    }
    public function GetOreintationsByMajorId(string $MajorId)
    {
        $repo = new ScholarRepository(new Scholars());
        return $repo->GetOreintationByMajorId($MajorId);
    }
    public function GetAllScholars(int $Pagesize = 10)
    {
        $repo = new ScholarRepository(new Scholars());
        return $repo->GetScholars($Pagesize);
    }
    public function GetAllScholarLists(int $Pagesize = 10)
    {
        $repo = new ScholarRepository(new Scholars());
        return $repo->GetScholarList($Pagesize);
    }
    public function GetAllScholarDetails(string $ScholarId)
    {
        $repo = new ScholarRepository(new Scholars());
        return $repo->GetScholarDetail($ScholarId);
    }
    public function UpdateScholar(Request $scholar)
    {
        $repo = new ScholarRepository(new Scholars());
        $scholar = DataMapper::MapToScholar($scholar);
        $repo->UpdateScholar($scholar);
        return response()->json(['FirstName'=>$scholar->FirstName,'LastName'=>$scholar->LastName]);
    }
    public function DeleteScholar(string $NidScholar)
    {
        $repo = new ScholarRepository(new Scholars());
        $ProjectCount = $repo->CheckProjectsOfScholar($NidScholar);
        if ($ProjectCount == 0)
        {
            $tmpresult = $repo->DeleteScholar($NidScholar);
            if ($tmpresult)
            return response()->json(['Message'=>'-1','Html'=>'']);//scholar name to add
            else
            return response()->json(['Message'=>'0','Html'=>'']);//scholar name to add
        }
        else
        return response()->json(['Message'=>$ProjectCount,'Html'=>'']);//scholar name to add
    }
    public function GetScholarList(string $ScholarId,bool $IsDeleted = false)
    {
        $repo = new ScholarRepository(new Scholars());
        return $repo->GetScholarListById($ScholarId,$IsDeleted);
        // return $ScholarId;
    }

    //user section
    public function AddUser(Request $User)
    {
        $User->CreateDate = Carbon::now();
        $User->NidUser = Str::uuid();
        $repo = new UserRepository(new Users());
        $User = DataMapper::MapToUser($User);
        $repo->AddUser($User);
        return $User;
    }
    public function GetUserDTOById(string $UserId)
    {
        $repo = new UserRepository(new Users());
        return $repo->GetUserDTOById($UserId);
    }
    public function GetAllUsers()
    {
        $repo = new UserRepository(new Users());
        return $repo->GetUserDTOs(0);
    }
    public function DisableUserById(string $UserId)
    {
        $repo = new UserRepository(new Users());
        return response()->json(['HasValue'=>$repo->DisableUser($UserId)]);
    }
    public function UpdateUser(Request $User)
    {
        $repo = new UserRepository(new Users());
        $User = DataMapper::MapToUser($User);
        return $repo->UpdateUser($User);
    }
    public function GetCustomUsers(int $SourceId)
    {
        $repo = new UserRepository(new Users());
        $repo->GetFilteredUserDTOs($SourceId);
    }
    public function ResetPassword(string $NidUser,string $NewPassword)
    {
        $repo = new UserRepository(new Users());
        $NewPass = $repo->ChangeUserPassword($NidUser, $NewPassword);
        if (!isEmptyOrNullString($NewPass))
        return response()->json(['Message'=>$NewPass,'HasValue'=>true]);
    }
    public function LoginThisUser(string $Username, string $Password)
    {
        $repo = new UserRepository(new Users());
        $repo->LoginUser($Username,$Password);
    }
    public function GetAllUserPermissionUsers()
    {
        $repo = new UserRepository(new Users());
        return $repo->GetUserPermissionUsers(0);
    }
    public function GetUserInPermissionById(string $NidUser)
    {
        $repo = new UserRepository(new Users());
        return $repo->GetUserInPermissionById($NidUser);
    }
    public function GetAllResources()
    {
        $repo = new UserRepository(new Users());
        return $repo->GetResources(0);
    }
    public function GetAllUserPermissions(string $NidUser)
    {
        $repo = new UserRepository(new Users());
        $repo2 = new AlarmRepository(new Alarms());
        // try
        // {
        //     $repo2->HandleAlarmsJob();
        // }
        // catch (\Exception)
        // {
        // }
        return $repo->GetUserPermissions($NidUser);
    }
    public function UpdateUserUserPermissions(string $NidUser,string $Resources)
    {
        $resourceGuids = new Collection();
        if(!is_null($Resources))
        {
            $ResourceArray = explode(',',$Resources);
            foreach ($ResourceArray as $ids)
            {
                $resourceGuids->push(str_replace("'","",$ids));
            }
        }
        $repo = new UserRepository(new Users());
        return $repo->UpdateUserUserPermission($NidUser, $resourceGuids);
    }

    //Project section
    public function GetAllProjectInitials()
    {
        $repo = new ProjectRepository(new Projects());
        return $repo->GetProjectInitials(0);
    }
    public function AddProjectInitial(Request $ProjectInitial,string $NidUser)
    {
        $ProjectInitial->CreateDate = Carbon::now();
        $repo = new ProjectRepository(new Projects());
        $repo2 = new AlarmRepository(new Alarms());
        $ProjectInitial->PersianCreateDate = new Verta($ProjectInitial->CreateDate);
        $ProjectInitial->NidProject = Str::uuid();
        $ProjectInitial->ProjectNumber = $repo->GenerateProjectNumber();
        $ProjectInitial->ProjectStatus = 0;
        $ProjectInitial->UserId = $NidUser;
        $ProjectInitial = DataMapper::MapToProjectInitialDTOFromRequest($ProjectInitial);
        if ($repo->AddProjectInitial($ProjectInitial))
        {
            return $repo2->HandleAlarmsByProjectId($ProjectInitial->NidProject);
        }
    }
    public function ProjectProgress(Request $project)
    {
        $repo = new ProjectRepository(new Projects());
        $repo2 = new AlarmRepository(new Alarms());
        $project = DataMapper::MapToProject($project);
        $project->ProjectStatus = $repo->ProjectStatusCalc($project);
        $res = $repo->UpdateProject($project);
        $repo2->HandleAlarmsByProjectId($project->NidProject);
        return $res;
    }
    public function GetProjectDTOById(string $NidProject)
    {
        $repo = new ProjectRepository(new Projects());
        return $repo->GetProjectDTOById($NidProject);
    }
    public function GetProjectDetailDTOById(string $NidProject)
    {
        $repo = new ProjectRepository(new Projects());
        return $repo->GetProjectDetailDTOById($NidProject);
    }
    public function GetAllUnits()
    {
        $repo = new ProjectRepository(new Projects());
        return $repo->GetUnits(0);
    }
    public function GetAllUnitGroups()
    {
        $repo = new ProjectRepository(new Projects());
        return $repo->GetUnitGroups(0);
    }
    public function GetAllProjectScholars()
    {
        $repo = new ProjectRepository(new Projects());
        return $repo->GetProjectScholars(0);
    }
    public function AddProject(Request $Project)
    {
        $repo = new ProjectRepository(new Projects());
        $repo2 = new AlarmRepository(new Alarms());
        $Project->CreateDate = Carbon::now();
        // $tmpPersian = new Verta($Project->CreateDate);
        $Project->PersianCreateDate = strval(verta($Project->CreateDate));
        $Project->NidProject = Str::uuid();
        $Project->ProjectNumber = $repo->GenerateProjectNumber();
        $Project->ProjectStatus = 0;
        $Project = DataMapper::MapToProject($Project);
        $repo->AddProject($Project);
        $Project->ProjectStatus = $repo->ProjectStatusCalc($Project);
        $repo->UpdateProject($Project);
        return $repo2->HandleAlarmsByProjectId($Project->NidProject);
    }
    public function GetProjectById(string $NidProject)
    {
        $repo = new ProjectRepository(new Projects());
        return $repo->GetProjectById($NidProject);
    }

    //base info section
    public function AddUnit(Request $unit)
    {
        $repo = new ProjectRepository(new Projects());
        $unit->NidUnit = Str::uuid();
        $unit = DataMapper::MapToUnit($unit);
        return $repo->AddUnit($unit);
    }
    public function UpdateUnit(Request $unit)
    {
        $repo = new ProjectRepository(new Projects());
        $unit = DataMapper::MapToUnit($unit);
        return $repo->UpdateUnit($unit);
    }
    public function AddUnitGroup(Request $unitGroup)
    {
        $repo = new ProjectRepository(new Projects());
        $unitGroup->NidGroup = Str::uuid();
        $unitGroup = DataMapper::MapToUnitGroup($unitGroup);
        return $repo->AddUnitGroup($unitGroup);
    }
    public function UpdateUnitGroup(Request $unitGroup)
    {
        $repo = new ProjectRepository(new Projects());
        $unitGroup = DataMapper::MapToUnitGroup($unitGroup);
        return $repo->UpdateUnitGroup($unitGroup);
    }
    public function AddMajor(Request $major)
    {
        $repo = new ProjectRepository(new Projects());
        $major = DataMapper::MapToMajor($major);
        return $repo->AddMajor($major);
    }
    public function UpdateMajor(Request $major)
    {
        $repo = new ProjectRepository(new Projects());
        $major = DataMapper::MapToMajor($major);
        return $repo->UpdateMajor($major);
    }
    public function AddOreintation(Request $oreintation)
    {
        $repo = new ProjectRepository(new Projects());
        $oreintation = DataMapper::MapToOreintation($oreintation);
        return $repo->AddOreintation($oreintation);
    }
    public function UpdateOreintation(Request $oreintation)
    {
        $repo = new ProjectRepository(new Projects());
        $oreintation = DataMapper::MapToOreintation($oreintation);
        return $repo->UpdateOreintation($oreintation);
    }
    public function AddSetting(Request $setting)
    {
        $repo = new ProjectRepository(new Projects());
        $setting->NidSetting = Str::uuid();
        $setting = DataMapper::MapToSetting($setting);
        return $repo->AddSetting($setting);
    }
    public function UpdateSetting(Request $setting)
    {
        $repo = new ProjectRepository(new Projects());
        $setting = DataMapper::MapToSetting($setting);
        return $repo->UpdateSetting($setting);
    }
    public function DeleteUnit(string $NidUnit)
    {
        $repo = new ProjectRepository(new Projects());
        if(!$repo->CheckForUnitGroupExist($NidUnit))
        {
            $repo->DeleteUnit($repo->GetUnitById($NidUnit));
            return response()->json(['Message'=>'2']);
        }else
        {
            return response()->json(['Message'=>'1']);
        }
    }
    public function DeleteUnitGroup(string $NidUnitGroup)
    {
        $repo = new ProjectRepository(new Projects());
        return response()->json(['HasValue'=>$repo->DeleteUnitGroup($repo->GetUnitGroupById($NidUnitGroup))]);
    }
    public function DeleteMajor(string $NidMajor)
    {
        $repo = new ProjectRepository(new Projects());
        if(!$repo->CheckForOreintationExist($NidMajor))
        {
            $repo->DeleteMajor($repo->GetMajorById($NidMajor));
            return response()->json(['Message'=>'2']);
        }else
        {
            return response()->json(['Message'=>'1']);
        }
    }
    public function DeleteOreintation(string $NidOreintation)
    {
        $repo = new ProjectRepository(new Projects());
        return response()->json(['HasValue'=>$repo->DeleteOreintation($repo->GetOreintationById($NidOreintation))]);
    }
    public function DeleteSetting(string $NidSetting)
    {
        $repo = new ProjectRepository(new Projects());
        $tmpSetting = $repo->GetSettingById($NidSetting);
        $tmpSetting->IsDeleted = true;
        return response()->json(['HasValue'=>$repo->UpdateSetting($tmpSetting)]);
    }
    public function GenerateSettingValue(int $index)
    {
        $repo = new ProjectRepository(new Projects());
        return $repo->GenerateSettingId($index);
    }

    //search section
    public function AdvancedSearch(string $searchText, int $SectionId = 0, int $ById = 0, bool $Similar = true)
    {
        $repo = new SearchRepository();
        return $repo->AdvancedSearch($searchText,$SectionId,$Similar,$ById);
    }
    public function ComplexSearch(string $searchText, int $ById = 0, bool $Similar = true)
    {
        $repo = new SearchRepository();
        return $repo->ComplexSearch($searchText,$Similar,$ById);
    }

    //alarm section
    public function GetFirstPageAlarms()
    {
        $repo = new AlarmRepository(new Alarms());
        return $repo->GetFirstLevelAlarms();
    }
    public function GetAllAlarms()
    {
        $repo = new AlarmRepository(new Alarms());
        return $repo->GetAllAlarms();
    }

    //message section
    public function DeleteMessage(string $NidMessage)
    {
        $repo = new MessageRepository(new Messages());
        return $repo->DeleteMessage($NidMessage);
    }
    public function GetAllUsersMessages(string $NidUser,bool $ShowAll = false)
    {
        $repo = new MessageRepository(new Messages());
        return $repo->GetUsersMessages($NidUser,$ShowAll);
    }
    public function GetAllUsersSendMessages(string $NidUser)
    {
        $repo = new MessageRepository(new Messages());
        return $repo->GetUsersSendMessages($NidUser);
    }
    public function ReadMessage(string $NidMessage)
    {
        $repo = new MessageRepository(new Messages());
        return $repo->ReadMessage($NidMessage);
    }
    public function RecieveMessage(string $NidMessage)
    {
        $repo = new MessageRepository(new Messages());
        return $repo->RecieveMessage($NidMessage);
    }
    public function RecieveMessageNeeded(string $NidUser)
    {
        $repo = new MessageRepository(new Messages());
        return response()->json(['HasValue'=>$repo->RecieveMessageNeeded($NidUser)]);
    }
    public function GetMessageDTOById(string $NidMessage)
    {
        $repo = new MessageRepository(new Messages());
        return $repo->GetMessageDTOById($NidMessage);
    }
    public function GetMessageHirarchyById(string $NidMessage)
    {
        $repo = new MessageRepository(new Messages());
        return $repo->GetMessageHirarchyById($NidMessage);
    }
    public function SendMessage(Request $Message)
    {
        $repo = new MessageRepository(new Messages());
        $Message = DataMapper::MapToMessage($Message);
        return $repo->SendMessage($Message);
    }
    //report section
    public function GetStatisticsReport(ReportRawData $reportraw)
    {
        $repo = new ReportRepository(new Reports());
        // $reportraw = DataMapper::MapToReportRawData($reportraw);
        return $repo->StatisticsReport($reportraw);
    }
    public function AddReport(Request $report)
    {
        $repo = new ReportRepository(new Reports());
        $report = DataMapper::MapToReport($report);
        return $repo->AddReport($report);
    }
    public function AddReportParameters(Request $Params)//ReportParameter
    {
        $repo = new ReportRepository(new Reports());
        $pars = new Collection();
        foreach($Params as $param)
        {
            $pars->push(DataMapper::MapToReportParameter($Params));
        }
        return $repo->AddReportParameterList($pars);
    }
    public function GetReportById(string $NidReport)
    {
        $repo = new ReportRepository(new Reports());
        return $repo->GetReport($NidReport);
    }
    public function GetStatisticsReports()
    {
        $repo = new ReportRepository(new Reports());
        return $repo->GetStatisticsReports();
    }
    public function GetReportsInput(string $NidReport)
    {
        $repo = new ReportRepository(new Reports());
        return $repo->GetReportsInput($NidReport);
    }
    public function GetReportsOutput(string $NidReport)
    {
        $repo = new ReportRepository(new Reports());
        return $repo->GetReportsOutput($NidReport);
    }
    public function DeleteReport(string $NidReport)
    {
        $repo = new ReportRepository(new Reports());
        if($repo->DeleteReportParametersByNidReport($NidReport))
        {
            return $repo->DeleteReport($NidReport);
        }
    }
}
