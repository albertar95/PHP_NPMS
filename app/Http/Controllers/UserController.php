<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\NPMSController;
use App\Models\User;
use App\Models\Users;
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
        $this->middleware('auth',['except'=>['Login','SubmitLogin','SetLoginData','ChangePassword','SubmitChangePassword','getUsersPassCode']]);
    }
    private static function GetEntityPermissionsFromCache()
    {
        $raw = Cookie::get('NPMS_Permissions');
        $row = explode('#',$raw);
        $AccessedEntities = new Collection();
        foreach ($row as $r)
        {
            $AccessedEntities->push(explode(',',$r)[0]);
        }
        return $AccessedEntities->toArray();
    }
    private static function GetSubPermissionsFromCache()
    {
        $raw = Cookie::get('NPMS_Permissions');
        $row = explode('#',$raw);
        $AccessedSub = new Collection();
        foreach ($row as $r)
        {
            $AccessedSub->push(["entity" => explode(',',$r)[0],"rowValue" => substr($r,2,strlen($r)-2)]);
        }
        return $AccessedSub;
    }
    public function Index(Request $request)
    {
        $api = new NPMSController();
        $api->AddLog(auth()->user(),$request->ip(),1,0,1,1,"داشبورد");
        return view('General.Index');
    }
    public function AddUser(Request $request)
    {
        $api = new NPMSController();
        $Roles = $api->GetAllRoles();
        $api->AddLog(auth()->user(),$request->ip(),1,0,2,1,"ایجاد کاربر");
        return view('User.AddUser',compact('Roles'));
    }
    public function SubmitAddUser(Request $user)
    {
        $api = new NPMSController();
        $api->AddLog(auth()->user(),$user->ip(),10,0,3,1,"ایجاد کاربر موفق");
        return $api->AddUser($user);
    }
    public function Users(Request $request)
    {
        $api = new NPMSController();
        $Users = $api->GetAllUsers(0);
        $api->AddLog(auth()->user(),$request->ip(),1,0,1,1,"مدیریت کاربران");
        return view('User.Users',compact('Users'));
    }
    public function UserDetail(string $NidUser,Request $request)
    {
        $api = new NPMSController();
        $Users = $api->GetUserDTOById($NidUser);
        $result = new JsonResults();
        $result->HasValue = true;
        $result->Html = view('User._UserDetail',compact('Users'))->render();
        $api->AddLog(auth()->user(),$request->ip(),1,0,2,1,"جزییات کاربر");
        return response()->json($result);
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
    public function DisableUser(string $NidUser,Request $request)
    {
        $api = new NPMSController();
        $tmpresult = $api->DisableUserById($NidUser);
        $result = new JsonResults();
        if(!is_null($tmpresult))
        {
            $result->HasValue = true;
            $tmpUser = $api->DisableUserById($NidUser);
            $result->Message = sprintf("کاربر با نام کاربری %s با موفقیت غیرفعال گردید",$tmpUser->Username);
            $api->AddLog(auth()->user(),$request->ip(),12,0,3,1,"ایجاد کاربر موفق");
            return response()->json($result);
        }else
        {
            $result->HasValue = false;
            $result->Message = "خطا در سرور لطفا مجددا امتحان کنید";
            $api->AddLog(auth()->user(),$request->ip(),12,1,3,1,"ایجاد کاربر ناموفق");
            return response()->json($result);
        }
    }
    public function EditUser(string $NidUser,Request $request)
    {
        $api = new NPMSController();
        $User = $api->GetUserDTOById($NidUser);
        $Roles = $api->GetAllRoles();
        $api->AddLog(auth()->user(),$request->ip(),1,0,2,1,"ویرایش کاربر");
        return view('User.EditUser',compact('User','Roles'));
    }
    public function SubmitChangePassword(string $NidUser,string $NewPassword,Request $request)
    {
        $api = new NPMSController();
        if(!$api->CheckPrePassword($NidUser,$NewPassword))
        {
            $jsonresult = new JsonResults();
            $jsonresult->HasValue = false;
            $jsonresult->AltProp = "1";
            // $api->AddLog(auth()->user(),$request->ip(),13,0,3,2,"تغییر رمز کاربر موفق");
            return response()->json($jsonresult);
        }else
        {
            $res = $api->ResetPassword($NidUser,$NewPassword);
            $state = json_decode($res->getContent(),true)['HasValue'];
            $newPass = json_decode($res->getContent(),true)['Message'];
            $jsonresult = new JsonResults();
            $jsonresult->HasValue = $state;
            $jsonresult->Message = $newPass;
            $jsonresult->AltProp = "2";
            // $api->AddLog(auth()->user(),$request->ip(),13,0,3,2,"تغییر رمز کاربر موفق");
            return response()->json($jsonresult);
        }
    }
    public function Profile()
    {
        return view('User.Profile');
    }
    public function SubmitEditUser(Request $User)
    {
        $api = new NPMSController();
        $api->UpdateUser($User);
        $api->AddLog(auth()->user(),$User->ip(),11,0,3,1,"ویرایش کاربر موفق");
        return redirect('users');
    }
    public function UserSourceChange(int $SourceId)
    {
        $api = new NPMSController();
        $Users = $api->GetCustomUsers($SourceId);
        $result = new JsonResults();
        $result->HasValue = true;
        $result->Html = view('User._UserTable',compact('Users'))->render();
        return response()->json($result);
    }
    public function UserPermissions(Request $request)
    {
        $api = new NPMSController();
        $Users = $api->GetAllUserPermissionUsers();
        $api->AddLog(auth()->user(),$request->ip(),1,0,1,1,"مدیریت دسترسی کاربران");
        return view('User.UserPermissions',compact('Users'));
    }
    public function UserPermissionDetail(string $NidUser,Request $request)
    {
        $api = new NPMSController();
        $UserPermissions = $api->GetAllUserPermissions($NidUser);
        $User = $api->GetUserInPermissionById($NidUser);
        $result = new JsonResults();
        $result->HasValue = true;
        $result->Html = view('User._UserPermissionDetail',compact('UserPermissions','User'))->render();
        $api->AddLog(auth()->user(),$request->ip(),1,0,2,1,"جزییات دسترسی کاربران");
        return response()->json($result);
    }
    public function ManagePermission(string $NidUser,Request $request)
    {
        $api = new NPMSController();
        $UserPermissions = $api->GetAllUserPermissions($NidUser);
        $User = $api->GetUserInPermissionById($NidUser);
        $Resources = $api->GetAllResources();
        $api->AddLog(auth()->user(),$request->ip(),1,0,2,1,"اعمال دسترسی کاربران");
        return view('User.ManagePermission',compact('UserPermissions','User','Resources'));
    }
    public function EditUserPermission(Request $permissions)//array $ResourceIds,string $UserId,string $UserInfo
    {
        $api = new NPMSController();
        $result = new JsonResults();
        if($api->UpdateUserUserPermissions($permissions->UserId,$permissions->ResourceIds ?? []))
        {
            $api->AddLog(auth()->user(),$permissions->ip(),14,0,3,2,"اعمال دسترسی کاربران موفق");
            $result->HasValue = true;
        }else
        {
            $api->AddLog(auth()->user(),$permissions->ip(),14,1,3,2,"اعمال دسترسی کاربران ناموفق");
            $result->HasValue = false;
        }
        return response()->json($result);
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
    public function SubmitLogin(Request $logindata)//string $Username,string $Password
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $loginresult = json_decode($api->LoginThisUser($logindata->Username,$logindata->Password)->getContent(),true);
        if($loginresult['result'] == 1)
        {
            $user = $api->GetThisUserByUsername($logindata->Username);
            Auth::login($user);
            $logindata->session()->regenerate();
            Auth::logoutOtherDevices($logindata->Password,'Password');
            $result->HasValue = true;
            $result->Message = $loginresult['nidUser'];
            $api->AddLog($user,$logindata->ip(),15,0,3,1,"ورود موفق");
        }else if($loginresult['result'] == 2)//incorrect password
        {
            // $api->AddLog(new User(),$logindata->ip(),16,1,3,1,"ورود ناموفق");
            $result->HasValue = false;
            $result->AltProp = "2";
            $result->Message = "نام کاربری یا کلمه عبور صحیح نمی باشد";
        }else if($loginresult['result'] == 3)//user not found
        {
            // $api->AddLog(new User(),$logindata->ip(),16,1,3,1,"ورود ناموفق");
            $result->HasValue = false;
            $result->AltProp = "3";
            $result->Message = "نام کاربری یافت نشد";
        }
        else if($loginresult['result'] == 4) //lockout
        {
            $result->HasValue = false;
            $result->AltProp = "4";
            $result->Message = "کاربر در حالت تعلیق می باشد";
        }
        else if($loginresult['result'] == 5)//change password time
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
        return view('User.ChangePassword',compact('Niduser'));
    }
    public function getUsersPassCode(string $Niduser,string $CurrentPassword)
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
        $userRole = $api->GetAllRoles()->where('NidRole','=',auth()->user()->RoleId)->firstOrFail()->IsAdmin;
        $tmpPerms = new Collection();
        if($userRole)
        {
            $tmpPerms->push('0,0,0,0,0,0,0');
        }
        foreach ($perms as $perm)
        {
            $tmpPerms->push($perm->EntityId.','.$perm->Create.','.$perm->Edit.','.$perm->Delete.','.$perm->Detail.','.$perm->List.','.$perm->Print);
        }
        $output = "";
        if($tmpPerms->count() > 0)
        {
            $output = join('#',$tmpPerms->toArray());
        }
        return redirect('')->withCookie(cookie('NPMS_Permissions', $output, 480));
    }
    public function Logout(Request $request)
    {
        $api = new NPMSController();
        $api->AddLog(auth()->user(),$request->ip(),17,0,2,1,"خروج");
        Auth::logout();
        Cookie::queue(Cookie::forget('NPMS_Permissions'));
        return redirect('login');
    }
    public function PasswordPolicy(Request $request)
    {
        $api = new NPMSController();
        $Policies = $api->GetPolicies();
        $api->AddLog(auth()->user(),$request->ip(),1,0,2,3,"خط مشی کلمه عبور");
        return view('User.PasswordPolicy',compact('Policies'));
    }
    public function SubmitPasswordPolicy(Request $Policy)
    {
        $api = new NPMSController();
        if($api->UpdatePolicy($Policy))
        {
            $api->AddLog(auth()->user(),$Policy->ip(),18,0,3,3,"خط مشی کلمه عبور موفق");
            return redirect('/passwordpolicy');
        }
    }
    public function ManageRoles(Request $request)
    {
        $api = new NPMSController();
        $Roles = $api->GetAllRoles();
        $api->AddLog(auth()->user(),$request->ip(),1,0,2,3,"مدیریت نقش ها");
        return view('User.ManageRoles',compact('Roles'));
    }
    public function SubmitRoleForm(Request $role)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        if(empty($role->NidRole))
        {
            $api->AddRole($role);
            $result->Message = sprintf("نقش با نام %s با موفقیت ایجاد گردید",$role->Title);
            $api->AddLog(auth()->user(),$role->ip(),19,0,3,3,"ایجاد نقش موفق");
        }else
        {
            $api->UpdateRole($role);
            $result->Message = sprintf("یگان با نام %s با موفقیت ویرایش گردید",$role->Title);
            $api->AddLog(auth()->user(),$role->ip(),19,1,3,3,"ایجاد نقش ناموفق");
        }
        $TblId = 9;
        $Roles = $api->GetAllRoles();
        $result->Html = view('Project._BaseInfoTables',compact('TblId','Roles'))->render();
        $result->HasValue = true;
        return response()->json($result);
        // return $role;
    }
    public function SubmitDeleteRole(string $NidRole)
    {
        // $api = new NPMSController();
        // $result = new JsonResults();
        // $tmpResult = $api->deleterole($NidUnit);
        // $tmpstatus = json_decode($tmpResult->getContent(),true)['Message'];
        // $result->HasValue = false;
        // switch($tmpstatus)
        // {
        //     case "1":
        //         $result->Message = "یگان مورد نظر دارای گروه می باشد.امکان حذف وجود ندارد";
        //         return response()->json($result);
        //         break;
        //     case "2":
        //         $result->HasValue = true;
        //         $result->Message = "یگان با موفقیت حذف گردید";
        //         $TblId = 1;
        //         $Units = $api->GetAllUnits();
        //         $result->Html = view('Project._BaseInfoTables',compact('TblId','Units'))->render();
        //         return response()->json($result);
        //         break;
        //     case "3":
        //         $result->Message = "خطا در سرور لطفا مجددا امتحان کنید";
        //         return response()->json($result);
        //         break;
        // }
    }
    public function ManageRolePermissions(Request $request)
    {
        $api = new NPMSController();
        $Permissions = $api->GetAllRolePermissionDTOs();
        $api->AddLog(auth()->user(),$request->ip(),1,0,2,3,"مدیریت دسترسی نقش ها");
        return view('User.ManageRolePermissions',compact('Permissions'));
    }
    public function AddRolePermission(Request $request)
    {
        $api = new NPMSController();
        $Roles = $api->GetAllRoles();
        $Entities = new Collection();
        $Entities->push(['EntityId' => 1,'Title' => 'محقق']);
        $Entities->push(['EntityId' => 2,'Title' => 'پروژه']);
        $Entities->push(['EntityId' => 3,'Title' => 'کاربر']);
        $Entities->push(['EntityId' => 4,'Title' => 'گزارش']);
        $Entities->push(['EntityId' => 5,'Title' => 'پیام']);
        $Entities->push(['EntityId' => 6,'Title' => 'اطلاعات پایه']);
        $api->AddLog(auth()->user(),$request->ip(),1,0,2,3,"ایجاد دسترسی نقش ها");
        return view('User.AddRolePermission',compact('Roles','Entities'));
    }
    public function SubmitAddRolePermission(Request $Permission)
    {
        $api = new NPMSController();
        $api->AddRolePermission($Permission);
        $api->AddLog(auth()->user(),$Permission->ip(),21,0,3,3,"ایجاد دسترسی نقش موفق");
        return redirect('/managerolepermissions');
    }
    public function EditRolePermission(string $NidPermission,Request $request)
    {
        $api = new NPMSController();
        $Roles = $api->GetAllRoles();
        $Entities = new Collection();
        $Entities->push(['EntityId' => 1,'Title' => 'محقق']);
        $Entities->push(['EntityId' => 2,'Title' => 'پروژه']);
        $Entities->push(['EntityId' => 3,'Title' => 'کاربر']);
        $Entities->push(['EntityId' => 4,'Title' => 'گزارش']);
        $Entities->push(['EntityId' => 5,'Title' => 'پیام']);
        $Entities->push(['EntityId' => 6,'Title' => 'اطلاعات پایه']);
        $Role = $api->GetRolePermissionsById($NidPermission);
        $api->AddLog(auth()->user(),$request->ip(),1,0,2,3,"ویرایش دسترسی نقش ها");
        return view('User.EditRolePermission',compact('Roles','Entities','Role'));
        // return $Role;
    }
    public function SubmitEditRolePermission(Request $Permission)
    {
        $api = new NPMSController();
        $api->UpdateRolePermission($Permission);
        $api->AddLog(auth()->user(),$Permission->ip(),22,0,3,3,"ویرایش دسترسی نقش موفق");
        return redirect('/managerolepermissions');
        // return $Permission;
    }
    public function DeleteRolePermission(string $NidPermission,Request $request)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $api->DeleteRolePermission($NidPermission);
        $result->HasValue = true;
        $api->AddLog(auth()->user(),$request->ip(),23,0,3,3,"حذف دسترسی نقش موفق");
        return response()->json($result);
    }
    public function ManageSessions(Request $request)
    {
        $api = new NPMSController();
        $sets = $api->GetSessionsSettings();
        return view('User.ManageSessions',compact('sets'));
    }
    public function SubmitSessionSetting(Request $request)
    {

        // config('session.lifetime',$request->SessionTimeout);
        $api = new NPMSController();
        $api->UpdateSessionsSettings($request->SessionTimeout);
        return redirect('/managesessions');
        // return $request->SessionTimeout;
    }
}
