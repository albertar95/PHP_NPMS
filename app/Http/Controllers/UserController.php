<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\NPMSController;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use resources\ViewModels\ManagePermissionViewModel;

class UserController extends Controller
{
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
        if($api->UpdateUser($User))
        {
            redirect('Users');
        }
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
        $result->Html = view('User._UserTable',$Users)->render();
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
        if($api->UpdateUserUserPermissions($permissions->UserId,join(',',$permissions->ResourceIds)))
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
        // bool IsLogin = false;
        // string LoginMessage = "";
        // if(!string.IsNullOrWhiteSpace(Username) && !string.IsNullOrWhiteSpace(Password))
        // {
        //     using (var client = new HttpClient())
        //     {
        //         client.BaseAddress = new Uri(ApiBaseAddress);
        //         client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //         HttpResponseMessage response = client.GetAsync($"User/LoginThisUser?Username={Username}&Password={Password}").Result;
        //         if (response.IsSuccessStatusCode)
        //         {
        //             Tuple<byte, Guid> result = response.Content.ReadAsAsync<Tuple<byte, Guid>>().Result;
        //             switch (result.Item1)
        //             {
        //                 case 1:
        //                     IsLogin = true;
        //                     LoginMessage = result.Item2.ToString();
        //                     break;
        //                 case 2:
        //                     LoginMessage = "کلمه عبور وارد شده صحیح نمی باشد";
        //                     break;
        //                 case 3:
        //                     LoginMessage = "کاربر مورد نظر یافت نشد";
        //                     break;
        //             }
        //         }else
        //             LoginMessage = "خطا در سرور.لطفا مجدد امتحان کنید";
        //     }
        // }else
        //     LoginMessage = "لطفا نام کاربری و کلمه عبور را وارد نمایید";
        // return Json(new JsonResults() { HasValue = IsLogin, Message = LoginMessage });
    }
    // [AllowAnonymous]
    public function SetLoginData(string $Niduser)
    {
        // string UserData = "";
        // string UserPermissions = "";
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     HttpResponseMessage UserDTOResponse = client.GetAsync($"User/GetUserDTOById?UserId={Niduser}").Result;
        //     if (UserDTOResponse.IsSuccessStatusCode)
        //     {
        //         var tmpuser = UserDTOResponse.Content.ReadAsAsync<UserDTO>().Result;
        //         HttpResponseMessage UserPermissionDTOResponse = client.GetAsync($"UserPermission/GetAllUserPermissions?NidUser={Niduser}").Result;
        //         if (UserPermissionDTOResponse.IsSuccessStatusCode)
        //         {
        //             UserData = GenerateUserData(tmpuser, null, false);
        //             UserPermissions = GenerateUserData(null, UserPermissionDTOResponse.Content.ReadAsAsync<List<UserPermissionDTO>>().Result, true);
        //         }
        //         FormsAuthentication.SetAuthCookie(UserData, true);
        //         FormsAuthenticationTicket ticket = new FormsAuthenticationTicket(1, tmpuser.Username, DateTime.Now, DateTime.Now.AddHours(8), false, UserPermissions);
        //         var encdata = FormsAuthentication.Encrypt(ticket);
        //         var tmpCookie = new HttpCookie("NPMS_Permissions", encdata);
        //         tmpCookie.Expires = DateTime.Now.AddHours(8);
        //         Response.Cookies.Add(tmpCookie);
        //         if (!string.IsNullOrWhiteSpace(tmpuser.ProfilePicture))
        //         {
        //             Image image;
        //             byte[] bytes = Convert.FromBase64String(tmpuser.ProfilePicture);
        //             using (MemoryStream ms = new MemoryStream(bytes))
        //             {
        //                 image = Image.FromStream(ms);
        //             }
        //             Bitmap resized = JsonResults.ResizeImage(image, 80, 80);
        //             string tmpFileName = Server.MapPath("~/ImageTiles/") + tmpuser.NidUser + ".jpg";
        //             using (resized)
        //             {
        //                 ImageCodecInfo jpgEncoder = JsonResults.GetEncoder(ImageFormat.Jpeg);
        //                 System.Drawing.Imaging.Encoder myEncoder =
        //                     System.Drawing.Imaging.Encoder.Quality;
        //                 EncoderParameters myEncoderParameters = new EncoderParameters(1);

        //                 EncoderParameter myEncoderParameter = new EncoderParameter(myEncoder, 80L);
        //                 myEncoderParameters.Param[0] = myEncoderParameter;
        //                 resized.Save(tmpFileName, jpgEncoder, myEncoderParameters);
        //             }
        //         }
        //         return Json(new JsonResults() { HasValue = true });
        //     }else
        //     {
        //         return Json(new JsonResults() { HasValue = false });
        //     }
        // }
    }
    private function GenerateUserData(Request $user,Collection $permissions,bool $isPermission)
    {
        // string output = "";
        // if (isPermission)
        // {
        //     //#permissions#
        //     output += string.Join("#", permissions.Select(p => p.ResourceId).ToList());
        //     return output;
        // }
        // else
        // {
        //     //firstname lastname,userLevel,userguid,userImage
        //     output += user.FirstName + " " + user.LastName + ",";
        //     if (user.IsAdmin)
        //         output += "Admin" + ",";
        //     else
        //         output += "Simple" + ",";
        //     output += user.NidUser + ",";
        //     if (!string.IsNullOrWhiteSpace(user.ProfilePicture))
        //         output += "true";
        //     else
        //         output += "false";
        //     return DataAccessLibrary.Helpers.Encryption.Encrypt(output);
        // }
    }
    public function Logout()
    {
        // FormsAuthentication.SignOut();
        // Response.Cookies["NPMS_Permissions"].Expires = DateTime.Now.AddHours(-1);
        // Response.Cookies["NPMS_ProfilePicture"].Expires = DateTime.Now.AddHours(-1);
        // return RedirectToAction("Login");
    }
}
