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
        try {
            $scholar->NidScholar = Str::uuid();
            $scholar = DataMapper::MapToScholar($scholar);
            $repo = new ScholarRepository(new Scholars());
            return $repo->AddScholar($scholar);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function GetCollaborationTypes(bool $IncludeDeleted = false)
    {
        try {
            $repo = new ScholarRepository(new Scholars());
            return $repo->GetCollaborationTypes(0, $IncludeDeleted);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetColleges(bool $IncludeDeleted = false)
    {
        try {
            $repo = new ScholarRepository(new Scholars());
            return $repo->GetColleges(0, $IncludeDeleted);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetGrades(bool $IncludeDeleted = false)
    {
        try {
            $repo = new ScholarRepository(new Scholars());
            return $repo->GetGrades(0, $IncludeDeleted);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetMillitaryStatuses(bool $IncludeDeleted = false)
    {
        try {
            $repo = new ScholarRepository(new Scholars());
            return $repo->GetMillitaryStatuses(0, $IncludeDeleted);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetMajors()
    {
        try {
            $repo = new ScholarRepository(new Scholars());
            return $repo->GetMajors(0);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetOrientations()
    {
        try {
            $repo = new ScholarRepository(new Scholars());
            return $repo->GetOreintations(0);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetScholar(string $ScholarId)
    {
        try {
            $repo = new ScholarRepository(new Scholars());
            return $repo->GetScholarById($ScholarId);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetScholarDTO(string $ScholarId)
    {
        try {
            $repo = new ScholarRepository(new Scholars());
            return $repo->GetScholarDTOById($ScholarId);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetOreintationsByMajorId(string $MajorId)
    {
        try {
            $repo = new ScholarRepository(new Scholars());
            return $repo->GetOreintationByMajorId($MajorId);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetAllScholars(int $Pagesize = 10)
    {
        try {
            $repo = new ScholarRepository(new Scholars());
            return $repo->GetScholars($Pagesize);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetAllScholarLists(int $Pagesize = 10,bool $includeConfident = true)
    {
        try {
            $repo = new ScholarRepository(new Scholars());
            return $repo->GetScholarList($Pagesize,$includeConfident);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetAllScholarDetails(string $ScholarId)
    {
        try {
            $repo = new ScholarRepository(new Scholars());
            return $repo->GetScholarDetail($ScholarId);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function UpdateScholar(Request $scholar)
    {
        try {
            $repo = new ScholarRepository(new Scholars());
            $scholar = DataMapper::MapToScholar($scholar);
            $repo->UpdateScholar($scholar);
            return response()->json(['FirstName' => $scholar->FirstName, 'LastName' => $scholar->LastName]);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function DeleteScholar(string $NidScholar)
    {
        try {
            $repo = new ScholarRepository(new Scholars());
            $ProjectCount = $repo->CheckProjectsOfScholar($NidScholar);
            if ($ProjectCount == 0) {
                $tmpresult = $repo->DeleteScholar($NidScholar);
                if ($tmpresult)
                    return response()->json(['Message' => '-1', 'Html' => '']); //scholar name to add
                else
                    return response()->json(['Message' => '0', 'Html' => '']); //scholar name to add
            } else
                return response()->json(['Message' => $ProjectCount, 'Html' => '']); //scholar name to add
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetScholarList(string $ScholarId, bool $IsDeleted = false)
    {
        try {
            $repo = new ScholarRepository(new Scholars());
            return $repo->GetScholarListById($ScholarId, $IsDeleted);
            // return $ScholarId;
        } catch (\Throwable $th) {
            return null;
        }
    }

    //user section
    public function AddUser(Request $User)
    {
        try {
            $User->CreateDate = Carbon::now();
            $User->NidUser = Str::uuid();
            $User->IsLockedOut = boolval(false);
            $User->IsDisabled = boolval(false);
            $User->Force_logout = 0;
            $User->IncorrectPasswordCount = 0;
            $repo = new UserRepository(new User());
            $User = DataMapper::MapToUser($User);
            $repo->AddUser($User);
            return $User;
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetUserDTOById(string $UserId)
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->GetUserDTOById($UserId);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetUserById(string $UserId)
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->GetUserById($UserId);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetAllUsers()
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->GetUserDTOs(0);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetAllOnlineUsers()
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->GetUserDTOs(0);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function DisableUserById(string $UserId)
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->DisableUser($UserId);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function EnableUserById(string $UserId)
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->EnableUser($UserId);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function ReEnableUserById(string $UserId)
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->ReEnableUser($UserId);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function LogoutUserById(string $UserId)
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->LogoutUser($UserId);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function UpdateUser(Request $User)
    {
        try {
            $repo = new UserRepository(new User());
            $User = DataMapper::MapToUser($User);
            return $repo->UpdateUser($User);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function GetCustomUsers(int $SourceId)
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->GetFilteredUserDTOs($SourceId);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function ResetPassword(string $NidUser, string $NewPassword)
    {
        try {
            $repo = new UserRepository(new User());
            $NewPass = $repo->ChangeUserPassword($NidUser, $NewPassword);
            if (!is_null($NewPass))
                return response()->json(['Message' => $NewPass, 'HasValue' => true]);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function CheckPrePassword(string $NidUser, string $NewPassword)
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->CheckPreviousPassword($NidUser, $NewPassword);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function CheckPasswordsPolicy(string $NewPassword)
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->CheckPasswordPolicy($NewPassword);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function LoginThisUser(string $Username, string $Password)
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->LoginUser($Username, $Password);
        } catch (\Throwable $th) {
            return null;
            // throw $th;
        }
    }
    public function GetThisUserByUsername(string $Username)
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->GetUserByUsername($Username);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetAllUserPermissionUsers()
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->GetUserPermissionUsers(0);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetUserInPermissionById(string $NidUser)
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->GetUserInPermissionById($NidUser);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetAllResources()
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->GetResources(0);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetAllUserPermissions(string $NidUser)
    {
        try {
            $repo = new UserRepository(new User());
            $repo2 = new AlarmRepository(new Alarms());
            try {
                $repo2->HandleAlarmsJob();
            } catch (\Exception) {
            }
            return $repo->GetUserPermissions($NidUser);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function HandleAlarms()
    {
        try {
            $repo2 = new AlarmRepository(new Alarms());
            $repo2->HandleAlarmsJob();
        } catch (\Exception) {
        }
    }
    public static function AddLog(User $user, string $ip, int $action, int $status, int $importance, int $confident, string $description = "")
    {
        try {
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
        } catch (\Throwable $th) {
            return false;
        }
    }
    public static function GetLogActionTypes(int $pagesize = 10)
    {
        try {
            $repo = new LogRepository();
            return $repo->GetAllLogActionType($pagesize);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public static function GetUserLogReport(string $FromDate, string $ToDate, int $LogActionId = 0, string $UserName = "")
    {
        try {
            $repo = new LogRepository();
            return $repo->UserLogReport($FromDate, $ToDate, $LogActionId, $UserName);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public static function GetCurrentUserLogReport(string $NidUser,int $pagesize = 200)
    {
        try {
            $repo = new LogRepository();
            return $repo->CurrentUserLogReport($NidUser,$pagesize);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public static function GetCurrentUserLoginReport(string $NidUser)
    {
        try {
            $repo = new LogRepository();
            return $repo->CurrentUserLoginReport($NidUser);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function UpdateUserUserPermissions(string $NidUser, array $Resources)
    {
        try {
            $resourceGuids = new Collection();
            if (!is_null($Resources)) {
                foreach ($Resources as $ids) {
                    $resourceGuids->push($ids);
                }
            }
            $repo = new UserRepository(new User());
            return $repo->UpdateUserUserPermission($NidUser, $Resources);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function IndexBriefReport()
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->GetIndexBriefReport();
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function IndexChartReport()
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->GetIndexChartReport();
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function UpdatePolicy(Request $policy)
    {
        try {
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
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function GetPolicies()
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->GetUserPasswordPolicy();
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function UpdateSessionsSettings(string $value)
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->UpdateSessionSetting($value);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function GetSessionsSettings()
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->GetSessionSettings();
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function AddRole(Request $role)
    {
        try {
            $repo = new UserRepository(new User());
            $newrole = new Roles();
            $newrole->NidRole = Str::uuid();
            $newrole->Title = $role->Title;
            $newrole->IsAdmin = boolval($role->IsAdmin);
            $newrole->CreateDate = Carbon::now();
            return $repo->AddRole($newrole);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function UpdateRole(Request $role)
    {
        try {
            $repo = new UserRepository(new User());
            $newrole = new Roles();
            $newrole->NidRole = $role->NidRole;
            $newrole->Title = $role->Title;
            $newrole->IsAdmin = boolval($role->IsAdmin);
            $newrole->CreateDate = $role->CreateDate;
            return $repo->UpdateRole($newrole);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function GetAllRoles()
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->GetRoles();
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function AddRolePermission(Request $rolepermission)
    {
        try {
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
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function AddUserPermission(Request $userpermission)
    {
        try {
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
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function UpdateRolePermission(Request $rolepermission)
    {
        try {
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
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function DeleteRolePermission(string $NidPermission)
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->DeleteRolePermission($NidPermission);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function DeleteUserPermission(string $NidPermission)
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->DeleteUserPermission($NidPermission);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function GetAllRolePermissions()
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->GetRolesPermission();
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetAllRolePermissionDTOs()
    {
        try {
            $repo = new UserRepository(new User());
            $perms = $repo->GetRolesPermission();
            $res = new Collection();
            foreach ($perms as $pr) {
                $res->push(DataMapper::MapToRolePermissionDTO($pr));
            }
            return $res;
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetAllRolePermissionDTOsByRoleId(string $RoleId)
    {
        try {
            $repo = new UserRepository(new User());
            $perms = $repo->GetRolesPermissionByRoleId($RoleId);
            $res = new Collection();
            foreach ($perms as $pr) {
                $res->push(DataMapper::MapToRolePermissionDTO($pr));
            }
            return $res;
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetAllUserPermissionDTOsByUserId(string $UserId)
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->GetUserPermissions($UserId);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetAllRoleUsers(string $RoleId)
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->GetRoleUsersById($RoleId);
        } catch (\Throwable $th) {
            return null;
        }
    }

    public function GetRolePermissionsByUser(string $UserId)
    {
        try {
            $repo = new UserRepository(new User());
            $perms = $repo->GetRolesPermissionByUserId($UserId);
            $res = new Collection();
            foreach ($perms as $pr) {
                $res->push(DataMapper::MapToRolePermissionDTO($pr));
            }
            return $res;
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetRolePermissionsById(string $PermissionId)
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->GetRolesPermissionById($PermissionId);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetRoleById(string $RoleId)
    {
        try {
            $repo = new UserRepository(new User());
            return $repo->GetRoleById($RoleId);
        } catch (\Throwable $th) {
            return null;
        }
    }
    //Project section
    public function GetAllProjectInitials(int $pagesize = 0,bool $includeConfident = true,int $toskip = 0)
    {
        $repo = new ProjectRepository(new Projects());
        return $repo->GetProjectInitials($pagesize,$toskip,$includeConfident);
    }
    public function AddProjectInitial(Request $ProjectInitial, string $NidUser)
    {
        try {
            $ProjectInitial->CreateDate = Carbon::now();
            $repo = new ProjectRepository(new Projects());
            $repo2 = new AlarmRepository(new Alarms());
            $ProjectInitial->PersianCreateDate = new Verta($ProjectInitial->CreateDate);
            $ProjectInitial->NidProject = Str::uuid();
            $ProjectInitial->ProjectNumber = $repo->GenerateProjectNumber();
            $ProjectInitial->ProjectStatus = 0;
            $ProjectInitial->UserId = $NidUser;
            $ProjectInitial = DataMapper::MapToProjectInitialDTOFromRequest($ProjectInitial);
            if ($repo->AddProjectInitial($ProjectInitial)) {
                return $repo2->HandleAlarmsByProjectId($ProjectInitial->NidProject);
            }
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function ProjectProgress(Request $project)
    {
        try {
            $repo = new ProjectRepository(new Projects());
            $repo2 = new AlarmRepository(new Alarms());
            $project = DataMapper::MapToProject($project);
            $project->ProjectStatus = $repo->ProjectStatusCalc($project);
            $res = $repo->UpdateProject($project);
            $repo2->HandleAlarmsByProjectId($project->NidProject);
            return $res;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function DeleteProject(string $NidProject)
    {
        try {
            $repo = new ProjectRepository(new Projects());
            $repo2 = new AlarmRepository(new Alarms());
            $repo2->RemoveProjectAlarms($NidProject);
            return $repo->DeleteProject($repo->GetProjectById($NidProject));
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function GetProjectDTOById(string $NidProject)
    {
        try {
            $repo = new ProjectRepository(new Projects());
            return $repo->GetProjectDTOById($NidProject);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetProjectDetailDTOById(string $NidProject)
    {
        try {
            $repo = new ProjectRepository(new Projects());
            return $repo->GetProjectDetailDTOById($NidProject);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetAllUnits()
    {
        try {
            $repo = new ProjectRepository(new Projects());
            return $repo->GetUnits(0);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetAllUnitGroups()
    {
        try {
            $repo = new ProjectRepository(new Projects());
            return $repo->GetUnitGroups(0);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetAllProjectScholars()
    {
        try {
            $repo = new ProjectRepository(new Projects());
            return $repo->GetProjectScholars(0);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function AddProject(Request $Project)
    {
        try {
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
            $repo2->HandleAlarmsByProjectId($Project->NidProject);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function GetProjectById(string $NidProject)
    {
        try {
            $repo = new ProjectRepository(new Projects());
            return $repo->GetProjectById($NidProject);
        } catch (\Throwable $th) {
            return null;
        }
    }

    //base info section
    public function AddUnit(Request $unit)
    {
        try {
            $repo = new ProjectRepository(new Projects());
            $unit->NidUnit = Str::uuid();
            $unit = DataMapper::MapToUnit($unit);
            return $repo->AddUnit($unit);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function UpdateUnit(Request $unit)
    {
        try {
            $repo = new ProjectRepository(new Projects());
            $unit = DataMapper::MapToUnit($unit);
            return $repo->UpdateUnit($unit);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function AddUnitGroup(Request $unitGroup)
    {
        try {
            $repo = new ProjectRepository(new Projects());
            $unitGroup->NidGroup = Str::uuid();
            $unitGroup = DataMapper::MapToUnitGroup($unitGroup);
            return $repo->AddUnitGroup($unitGroup);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function UpdateUnitGroup(Request $unitGroup)
    {
        try {
            $repo = new ProjectRepository(new Projects());
            $unitGroup = DataMapper::MapToUnitGroup($unitGroup);
            return $repo->UpdateUnitGroup($unitGroup);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function AddMajor(Request $major)
    {
        try {
            $repo = new ProjectRepository(new Projects());
            $major->NidMajor = Str::uuid();
            $major = DataMapper::MapToMajor($major);
            return $repo->AddMajor($major);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function UpdateMajor(Request $major)
    {
        try {
            $repo = new ProjectRepository(new Projects());
            $major = DataMapper::MapToMajor($major);
            return $repo->UpdateMajor($major);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function AddOreintation(Request $oreintation)
    {
        try {
            $repo = new ProjectRepository(new Projects());
            $oreintation->NidOreintation = Str::uuid();
            $oreintation = DataMapper::MapToOreintation($oreintation);
            return $repo->AddOreintation($oreintation);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function UpdateOreintation(Request $oreintation)
    {
        try {
            $repo = new ProjectRepository(new Projects());
            $oreintation = DataMapper::MapToOreintation($oreintation);
            return $repo->UpdateOreintation($oreintation);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function AddSetting(Request $setting)
    {
        try {
            $repo = new ProjectRepository(new Projects());
            $setting->NidSetting = Str::uuid();
            $setting->IsDeleted = boolval(false);
            $setting = DataMapper::MapToSetting($setting);
            return $repo->AddSetting($setting);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function UpdateSetting(Request $setting)
    {
        try {
            $repo = new ProjectRepository(new Projects());
            $setting = DataMapper::MapToSetting($setting);
            return $repo->UpdateSetting($setting);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function DeleteUnit(string $NidUnit)
    {
        try {
            $repo = new ProjectRepository(new Projects());
            if (!$repo->CheckForUnitGroupExist($NidUnit)) {
                $repo->DeleteUnit($repo->GetUnitById($NidUnit));
                return response()->json(['Message' => '2']);
            } else {
                return response()->json(['Message' => '1']);
            }
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function DeleteRole(string $NidRole)
    {
        try {
            $repo = new UserRepository(new User());
            if (!$repo->CheckForUserExist($NidRole)) {
                $repo->DeleteRole($NidRole);
                return response()->json(['Message' => '2']);
            } else {
                return response()->json(['Message' => '1']);
            }
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function DeleteUnitGroup(string $NidUnitGroup)
    {
        try {
            $repo = new ProjectRepository(new Projects());
            return response()->json(['HasValue' => $repo->DeleteUnitGroup($repo->GetUnitGroupById($NidUnitGroup))]);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function DeleteMajor(string $NidMajor)
    {
        try {
            $repo = new ProjectRepository(new Projects());
            if (!$repo->CheckForOreintationExist($NidMajor)) {
                $repo->DeleteMajor($repo->GetMajorById($NidMajor));
                return response()->json(['Message' => '2']);
            } else {
                return response()->json(['Message' => '1']);
            }
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function DeleteOreintation(string $NidOreintation)
    {
        try {
            $repo = new ProjectRepository(new Projects());
            return response()->json(['HasValue' => $repo->DeleteOreintation($repo->GetOreintationById($NidOreintation))]);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function DeleteSetting(string $NidSetting)
    {
        try {
            $repo = new ProjectRepository(new Projects());
            $tmpSetting = $repo->GetSettingById($NidSetting);
            $tmpSetting->IsDeleted = boolval(true);
            return response()->json(['HasValue' => $repo->UpdateSetting($tmpSetting)]);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GenerateSettingValue(int $index)
    {
        try {
            $repo = new ProjectRepository(new Projects());
            return $repo->GenerateSettingId($index);
        } catch (\Throwable $th) {
            return null;
        }
    }

    //search section
    public function AdvancedSearch(string $FsearchText, int $FSectionId = 0, int $FById = 0, int $FSimilar = 1)
    {
        $repo = new SearchRepository();
        return $repo->AdvancedSearchProcess($FsearchText, $FSectionId, $FSimilar, $FById);
        try {
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function ComplexSearch(string $searchText, int $ById = 0, bool $Similar = true)
    {
        try {
            $repo = new SearchRepository();
            return $repo->ComplexSearch($searchText, $Similar, $ById);
        } catch (\Throwable $th) {
            return null;
        }
    }

    //alarm section
    public function GetFirstPageAlarms()
    {
        try {
            $repo = new AlarmRepository(new Alarms());
            return $repo->GetFirstLevelAlarms();
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetUsersFirstPageAlarms(string $UserId)
    {
        try {
            $repo = new AlarmRepository(new Alarms());
            return $repo->GetUsersFirstLevelAlarms($UserId);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetAllAlarms(int $pagesize = 100)
    {
        try {
            $repo = new AlarmRepository(new Alarms());
            return $repo->GetAllAlarms($pagesize);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetUsersAlarms(string $UserId)
    {
        try {
            $repo = new AlarmRepository(new Alarms());
            return $repo->GetAlarmsByCreator($UserId);
        } catch (\Throwable $th) {
            return null;
        }
    }
    //message section
    public function DeleteMessage(string $NidMessage)
    {
        try {
            $repo = new MessageRepository(new Messages());
            return $repo->DeleteMessage($NidMessage);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function GetAllUsersMessages(string $NidUser, bool $ShowAll = false, int $pagesize = 0)
    {
        try {
            $repo = new MessageRepository(new Messages());
            return $repo->GetUsersMessages($NidUser, $ShowAll, $pagesize);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetAllUsersSendMessages(string $NidUser, int $pagesize = 100)
    {
        try {
            $repo = new MessageRepository(new Messages());
            return $repo->GetUsersSendMessages($NidUser, $pagesize);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function ReadMessage(string $NidMessage)
    {
        try {
            $repo = new MessageRepository(new Messages());
            return $repo->ReadMessage($NidMessage);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function RecieveMessage(string $NidMessage)
    {
        try {
            $repo = new MessageRepository(new Messages());
            return $repo->RecieveMessage($NidMessage);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function RecieveMessageNeeded(string $NidUser)
    {
        try {
            $repo = new MessageRepository(new Messages());
            return response()->json(['HasValue' => $repo->RecieveMessageNeeded($NidUser)]);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetMessageDTOById(string $NidMessage)
    {
        try {
            $repo = new MessageRepository(new Messages());
            return $repo->GetMessageDTOById($NidMessage);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetMessageHirarchyById(string $NidMessage)
    {
        try {
            $repo = new MessageRepository(new Messages());
            return $repo->GetMessageHirarchyById($NidMessage);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function SendMessage(Request $Message)
    {
        try {
            $repo = new MessageRepository(new Messages());
            $Message = DataMapper::MapToMessage($Message);
            return $repo->SendMessage($Message);
        } catch (\Throwable $th) {
            return false;
        }
    }
    //report section
    public function GetStatisticsReport(string $NidReport, array $paramsKey, array $paramsValue,bool $showConfidents = false)
    {
        try {
            $repo = new ReportRepository(new Reports());
            // $reportraw = DataMapper::MapToReportRawData($reportraw);
            return $repo->StatisticsReport($NidReport, $paramsKey, $paramsValue,$showConfidents);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function AddReport(Reports $report)
    {
        try {
            $repo = new ReportRepository(new Reports());
            // $report = DataMapper::MapToReport($report);
            return $repo->AddReport($report);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function AddReportParameters(SupportCollection $Params) //ReportParameter
    {
        try {
            $repo = new ReportRepository(new Reports());
            $pars = new Collection();
            foreach ($Params as $param) {
                $pars->push(DataMapper::MapToReportParameter($param));
            }
            return $repo->AddReportParameterList($pars);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function GetReportById(string $NidReport)
    {
        try {
            $repo = new ReportRepository(new Reports());
            return $repo->GetReport($NidReport);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetStatisticsReports()
    {
        try {
            $repo = new ReportRepository(new Reports());
            return $repo->GetStatisticsReports();
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetReportsInput(string $NidReport)
    {
        try {
            $repo = new ReportRepository(new Reports());
            return $repo->GetReportsInput($NidReport);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function GetReportsOutput(string $NidReport)
    {
        try {
            $repo = new ReportRepository(new Reports());
            return $repo->GetReportsOutput($NidReport);
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function DeleteReport(string $NidReport)
    {
        try {
            $repo = new ReportRepository(new Reports());
            if ($repo->DeleteReportParametersByNidReport($NidReport)) {
                return $repo->DeleteReport($NidReport);
            }
        } catch (\Throwable $th) {
            return false;
        }
    }
}
