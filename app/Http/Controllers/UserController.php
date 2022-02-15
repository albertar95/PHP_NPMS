<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\NPMSController;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Users;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use resources\ViewModels\ManagePermissionViewModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['Login', 'SubmitLogin', 'SetLoginData', 'ChangePassword', 'SubmitChangePassword', 'getUsersPassCode']]);
        $this->middleware('XSS');
    }
    private function CheckAuthority(bool $checkSub, int $sub, string $cookie, int $entity = 3)
    {
        $row = explode('#', $cookie);
        $AccessedEntities = new Collection();
        foreach ($row as $r) {
            $AccessedEntities->push(explode(',', $r)[0]);
        }
        if ($checkSub) {
            $AccessedSub = new Collection();
            foreach ($row as $r) {
                $AccessedSub->push(["entity" => explode(',', $r)[0], "rowValue" => substr($r, 2, strlen($r) - 2)]);
            }
            if (in_array($entity, $AccessedEntities->toArray())) {
                if (explode(',', $AccessedSub->where('entity', '=', $entity)->pluck('rowValue')[0])[$sub] == 1)
                    return true;
                else
                    return false;
            } else
                return false;
        } else {
            if (in_array($entity, $AccessedEntities->toArray()))
                return true;
            else
                return false;
        }
    }
    private static function GetEntityPermissionsFromCache()
    {
        $raw = Cookie::get('NPMS_Permissions');
        $row = explode('#', $raw);
        $AccessedEntities = new Collection();
        foreach ($row as $r) {
            $AccessedEntities->push(explode(',', $r)[0]);
        }
        return $AccessedEntities->toArray();
    }
    private static function GetSubPermissionsFromCache()
    {
        $raw = Cookie::get('NPMS_Permissions');
        $row = explode('#', $raw);
        $AccessedSub = new Collection();
        foreach ($row as $r) {
            $AccessedSub->push(["entity" => explode(',', $r)[0], "rowValue" => substr($r, 2, strlen($r) - 2)]);
        }
        return $AccessedSub;
    }
    public function Index(Request $request)
    {
        $api = new NPMSController();
        $briefs = $api->IndexBriefReport();
        $charts = $api->IndexChartReport();
        $messages = $api->GetAllUsersMessages(auth()->user()->NidUser);
        $chartarrays = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        foreach ($charts as $key => $value) {
            $chartarrays[$key - 1] = $value;
        }
        $chartvals = join(',', $chartarrays);
        $alarms = $api->GetFirstPageAlarms();
        $api->AddLog(auth()->user(), $request->ip(), 1, 0, 1, 1, "میزکار");
        return view('General.Index', compact('briefs', 'chartvals', 'alarms', 'messages'));
    }
    public function AddUser(Request $request)
    {
        if ($this->CheckAuthority(true, 0, $request->cookie('NPMS_Permissions'))) {
            $api = new NPMSController();
            $Roles = $api->GetAllRoles();
            $api->AddLog(auth()->user(), $request->ip(), 1, 0, 2, 1, "ایجاد کاربر");
            return view('User.AddUser', compact('Roles'));
        } else {
            return view('errors.401');
        }
    }
    public function SubmitAddUser(UserRequest $user)
    {
        $user->validated();
        $api = new NPMSController();
        $api->AddLog(auth()->user(), $user->ip(), 10, 0, 3, 1, sprintf("ایجاد کاربر موفق.نام کاربر : %s", $user->UserName));
        return $api->AddUser($user);
    }
    public function Users(Request $request)
    {
        if ($this->CheckAuthority(true, 4, $request->cookie('NPMS_Permissions'))) {
            $api = new NPMSController();
            $Users = $api->GetAllUsers(0);
            $api->AddLog(auth()->user(), $request->ip(), 1, 0, 1, 1, "مدیریت کاربران");
            return view('User.Users', compact('Users'));
        } else {
            return view('errors.401');
        }
    }
    public function UserDetail(string $NidUser, Request $request)
    {
        if ($this->CheckAuthority(true, 3, $request->cookie('NPMS_Permissions'))) {
            $api = new NPMSController();
            $Users = $api->GetUserDTOById($NidUser);
            $result = new JsonResults();
            $result->HasValue = true;
            $result->Html = view('User._UserDetail', compact('Users'))->render();
            $api->AddLog(auth()->user(), $request->ip(), 1, 0, 2, 1, sprintf("جزییات کاربر.نام کاربر : %s", $Users->Username));
            return response()->json($result);
        } else {
            return view('errors.401');
        }
    }
    public function UploadThisFile()
    {
        // List<string> Uploaded = new List<string>();
        // byte[] binData = null;
        // bool SizeLimit = true;
        // string Converted = "";
        // if (Request.Files.Count != 0)
        // {
        //     for (int i = 0; i < Request.Files.Count; i++)
        //     {
        //         var file = Request.Files[i];
        //         if (file.ContentLength > 1000000)
        //             SizeLimit = false;
        //         else
        //         {
        //             BinaryReader b = new BinaryReader(file.InputStream);
        //             binData = b.ReadBytes(file.ContentLength);
        //             Converted = Convert.ToBase64String(binData);
        //         }
        //     }
        // }
        // return Json(new JsonResults() { HasValue = SizeLimit, Html = Converted});
    }
    public function DisableUser(string $NidUser, Request $request)
    {
        $api = new NPMSController();
        $tmpresult = $api->DisableUserById($NidUser);
        $result = new JsonResults();
        if (!is_null($tmpresult)) {
            $result->HasValue = true;
            $tmpUser = $api->DisableUserById($NidUser);
            $result->Message = sprintf("کاربر با نام کاربری %s با موفقیت غیرفعال گردید", $tmpUser->Username);
            $api->AddLog(auth()->user(), $request->ip(), 12, 0, 3, 1, sprintf("غیر فعال کردن کاربر موفق.نام کاربری : %s", $tmpUser->Username));
            return response()->json($result);
        } else {
            $result->HasValue = false;
            $result->Message = "خطا در سرور لطفا مجددا امتحان کنید";
            $api->AddLog(auth()->user(), $request->ip(), 12, 1, 3, 1, "ایجاد کاربر ناموفق");
            return response()->json($result);
        }
    }
    public function LogoutUser(string $NidUser, Request $request)
    {
        $api = new NPMSController();
        $tmpresult = $api->LogoutUserById($NidUser);
        $result = new JsonResults();
        if (!is_null($tmpresult)) {
            $result->HasValue = true;
            $result->Message = sprintf("کاربر با نام کاربری %s با موفقیت خارج گردید", $tmpresult->UserName);
            $api->AddLog(auth()->user(), $request->ip(), 36, 0, 3, 1, sprintf("خارج کردن کاربر موفق.نام کاربری : %s", $tmpresult->UserName));
            return response()->json($result);
        } else {
            $result->HasValue = false;
            $result->Message = "خطا در سرور لطفا مجددا امتحان کنید";
            // $api->AddLog(auth()->user(),$request->ip(),12,1,3,1,"ایجاد کاربر ناموفق");
            return response()->json($result);
        }
    }
    public function EditUser(string $NidUser, Request $request)
    {
        if ($this->CheckAuthority(true, 1, $request->cookie('NPMS_Permissions'))) {
            $api = new NPMSController();
            $User = $api->GetUserById($NidUser);
            $Roles = $api->GetAllRoles();
            $api->AddLog(auth()->user(), $request->ip(), 1, 0, 2, 1, sprintf("ویرایش کاربر.نام کاربر : %s", $User->UserName));
            return view('User.EditUser', compact('User', 'Roles'));
        } else {
            return view('errors.401');
        }
    }
    public function SubmitChangePassword(string $NidUser, string $NewPassword, Request $request)
    {
        $api = new NPMSController();
        $tmpUser = $api->GetUserById($NidUser);
        if (!$api->CheckPrePassword($NidUser, $NewPassword)) {
            $jsonresult = new JsonResults();
            $jsonresult->HasValue = false;
            $jsonresult->AltProp = "1";
            $api->AddLog($tmpUser, $request->ip(), 13, 1, 3, 2, sprintf("تغییر رمز کاربر ناموفق.شناسه کاربر : %s", $NidUser));
            return response()->json($jsonresult);
        } else {
            if ($api->CheckPasswordsPolicy($NewPassword)) {
                $res = $api->ResetPassword($NidUser, $NewPassword);
                $state = json_decode($res->getContent(), true)['HasValue'];
                $newPass = json_decode($res->getContent(), true)['Message'];
                $jsonresult = new JsonResults();
                $jsonresult->HasValue = $state;
                $jsonresult->Message = $newPass;
                $jsonresult->AltProp = "2";
                $api->AddLog($tmpUser, $request->ip(), 13, 0, 3, 2, sprintf("تغییر رمز کاربر موفق.شناسه کاربر : %s", $NidUser));
                return response()->json($jsonresult);
            } else {
                $jsonresult = new JsonResults();
                $jsonresult->HasValue = false;
                $jsonresult->AltProp = "3";
                $api->AddLog($tmpUser, $request->ip(), 13, 1, 3, 2, sprintf("تغییر رمز کاربر ناموفق.شناسه کاربر : %s", $NidUser));
                return response()->json($jsonresult);
            }
        }
    }
    public function GetPasswordPolicy()
    {
        $api = new NPMSController();
        $jsonresult = new JsonResults();
        $policies = $api->GetPolicies();
        if ($policies->where('SettingKey', '=', 'PasswordLength')->count() > 0)
            $jsonresult->AltProp = $policies->where('SettingKey', '=', 'PasswordLength')->firstOrFail()->SettingValue;
        else
            $jsonresult->AltProp = 4;
        if ($policies->where('SettingKey', '=', 'PasswordDificulty')->count() > 0)
            $jsonresult->Message = $policies->where('SettingKey', '=', 'PasswordDificulty')->firstOrFail()->SettingValue;
        else
            $jsonresult->Message = 4;

            return response()->json($jsonresult);
    }
    public function Profile(Request $request)
    {
        $api = new NPMSController();
        $Users = $api->GetUserDTOById(auth()->user()->NidUser);
        $Users->CreateDate = verta($Users->CreateDate);
        $Users->LastLoginDate = verta($Users->LastLoginDate);
        $logs = $api->GetCurrentUserLogReport(auth()->user()->NidUser);
        $logins = $api->GetCurrentUserLoginReport(auth()->user()->NidUser);
        $Permissions = $api->GetRolePermissionsByUser(auth()->user()->NidUser);
        $userPermissions = $api->GetAllUserPermissionDTOsByUserId(auth()->user()->NidUser);
        $api->AddLog(auth()->user(), $request->ip(), 1, 0, 2, 1, "پروفایل");
        return view('User.Profile', compact('Users', 'logs', 'Permissions', 'logins', 'userPermissions'));
    }
    public function ProfileUserActivityReport(Request $request, string $NidUser)
    {
        $api = new NPMSController();
        $logs = $api->GetCurrentUserLogReport(auth()->user()->NidUser);
        $api->AddLog(auth()->user(), $request->ip(), 1, 0, 2, 1, "گزارش کاربری");
        return view('User.ProfileUserActivityReport', compact('logs'));
    }
    public function SubmitEditUser(UserRequest $User)
    {
        $User->validated();
        $api = new NPMSController();
        $api->UpdateUser($User);
        $api->AddLog(auth()->user(), $User->ip(), 11, 0, 3, 1, sprintf("ویرایش کاربر موفق.نام کاربر : %s", $User->UserName));
        return redirect('users');
    }
    public function UserSourceChange(int $SourceId)
    {
        $api = new NPMSController();
        $Users = $api->GetCustomUsers($SourceId);
        $result = new JsonResults();
        $result->HasValue = true;
        $result->Html = view('User._UserTable', compact('Users'))->render();
        return response()->json($result);
    }
    public function UserPermissions(Request $request)
    {
        if ($this->CheckAuthority(false, 1, $request->cookie('NPMS_Permissions'), 0)) {
            $api = new NPMSController();
            $Users = $api->GetAllUserPermissionUsers();
            $api->AddLog(auth()->user(), $request->ip(), 1, 0, 1, 1, "مدیریت دسترسی کاربران");
            return view('User.UserPermissions', compact('Users'));
        } else {
            return view('errors.401');
        }
    }
    public function UserPermissionDetail(string $NidUser, Request $request)
    {
        if ($this->CheckAuthority(false, 1, $request->cookie('NPMS_Permissions'), 0)) {
            $api = new NPMSController();
            $UserPermissions = $api->GetAllUserPermissions($NidUser);
            $User = $api->GetUserInPermissionById($NidUser);
            $result = new JsonResults();
            $result->HasValue = true;
            $result->Html = view('User._UserPermissionDetail', compact('UserPermissions', 'User'))->render();
            $api->AddLog(auth()->user(), $request->ip(), 1, 0, 2, 1, "جزییات دسترسی کاربران");
            return response()->json($result);
        } else {
            return view('errors.401');
        }
    }
    public function ManagePermission(string $NidUser, Request $request)
    {
        if ($this->CheckAuthority(false, 1, $request->cookie('NPMS_Permissions'), 0)) {
            $api = new NPMSController();
            $UserPermissions = $api->GetAllUserPermissions($NidUser);
            $User = $api->GetUserInPermissionById($NidUser);
            $Resources = $api->GetAllResources();
            $api->AddLog(auth()->user(), $request->ip(), 1, 0, 2, 1, "اعمال دسترسی کاربران");
            return view('User.ManagePermission', compact('UserPermissions', 'User', 'Resources'));
        } else {
            return view('errors.401');
        }
    }
    public function EditUserPermission(Request $permissions) //array $ResourceIds,string $UserId,string $UserInfo
    {
        if ($this->CheckAuthority(false, 1, $permissions->cookie('NPMS_Permissions'), 0)) {
            $api = new NPMSController();
            $result = new JsonResults();
            if ($api->UpdateUserUserPermissions($permissions->UserId, $permissions->ResourceIds ?? [])) {
                $api->AddLog(auth()->user(), $permissions->ip(), 14, 0, 3, 2, "اعمال دسترسی کاربران موفق");
                $result->HasValue = true;
            } else {
                $api->AddLog(auth()->user(), $permissions->ip(), 14, 1, 3, 2, "اعمال دسترسی کاربران ناموفق");
                $result->HasValue = false;
            }
            return response()->json($result);
        } else {
            return view('errors.401');
        }
    }
    // [AllowAnonymous]
    public function Login()
    {
        return view('User.Login');
    }
    // [AllowAnonymous]
    public function LoadingPage(string $NidUser)
    {
        // return View("_LoadingPage",NidUser);
        return view('User._LoadingPage');
    }
    // [AllowAnonymous]
    public function SubmitLogin(Request $logindata) //string $Username,string $Password
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $loginresult = json_decode($api->LoginThisUser($logindata->Username, $logindata->Password)->getContent(), true);
        if ($loginresult['result'] == 1) {
            $user = $api->GetThisUserByUsername($logindata->Username);
            Auth::login($user);
            $logindata->session()->regenerate();
            Auth::logoutOtherDevices($logindata->Password, 'Password');
            $result->HasValue = true;
            $result->Message = $loginresult['nidUser'];
            $api->AddLog($user, $logindata->ip(), 15, 0, 3, 1, "ورود موفق");
        } else if ($loginresult['result'] == 2) //incorrect password
        {
            $user = $api->GetThisUserByUsername($logindata->Username);
            $api->AddLog($user, $logindata->ip(), 16, 1, 3, 1, "ورود ناموفق.نام کاربری یا کلمه عبور اشتباه است");
            $result->HasValue = false;
            $result->AltProp = "2";
            $result->Message = "نام کاربری یا کلمه عبور صحیح نمی باشد";
        } else if ($loginresult['result'] == 3) //user not found
        {
            // $api->AddLog($user,$logindata->ip(),16,1,3,1,"ورود ناموفق");
            $result->HasValue = false;
            $result->AltProp = "3";
            $result->Message = "نام کاربری یافت نشد";
        } else if ($loginresult['result'] == 4) //lockout
        {
            $user = $api->GetThisUserByUsername($logindata->Username);
            $api->AddLog($user, $logindata->ip(), 16, 1, 3, 1, "ورود ناموفق.کاربر در حالت تعلیق می باشد");
            $result->HasValue = false;
            $result->AltProp = "4";
            $result->Message = "کاربر در حالت تعلیق می باشد";
        } else if ($loginresult['result'] == 5) //change password time
        {
            $user = $api->GetThisUserByUsername($logindata->Username);
            $result->Message = $loginresult['nidUser'];
            $result->HasValue = false;
            $result->AltProp = "5";
        }
        return response()->json($result);
        // return $loginresult;
    }
    public function ChangePassword(string $Niduser)
    {
        return view('User.ChangePassword', compact('Niduser'));
    }
    public function getUsersPassCode(string $Niduser, string $CurrentPassword)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        if (Hash::check($CurrentPassword, $api->GetUserDTOById($Niduser)->Password))
            $result->HasValue = true;
        else
            $result->HasValue = false;
        return response()->json($result);
    }
    // [AllowAnonymous]
    public function SetLoginData(string $Niduser)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $perms = $api->GetRolePermissionsByUser($Niduser);
        $perms2 = $api->GetAllUserPermissionDTOsByUserId($Niduser);
        $userRole = $api->GetAllRoles()->where('NidRole', '=', auth()->user()->RoleId)->firstOrFail()->IsAdmin;
        $tmpPerms = new Collection();
        if ($userRole) {
            $tmpPerms->push('0,1,1,1,1,1,1');
        }
        foreach ($perms as $perm) {
            $tmpPerms->push($perm->EntityId . ',' . $perm->Create . ',' . $perm->Edit . ',' . $perm->Delete . ',' . $perm->Detail . ',' . $perm->List . ',' . $perm->Print);
        }
        foreach ($perms2 as $perm2) {
            $tmpPerms->push($perm2->EntityId . ',' . $perm2->Create . ',' . $perm2->Edit . ',' . $perm2->Delete . ',' . $perm2->Detail . ',' . $perm2->List . ',' . $perm2->Print);
        }
        $output = "";
        if ($tmpPerms->count() > 0) {
            $output = join('#', $tmpPerms->toArray());
        }
        // $api->HandleAlarms();
        return redirect('')->withCookie(cookie('NPMS_Permissions', $output, 480));
    }
    public function Logout(Request $request)
    {
        $api = new NPMSController();
        $api->AddLog(auth()->user(), $request->ip(), 17, 0, 2, 1, "خروج");
        Auth::logout();
        Cookie::queue(Cookie::forget('NPMS_Permissions'));
        return redirect('login');
    }
    public function PasswordPolicy(Request $request)
    {
        if ($this->CheckAuthority(false, 1, $request->cookie('NPMS_Permissions'), 0)) {
            $api = new NPMSController();
            $Policies = $api->GetPolicies();
            $api->AddLog(auth()->user(), $request->ip(), 1, 0, 2, 3, "خط مشی کلمه عبور");
            return view('User.PasswordPolicy', compact('Policies'));
        } else {
            return view('errors.401');
        }
    }
    public function SubmitPasswordPolicy(Request $Policy)
    {
        $api = new NPMSController();
        if ($api->UpdatePolicy($Policy)) {
            $api->AddLog(auth()->user(), $Policy->ip(), 18, 0, 3, 3, "خط مشی کلمه عبور موفق");
            return redirect('/passwordpolicy');
        }
    }
    public function ManageRoles(Request $request)
    {
        if ($this->CheckAuthority(false, 1, $request->cookie('NPMS_Permissions'), 0)) {
            $api = new NPMSController();
            $Roles = $api->GetAllRoles();
            $api->AddLog(auth()->user(), $request->ip(), 1, 0, 2, 3, "مدیریت نقش ها");
            return view('User.ManageRoles', compact('Roles'));
        } else {
            return view('errors.401');
        }
    }
    public function SubmitRoleForm(Request $role)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        if (empty($role->NidRole)) {
            $api->AddRole($role);
            $result->Message = sprintf("نقش با نام %s با موفقیت ایجاد گردید", $role->Title);
            $api->AddLog(auth()->user(), $role->ip(), 19, 0, 3, 3, sprintf("ایجاد نقش موفق.نام نقش : %s", $role->Title));
        } else {
            $api->UpdateRole($role);
            $result->Message = sprintf("یگان با نام %s با موفقیت ویرایش گردید", $role->Title);
            $api->AddLog(auth()->user(), $role->ip(), 19, 1, 3, 3, sprintf("ایجاد نقش ناموفق.نام نقش : %s", $role->Title));
        }
        $TblId = 9;
        $Roles = $api->GetAllRoles();
        $result->Html = view('Project._BaseInfoTables', compact('TblId', 'Roles'))->render();
        $result->HasValue = true;
        return response()->json($result);
        // return $role;
    }
    public function SubmitDeleteRole(Request $request, string $NidRole)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $tmpResult = $api->DeleteRole($NidRole);
        $tmpstatus = json_decode($tmpResult->getContent(), true)['Message'];
        $result->HasValue = false;
        switch ($tmpstatus) {
            case "1":
                $result->Message = "نقش مورد نظر دارای کاربر می باشد.امکان حذف وجود ندارد";
                $api->AddLog(auth()->user(), $request->ip(), 20, 1, 3, 3, sprintf("ایجاد نقش ناموفق.شناسه نقش : %s", $NidRole));
                return response()->json($result);
                break;
            case "2":
                $result->HasValue = true;
                $result->Message = "نقش با موفقیت حذف گردید";
                $TblId = 9;
                $Roles = $api->GetAllRoles();
                $result->Html = view('Project._BaseInfoTables', compact('TblId', 'Roles'))->render();
                $api->AddLog(auth()->user(), $request->ip(), 20, 0, 3, 3, sprintf("ایجاد نقش موفق.شناسه نقش : %s", $NidRole));
                return response()->json($result);
                break;
            case "3":
                $result->Message = "خطا در سرور لطفا مجددا امتحان کنید";
                $api->AddLog(auth()->user(), $request->ip(), 20, 1, 3, 3, sprintf("ایجاد نقش ناموفق.شناسه نقش : %s", $NidRole));
                return response()->json($result);
                break;
        }
    }
    public function ManageRolePermissions(Request $request, string $NidRole)
    {
        if ($this->CheckAuthority(false, 1, $request->cookie('NPMS_Permissions'), 0)) {
            $api = new NPMSController();
            $Permissions = $api->GetAllRolePermissionDTOsByRoleId($NidRole);
            $tmpRole = $api->GetRoleById($NidRole);
            $RoleName = $tmpRole->Title;
            $RoleId = $tmpRole->NidRole;
            $api->AddLog(auth()->user(), $request->ip(), 1, 0, 2, 3, "مدیریت دسترسی نقش ها");
            return view('User.ManageRolePermissions', compact('Permissions', 'RoleName', 'RoleId'));
        } else {
            return view('errors.401');
        }
    }
    public function AddRolePermission(Request $request, string $NidRole)
    {
        if ($this->CheckAuthority(false, 1, $request->cookie('NPMS_Permissions'), 0)) {
            $api = new NPMSController();
            $Roles = $api->GetRoleById($NidRole);
            $Permissions = $api->GetAllRolePermissionDTOsByRoleId($NidRole);
            $CurrentEntites = [];
            foreach ($Permissions as $key => $perm) {
                array_push($CurrentEntites, $perm->EntityId);
            }
            $Entities = new Collection();
            if (!in_array(1, $CurrentEntites))
                $Entities->push(['EntityId' => 1, 'Title' => 'محقق']);
            if (!in_array(2, $CurrentEntites))
                $Entities->push(['EntityId' => 2, 'Title' => 'پروژه']);
            if (!in_array(3, $CurrentEntites))
                $Entities->push(['EntityId' => 3, 'Title' => 'کاربر']);
            if (!in_array(4, $CurrentEntites))
                $Entities->push(['EntityId' => 4, 'Title' => 'گزارش']);
            if (!in_array(5, $CurrentEntites))
                $Entities->push(['EntityId' => 5, 'Title' => 'پیام']);
            if (!in_array(6, $CurrentEntites))
                $Entities->push(['EntityId' => 6, 'Title' => 'اطلاعات پایه']);
            $api->AddLog(auth()->user(), $request->ip(), 1, 0, 2, 3, "ایجاد دسترسی نقش ها");
            return view('User.AddRolePermission', compact('Roles', 'Entities'));
        } else {
            return view('errors.401');
        }
    }
    public function SubmitAddRolePermission(Request $Permission)
    {
        $api = new NPMSController();
        $api->AddRolePermission($Permission);
        $api->AddLog(auth()->user(), $Permission->ip(), 21, 0, 3, 3, sprintf("ایجاد دسترسی نقش موفق.شناسه نقش : %s", $Permission->RoleId));
        return redirect(sprintf("/managerolepermissions/%s", $Permission->RoleId));
    }
    public function EditRolePermission(string $NidPermission, Request $request)
    {
        if ($this->CheckAuthority(false, 1, $request->cookie('NPMS_Permissions'), 0)) {
            $api = new NPMSController();
            $Role = $api->GetRolePermissionsById($NidPermission);
            $Roles = $api->GetRoleById($Role->RoleId);
            $Entities = new Collection();
            if ($Role->EntityId == 1)
                $Entities->push(['EntityId' => 1, 'Title' => 'محقق']);
            if ($Role->EntityId == 2)
                $Entities->push(['EntityId' => 2, 'Title' => 'پروژه']);
            if ($Role->EntityId == 3)
                $Entities->push(['EntityId' => 3, 'Title' => 'کاربر']);
            if ($Role->EntityId == 4)
                $Entities->push(['EntityId' => 4, 'Title' => 'گزارش']);
            if ($Role->EntityId == 5)
                $Entities->push(['EntityId' => 5, 'Title' => 'پیام']);
            if ($Role->EntityId == 6)
                $Entities->push(['EntityId' => 6, 'Title' => 'اطلاعات پایه']);
            $api->AddLog(auth()->user(), $request->ip(), 1, 0, 2, 3, "ویرایش دسترسی نقش ها");
            return view('User.EditRolePermission', compact('Roles', 'Entities', 'Role'));
        } else {
            return view('errors.401');
        }
        // return $Role;
    }
    public function SubmitEditRolePermission(Request $Permission)
    {
        $api = new NPMSController();
        $api->UpdateRolePermission($Permission);
        $api->AddLog(auth()->user(), $Permission->ip(), 22, 0, 3, 3, sprintf("ویرایش دسترسی نقش موفق.شناسه نقش : %s", $Permission->RoleId));
        return redirect(sprintf('/managerolepermissions/%s', $Permission->RoleId));
        // return $Permission;
    }
    public function DeleteRolePermission(string $NidPermission, Request $request)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $api->DeleteRolePermission($NidPermission);
        $result->HasValue = true;
        $api->AddLog(auth()->user(), $request->ip(), 23, 0, 3, 3, sprintf("حذف دسترسی نقش موفق.شناسه نقش : %s", $NidPermission));
        return response()->json($result);
    }
    public function ManageSessions(Request $request)
    {
        if ($this->CheckAuthority(false, 1, $request->cookie('NPMS_Permissions'), 0)) {
            $api = new NPMSController();
            $sets = $api->GetSessionsSettings();
            $users = $api->GetAllOnlineUsers();
            $api->AddLog(auth()->user(), $request->ip(), 1, 0, 2, 3, "مدیریت نشست ها");
            return view('User.ManageSessions', compact('sets', 'users'));
        } else {
            return view('errors.401');
        }
    }
    public function SubmitSessionSetting(Request $request)
    {

        // config('session.lifetime',$request->SessionTimeout);
        $api = new NPMSController();
        $api->UpdateSessionsSettings($request->SessionTimeout);
        $api->AddLog(auth()->user(), $request->ip(), 37, 0, 2, 3, "ثبت تغییرات نشست");
        return redirect('/managesessions');
        // return $request->SessionTimeout;
    }
    public function ManageRolesUser(Request $request, string $NidRole)
    {
        if ($this->CheckAuthority(false, 1, $request->cookie('NPMS_Permissions'), 0)) {
            $api = new NPMSController();
            $Users = $api->GetAllRoleUsers($NidRole);
            $tmpRole = $api->GetRoleById($NidRole);
            $RoleName = $tmpRole->Title;
            $api->AddLog(auth()->user(), $request->ip(), 1, 0, 2, 3, "کاربران نقش");
            return view('User.ManageRolesUser', compact('Users', 'RoleName'));
        } else {
            return view('errors.401');
        }
    }
    public function ManageUserPermission(Request $request, string $NidUser)
    {
        if ($this->CheckAuthority(false, 1, $request->cookie('NPMS_Permissions'), 0)) {
            $api = new NPMSController();
            $Permissions = $api->GetAllUserPermissionDTOsByUserId($NidUser);
            $tmpUser = $api->GetUserById($NidUser);
            $UserName = $tmpUser->UserName;
            $UserId = $NidUser;
            $RoleId = $tmpUser->RoleId;
            $api->AddLog(auth()->user(), $request->ip(), 1, 0, 2, 3, "مدیریت دسترسی کاربر ها");
            return view('User.ManageUserPermission', compact('Permissions', 'UserName', 'UserId', 'RoleId'));
        } else {
            return view('errors.401');
        }
    }
    public function AddUserPermission(Request $request, string $NidUser)
    {
        if ($this->CheckAuthority(false, 1, $request->cookie('NPMS_Permissions'), 0)) {
            $api = new NPMSController();
            $User = $api->GetUserById($NidUser);
            $Permissions = $api->GetAllUserPermissionDTOsByUserId($NidUser);
            $CurrentEntites = [];
            foreach ($Permissions as $key => $perm) {
                array_push($CurrentEntites, $perm->EntityId);
            }
            $Entities = new Collection();
            if (!in_array(1, $CurrentEntites))
                $Entities->push(['EntityId' => 1, 'Title' => 'محقق']);
            if (!in_array(2, $CurrentEntites))
                $Entities->push(['EntityId' => 2, 'Title' => 'پروژه']);
            if (!in_array(3, $CurrentEntites))
                $Entities->push(['EntityId' => 3, 'Title' => 'کاربر']);
            if (!in_array(4, $CurrentEntites))
                $Entities->push(['EntityId' => 4, 'Title' => 'گزارش']);
            if (!in_array(5, $CurrentEntites))
                $Entities->push(['EntityId' => 5, 'Title' => 'پیام']);
            if (!in_array(6, $CurrentEntites))
                $Entities->push(['EntityId' => 6, 'Title' => 'اطلاعات پایه']);
            $api->AddLog(auth()->user(), $request->ip(), 1, 0, 2, 3, "ایجاد دسترسی کاربر ها");
            return view('User.AddUserPermission', compact('User', 'Entities'));
        } else {
            return view('errors.401');
        }
    }
    public function SubmitAddUserPermission(Request $Permission)
    {
        $api = new NPMSController();
        $api->AddUserPermission($Permission);
        $api->AddLog(auth()->user(), $Permission->ip(), 38, 0, 3, 3, "ایجاد دسترسی کاربر موفق");
        return redirect(sprintf("/manageuserpermission/%s", $Permission->UserId));
    }
    public function DeleteUserPermission(Request $request, string $NidPermission)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $api->DeleteUserPermission($NidPermission);
        $result->HasValue = true;
        $api->AddLog(auth()->user(), $request->ip(), 39, 0, 3, 3, "حذف دسترسی کاربر موفق");
        return response()->json($result);
    }
}
