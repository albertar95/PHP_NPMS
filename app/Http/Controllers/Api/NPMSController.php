<?php

namespace App\Http\Controllers\Api;

use App\Domains\Repositories\AlarmRepository;
use App\Domains\Repositories\LogRepository;
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
use App\Models\Logs;
use App\Models\Messages;
use App\Models\Projects;
use App\Models\Reports;
use App\Models\RolePermissions;
use App\Models\Roles;
use App\Models\Scholars;
use App\Models\Units;
use App\Models\User;
use App\Models\UserPermissions;
use App\Models\Users;
use Carbon\Carbon;
use Dflydev\DotAccessData\Data;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as SupportCollection;
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
        $User->IsLockedOut = boolval(false);
        $User->IsDisabled = boolval(false);
        $User->Force_logout = 0;
        $repo = new UserRepository(new User());
        $User = DataMapper::MapToUser($User);
        $repo->AddUser($User);
        return $User;
    }
    public function GetUserDTOById(string $UserId)
    {
        $repo = new UserRepository(new User());
        return $repo->GetUserDTOById($UserId);
    }
    public function GetUserById(string $UserId)
    {
        $repo = new UserRepository(new User());
        return $repo->GetUserById($UserId);
    }
    public function GetAllUsers()
    {
        $repo = new UserRepository(new User());
        return $repo->GetUserDTOs(0);
    }
    public function GetAllOnlineUsers()
    {
        $repo = new UserRepository(new User());
        return $repo->GetUserDTOs(0);
    }
    public function DisableUserById(string $UserId)
    {
        $repo = new UserRepository(new User());
        return $repo->DisableUser($UserId);
    }
    public function LogoutUserById(string $UserId)
    {
        $repo = new UserRepository(new User());
        return $repo->LogoutUser($UserId);
    }
    public function UpdateUser(Request $User)
    {
        $repo = new UserRepository(new User());
        $User = DataMapper::MapToUser($User);
        return $repo->UpdateUser($User);
    }
    public function GetCustomUsers(int $SourceId)
    {
        $repo = new UserRepository(new User());
        return $repo->GetFilteredUserDTOs($SourceId);
    }
    public function ResetPassword(string $NidUser,string $NewPassword)
    {
        $repo = new UserRepository(new User());
        $NewPass = $repo->ChangeUserPassword($NidUser, $NewPassword);
        if (!is_null($NewPass))
        return response()->json(['Message'=>$NewPass,'HasValue'=>true]);
    }
    public function CheckPrePassword(string $NidUser,string $NewPassword)
    {
        $repo = new UserRepository(new User());
        return $repo->CheckPreviousPassword($NidUser,$NewPassword);
    }
    public function CheckPasswordsPolicy(string $NewPassword)
    {
        $repo = new UserRepository(new User());
        return $repo->CheckPasswordPolicy($NewPassword);
    }
    public function LoginThisUser(string $Username, string $Password)
    {
        $repo = new UserRepository(new User());
        return $repo->LoginUser($Username,$Password);
    }
    public function GetThisUserByUsername(string $Username)
    {
        $repo = new UserRepository(new User());
        return $repo->GetUserByUsername($Username);
    }
    public function GetAllUserPermissionUsers()
    {
        $repo = new UserRepository(new User());
        return $repo->GetUserPermissionUsers(0);
    }
    public function GetUserInPermissionById(string $NidUser)
    {
        $repo = new UserRepository(new User());
        return $repo->GetUserInPermissionById($NidUser);
    }
    public function GetAllResources()
    {
        $repo = new UserRepository(new User());
        return $repo->GetResources(0);
    }
    public function GetAllUserPermissions(string $NidUser)
    {
        $repo = new UserRepository(new User());
        $repo2 = new AlarmRepository(new Alarms());
        try
        {
            $repo2->HandleAlarmsJob();
        }
        catch (\Exception)
        {
        }
        return $repo->GetUserPermissions($NidUser);
    }
    public function HandleAlarms()
    {
        $repo2 = new AlarmRepository(new Alarms());
        $repo2->HandleAlarmsJob();
        try
        {
        }
        catch (\Exception)
        {
        }
    }
    public static function AddLog(User $user,string $ip,int $action,int $status,int $importance,int $confident,string $description = "")
    {
        $newlog = new Logs();
        $repo = new LogRepository();
        $newlog->NidLog = Str::uuid();
        $newlog->UserId = $user->NidUser;
        $newlog->Username = $user->UserName;
        $newlog->LogDate = Carbon::now()->toDateString();
        $newlog->IP = $ip;
        $newlog->LogTime = Carbon::now()->toTimeString();
        $newlog->ActionId = $action;
        $newlog->Description = $description;
        $newlog->LogStatus = $status;
        $newlog->ImportanceLevel = $importance;
        $newlog->ConfidentialLevel = $confident;
        return $repo->AddLog($newlog);
        // return $newlog;
    }
    public static function GetLogActionTypes(int $pagesize = 10)
    {
        $repo = new LogRepository();
        return $repo->GetAllLogActionType($pagesize);
        // return $newlog;
    }
    public static function GetUserLogReport(string $FromDate,string $ToDate,int $LogActionId = 0,string $UserName = "")
    {
        $repo = new LogRepository();
        return $repo->UserLogReport($FromDate,$ToDate,$LogActionId,$UserName);
        // return $newlog;
    }
    public static function GetCurrentUserLogReport(string $NidUser)
    {
        $repo = new LogRepository();
        return $repo->CurrentUserLogReport($NidUser);
        // return $newlog;
    }
    public static function GetCurrentUserLoginReport(string $NidUser)
    {
        $repo = new LogRepository();
        return $repo->CurrentUserLoginReport($NidUser);
        // return $newlog;
    }
    public function UpdateUserUserPermissions(string $NidUser,array $Resources)
    {
        $resourceGuids = new Collection();
        if(!is_null($Resources))
        {
            foreach ($Resources as $ids)
            {
                $resourceGuids->push($ids);
            }
        }
        $repo = new UserRepository(new User());
        return $repo->UpdateUserUserPermission($NidUser, $Resources);
    }
    public function IndexBriefReport()
    {
        $repo = new UserRepository(new User());
        return $repo->GetIndexBriefReport();
    }
    public function IndexChartReport()
    {
        $repo = new UserRepository(new User());
        return $repo->GetIndexChartReport();
    }
    public function UpdatePolicy(Request $policy)
    {
        $policies = [
            "PasswordDificulty" => $policy->PasswordDificulty,
            "FullLockoutUser" => $policy->FullLockoutUser,
            "PasswordLength" => $policy->PasswordLength,
            "ChangePasswordDuration" => $policy->ChangePasswordDuration,
            "LastPasswordCount" => $policy->LastPasswordCount,
            "IncorrectAttemptCount" => $policy->IncorrectAttemptCount,
            "LockoutDuration" => $policy->LockoutDuration
                    ];
                    $repo = new UserRepository(new User());
                    return $repo->UpdateUserPasswordPolicy($policies);
                    // return $policies;
    }
    public function GetPolicies()
    {
        $repo = new UserRepository(new User());
        return $repo->GetUserPasswordPolicy();
    }
    public function UpdateSessionsSettings(string $value)
    {
                    $repo = new UserRepository(new User());
                    return $repo->UpdateSessionSetting($value);
                    // return $policies;
    }
    public function GetSessionsSettings()
    {
        $repo = new UserRepository(new User());
        return $repo->GetSessionSettings();
    }
    public function AddRole(Request $role)
    {
        $repo = new UserRepository(new User());
        $newrole = new Roles();
        $newrole->NidRole = Str::uuid();
        $newrole->Title = $role->Title;
        $newrole->IsAdmin = boolval($role->IsAdmin);
        $newrole->CreateDate = Carbon::now();
        return $repo->AddRole($newrole);
    }
    public function UpdateRole(Request $role)
    {
        $repo = new UserRepository(new User());
        $newrole = new Roles();
        $newrole->NidRole = $role->NidRole;
        $newrole->Title = $role->Title;
        $newrole->IsAdmin = boolval($role->IsAdmin);
        $newrole->CreateDate = $role->CreateDate;
        return $repo->UpdateRole($newrole);
    }
    public function GetAllRoles()
    {
        $repo = new UserRepository(new User());
        return $repo->GetRoles();
    }
    public function AddRolePermission(Request $rolepermission)
    {
        $repo = new UserRepository(new User());
        $newroleperm = new RolePermissions();
        $newroleperm->NidPermission = Str::uuid();
        $newroleperm->RoleId = $rolepermission->RoleId;
        $newroleperm->EntityId = $rolepermission->EntityId;
        $newroleperm->Create = boolval($rolepermission->CreateVal);
        $newroleperm->Edit = boolval($rolepermission->EditVal);
        $newroleperm->Delete = boolval($rolepermission->DeleteVal);
        $newroleperm->Detail = boolval($rolepermission->DetailVal);
        $newroleperm->Confident = boolval($rolepermission->ConfidentVal);
        $newroleperm->List = boolval($rolepermission->ListVal);
        $newroleperm->Print = boolval($rolepermission->PrintVal);
        return $repo->AddRolePermission($newroleperm);
    }
    public function AddUserPermission(Request $userpermission)
    {
        $repo = new UserRepository(new User());
        $newuserperm = new UserPermissions();
        $newuserperm->NidPermission = Str::uuid();
        $newuserperm->UserId = $userpermission->UserId;
        $newuserperm->ResourceId = $userpermission->ResourceId;
        $newuserperm->EntityId = $userpermission->EntityId;
        $newuserperm->Create = boolval($userpermission->CreateVal);
        $newuserperm->Edit = boolval($userpermission->EditVal);
        $newuserperm->Delete = boolval($userpermission->DeleteVal);
        $newuserperm->Detail = boolval($userpermission->DetailVal);
        $newuserperm->Confident = boolval($userpermission->ConfidentVal);
        $newuserperm->List = boolval($userpermission->ListVal);
        $newuserperm->Print = boolval($userpermission->PrintVal);
        return $repo->AddUserPermission($newuserperm);
    }
    public function UpdateRolePermission(Request $rolepermission)
    {
        $repo = new UserRepository(new User());
        $newroleperm = new RolePermissions();
        $newroleperm->NidPermission = $rolepermission->NidPermission;
        $newroleperm->RoleId = $rolepermission->RoleId;
        $newroleperm->EntityId = $rolepermission->EntityId;
        $newroleperm->Create = boolval($rolepermission->CreateVal);
        $newroleperm->Edit = boolval($rolepermission->EditVal);
        $newroleperm->Delete = boolval($rolepermission->DeleteVal);
        $newroleperm->Detail = boolval($rolepermission->DetailVal);
        $newroleperm->Confident = boolval($rolepermission->ConfidentVal);
        $newroleperm->List = boolval($rolepermission->ListVal);
        $newroleperm->Print = boolval($rolepermission->PrintVal);
        return $repo->UpdateRolePermission($newroleperm);
    }
    public function DeleteRolePermission(string $NidPermission)
    {
        $repo = new UserRepository(new User());
        return $repo->DeleteRolePermission($NidPermission);
    }
    public function DeleteUserPermission(string $NidPermission)
    {
        $repo = new UserRepository(new User());
        return $repo->DeleteUserPermission($NidPermission);
    }
    public function GetAllRolePermissions()
    {
        $repo = new UserRepository(new User());
        return $repo->GetRolesPermission();
    }
    public function GetAllRolePermissionDTOs()
    {
        $repo = new UserRepository(new User());
        $perms = $repo->GetRolesPermission();
        $res = new Collection();
        foreach ($perms as $pr) {
            $res->push(DataMapper::MapToRolePermissionDTO($pr));
        }
        return $res;
    }
    public function GetAllRolePermissionDTOsByRoleId(string $RoleId)
    {
        $repo = new UserRepository(new User());
        $perms = $repo->GetRolesPermissionByRoleId($RoleId);
        $res = new Collection();
        foreach ($perms as $pr) {
            $res->push(DataMapper::MapToRolePermissionDTO($pr));
        }
        return $res;
    }
    public function GetAllUserPermissionDTOsByUserId(string $UserId)
    {
        $repo = new UserRepository(new User());
        return $repo->GetUserPermissions($UserId);
    }
    public function GetAllRoleUsers(string $RoleId)
    {
        $repo = new UserRepository(new User());
        return $repo->GetRoleUsersById($RoleId);
    }

    public function GetRolePermissionsByUser(string $UserId)
    {
        $repo = new UserRepository(new User());
        $perms = $repo->GetRolesPermissionByUserId($UserId);
        $res = new Collection();
        foreach ($perms as $pr) {
            $res->push(DataMapper::MapToRolePermissionDTO($pr));
        }
        return $res;
    }
    public function GetRolePermissionsById(string $PermissionId)
    {
        $repo = new UserRepository(new User());
        return $repo->GetRolesPermissionById($PermissionId);
    }
    public function GetRoleById(string $RoleId)
    {
        $repo = new UserRepository(new User());
        return $repo->GetRoleById($RoleId);
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
        return $repo->UpdateProject($Project);
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
        $major->NidMajor = Str::uuid();
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
        $oreintation->NidOreintation = Str::uuid();
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
        $setting->IsDeleted = boolval(false);
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
    public function DeleteRole(string $NidRole)
    {
        $repo = new UserRepository(new User());
        if(!$repo->CheckForUserExist($NidRole))
        {
            $repo->DeleteRole($NidRole);
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
        $tmpSetting->IsDeleted = boolval(true);
        return response()->json(['HasValue'=>$repo->UpdateSetting($tmpSetting)]);
    }
    public function GenerateSettingValue(int $index)
    {
        $repo = new ProjectRepository(new Projects());
        return $repo->GenerateSettingId($index);
    }

    //search section
    public function AdvancedSearch(string $FsearchText, int $FSectionId = 0, int $FById = 0, int $FSimilar = 1)
    {
        $repo = new SearchRepository();
        return $repo->AdvancedSearchProcess($FsearchText,$FSectionId,$FSimilar,$FById);
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
    public function GetUsersFirstPageAlarms(string $UserId)
    {
        $repo = new AlarmRepository(new Alarms());
        return $repo->GetUsersFirstLevelAlarms($UserId);
    }
    public function GetAllAlarms(int $pagesize = 100)
    {
        $repo = new AlarmRepository(new Alarms());
        return $repo->GetAllAlarms($pagesize);
    }
    public function GetUsersAlarms(string $UserId)
    {
        $repo = new AlarmRepository(new Alarms());
        return $repo->GetAlarmsByCreator($UserId);
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
    public function GetStatisticsReport(string $NidReport,array $paramsKey,array $paramsValue)
    {
        $repo = new ReportRepository(new Reports());
        // $reportraw = DataMapper::MapToReportRawData($reportraw);
        return $repo->StatisticsReport($NidReport,$paramsKey,$paramsValue);
    }
    public function AddReport(Reports $report)
    {
        $repo = new ReportRepository(new Reports());
        // $report = DataMapper::MapToReport($report);
        return $repo->AddReport($report);
    }
    public function AddReportParameters(SupportCollection $Params)//ReportParameter
    {
        $repo = new ReportRepository(new Reports());
        $pars = new Collection();
        foreach($Params as $param)
        {
            $pars->push(DataMapper::MapToReportParameter($param));
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
