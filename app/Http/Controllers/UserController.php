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
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except'=>['Login','SubmitLogin','SetLoginData']]);
    }
    public function AddUser()
    {
        return view('User.AddUser');
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
        if(json_decode($tmpresult->getContent(),true)['HasValue'])
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
        return view('User.EditUser',compact('User'));
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
        $permissions = $api->GetAllUserPermissions($Niduser)->pluck('NidPermission')->toArray();
        $output = "";
        if($permissions != null)
        {
            $output = join('#',$permissions);
        }
        return redirect('')->withCookie(cookie('NPMS_Permissions', $output, 480));
    }
    public function Logout(Request $request)
    {
        Auth::logout();
        Cookie::queue(Cookie::forget('NPMS_Permissions'));
        return redirect('login');
    }
}
