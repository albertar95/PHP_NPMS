<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\NPMSController;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use resources\ViewModels\ManagePermissionViewModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except'=>['Login','SubmitLogin','SetLoginData']]);
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
    public function Index()
    {
        return view('General.Index');
    }
    public function AddUser()
    {
        $api = new NPMSController();
        $Roles = $api->GetAllRoles();
        return view('User.AddUser',compact('Roles'));
    }
    public function SubmitAddUser(Request $user)
    {
        $api = new NPMSController();
        return $api->AddUser($user);
    }
    public function Users()
    {
        $api = new NPMSController();
        $Users = $api->GetAllUsers(0);
        return view('User.Users',compact('Users'));
    }
    public function UserDetail(string $NidUser)
    {
        $api = new NPMSController();
        $Users = $api->GetUserDTOById($NidUser);
        $result = new JsonResults();
        $result->HasValue = true;
        $result->Html = view('User._UserDetail',compact('Users'))->render();
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
    public function DisableUser(string $NidUser)
    {
        $api = new NPMSController();
        $tmpresult = $api->DisableUserById($NidUser);
        $result = new JsonResults();
        if(!is_null($tmpresult))
        {
            $result->HasValue = true;
            $tmpUser = $api->DisableUserById($NidUser);
            $result->Message = sprintf("کاربر با نام کاربری %s با موفقیت غیرفعال گردید",$tmpUser->Username);
            return response()->json($result);
        }else
        {
            $result->HasValue = false;
            $result->Message = "خطا در سرور لطفا مجددا امتحان کنید";
            return response()->json($result);
        }
    }
    public function EditUser(string $NidUser)
    {
        $api = new NPMSController();
        $User = $api->GetUserDTOById($NidUser);
        $Roles = $api->GetAllRoles();
        return view('User.EditUser',compact('User','Roles'));
    }
    public function SubmitChangePassword(string $NidUser,string $NewPassword)
    {
        $api = new NPMSController();
        $res = $api->ResetPassword($NidUser,$NewPassword);
        $state = json_decode($res->getContent(),true)['HasValue'];
        $newPass = json_decode($res->getContent(),true)['Message'];
        $jsonresult = new JsonResults();
        $jsonresult->HasValue = $state;
        $jsonresult->Message = $newPass;
        return response()->json($jsonresult);
    }
    public function SubmitEditUser(Request $User)
    {
        $api = new NPMSController();
        $api->UpdateUser($User);
        return redirect('users');
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     var UpdateScholarResult = client.PostAsJsonAsync("user/UpdateUserDTO", User).Result;
        //     if (UpdateScholarResult.IsSuccessStatusCode)
        //     {
        //         TempData["EditUserSuccessMessage"] = $"کاربر با نام {User.FirstName} {User.LastName} با موفقیت ویرایش گردید";
        //     }
        //     else
        //         TempData["EditUserErrorMessage"] = $"خطا در انجام عملیات لطفا مجدد امتحان کنید";
        // }
        // return RedirectToAction("Users");
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
    public function UserPermissions()
    {
        $api = new NPMSController();
        $Users = $api->GetAllUserPermissionUsers();
        return view('User.UserPermissions',compact('Users'));
    }
    public function UserPermissionDetail(string $NidUser)
    {
        $api = new NPMSController();
        $UserPermissions = $api->GetAllUserPermissions($NidUser);
        $User = $api->GetUserInPermissionById($NidUser);
        $result = new JsonResults();
        $result->HasValue = true;
        $result->Html = view('User._UserPermissionDetail',compact('UserPermissions','User'))->render();
        return response()->json($result);
    }
    public function ManagePermission(string $NidUser)
    {
        $api = new NPMSController();
        $UserPermissions = $api->GetAllUserPermissions($NidUser);
        $User = $api->GetUserInPermissionById($NidUser);
        $Resources = $api->GetAllResources();
        return view('User.ManagePermission',compact('UserPermissions','User','Resources'));
    }
    public function EditUserPermission(Request $permissions)//array $ResourceIds,string $UserId,string $UserInfo
    {
        $api = new NPMSController();
        $result = new JsonResults();
        if($api->UpdateUserUserPermissions($permissions->UserId,$permissions->ResourceIds ?? []))
        {
            $result->HasValue = true;
        }else
        {
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
            $result->HasValue = true;
            $result->Message = $loginresult['nidUser'];
        }else
        {
            $result->HasValue = false;
        }
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
        Auth::logout();
        Cookie::queue(Cookie::forget('NPMS_Permissions'));
        return redirect('login');
    }
    public function PasswordPolicy()
    {
        $api = new NPMSController();
        $Policies = $api->GetPolicies();
        return view('User.PasswordPolicy',compact('Policies'));
    }
    public function SubmitPasswordPolicy(Request $Policy)
    {
        $api = new NPMSController();
        if($api->UpdatePolicy($Policy))
        {
            return redirect('/passwordpolicy');
        }
    }
    public function ManageRoles()
    {
        $api = new NPMSController();
        $Roles = $api->GetAllRoles();
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
        }else
        {
            $api->UpdateRole($role);
            $result->Message = sprintf("یگان با نام %s با موفقیت ویرایش گردید",$role->Title);
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
    public function ManageRolePermissions()
    {
        $api = new NPMSController();
        $Permissions = $api->GetAllRolePermissionDTOs();
        return view('User.ManageRolePermissions',compact('Permissions'));
    }
    public function AddRolePermission()
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
        return view('User.AddRolePermission',compact('Roles','Entities'));
    }
    public function SubmitAddRolePermission(Request $Permission)
    {
        $api = new NPMSController();
        $api->AddRolePermission($Permission);
        return redirect('/managerolepermissions');
    }
    public function EditRolePermission(string $NidPermission)
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
        return view('User.EditRolePermission',compact('Roles','Entities','Role'));
        // return $Role;
    }
    public function SubmitEditRolePermission(Request $Permission)
    {
        $api = new NPMSController();
        $api->UpdateRolePermission($Permission);
        return redirect('/managerolepermissions');
        // return $Permission;
    }
    public function DeleteRolePermission(string $NidPermission)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $api->DeleteRolePermission($NidPermission);
        $result->HasValue = true;
        return response()->json($result);
    }
}
