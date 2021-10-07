<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\NPMSController;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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
        // UserDTO result = new UserDTO();
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     HttpResponseMessage response = client.GetAsync($"User/GetUserDTOById?UserId={NidUser}").Result;
        //     if (response.IsSuccessStatusCode)
        //     {
        //         result = response.Content.ReadAsAsync<UserDTO>().Result;
        //     }
        // }
        // return Json(new JsonResults() { HasValue = true, Html = JsonResults.RenderViewToString(this.ControllerContext, "_UserDetail", result) });
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
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     HttpResponseMessage disableUserResult = client.GetAsync($"user/DisableUserById?UserId={NidUser}").Result;
        //     if (disableUserResult.IsSuccessStatusCode)
        //     {
        //         var tmpresult = disableUserResult.Content.ReadAsAsync<JsonResults>().Result;
        //         if (tmpresult.HasValue == true)
        //         {
        //             HttpResponseMessage getUserDTOResult = client.GetAsync($"User/GetUserDTOById?UserId={NidUser}").Result;
        //             if (getUserDTOResult.IsSuccessStatusCode)
        //             {
        //                 var tmpUser = getUserDTOResult.Content.ReadAsAsync<UserDTO>().Result;
        //                 TempData["DisableUserSuccessMessage"] = $"کاربر با نام کاربری {tmpUser.Username} با موفقیت غیرفعال گردید";
        //             }
        //             else
        //                 TempData["DisableUserSuccessMessage"] = $"کاربر با موفقیت غیرفعال گردید";
        //             return Json(new JsonResults() { HasValue = true });
        //         }
        //     }
        // }
        // return Json(new JsonResults() { HasValue = false, Message = "خطا در انجام عملیات.لطفا مجددا امتحان کنید" });
    }
    public function EditUser(string $NidUser)
    {
        // UserDTO result = new UserDTO();
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     HttpResponseMessage UserDTOResult = client.GetAsync($"user/GetUserDTOById?UserId={NidUser}").Result;
        //     if (UserDTOResult.IsSuccessStatusCode)
        //     {
        //         result = UserDTOResult.Content.ReadAsAsync<UserDTO>().Result;
        //     }
        // }
        // return View(result);
        return view('User.EditUser');
    }
    public function SubmitEditUser(Request $User)
    {
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
        // List<UserDTO> result = new List<UserDTO>();
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     HttpResponseMessage UserDTOResponse = client.GetAsync($"user/GetCustomUsers?SourceId={SourceId}").Result;
        //     if(UserDTOResponse.IsSuccessStatusCode)
        //     {
        //         result = UserDTOResponse.Content.ReadAsAsync<List<UserDTO>>().Result;
        //     }
        // }
        // return Json(new JsonResults() { Html = JsonResults.RenderViewToString(this.ControllerContext,"_UserTable",result)});
    }
    public function UserPermissions()
    {
        // List<UserInPermissionDTO> result = new List<UserInPermissionDTO>();
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     HttpResponseMessage UserDTOResponse = client.GetAsync($"UserPermission/GetAllUserPermissionUsers").Result;
        //     if (UserDTOResponse.IsSuccessStatusCode)
        //     {
        //         result = UserDTOResponse.Content.ReadAsAsync<List<UserInPermissionDTO>>().Result;
        //     }
        // }
        // return View(result);
        return view('User.UserPermissions');
    }
    public function UserPermissionDetail(string $NidUser)
    {
        // ManagePermissionViewModel mpvm = new ManagePermissionViewModel();
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     HttpResponseMessage UserPermissionDTOResponse = client.GetAsync($"UserPermission/GetAllUserPermissions?NidUser={NidUser}").Result;
        //     if (UserPermissionDTOResponse.IsSuccessStatusCode)
        //     {
        //         mpvm.UserPermissions = UserPermissionDTOResponse.Content.ReadAsAsync<List<UserPermissionDTO>>().Result;
        //     }
        //     HttpResponseMessage UserInPermissionDTOResponse = client.GetAsync($"UserPermission/GetUserInPermissionById?NidUser={NidUser}").Result;
        //     if (UserInPermissionDTOResponse.IsSuccessStatusCode)
        //     {
        //         mpvm.User = UserInPermissionDTOResponse.Content.ReadAsAsync<UserInPermissionDTO>().Result;
        //     }
        // }
        // return Json(new JsonResults() { HasValue = true, Html = JsonResults.RenderViewToString(this.ControllerContext, "_UserPermissionDetail",mpvm) });
    }
    public function ManagePermission(string $NidUser)
    {
        // ManagePermissionViewModel mpvm = new ManagePermissionViewModel();
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     HttpResponseMessage UserPermissionDTOResponse = client.GetAsync($"UserPermission/GetAllUserPermissions?NidUser={NidUser}").Result;
        //     if (UserPermissionDTOResponse.IsSuccessStatusCode)
        //     {
        //         mpvm.UserPermissions = UserPermissionDTOResponse.Content.ReadAsAsync<List<UserPermissionDTO>>().Result;
        //     }
        //     HttpResponseMessage UserInPermissionDTOResponse = client.GetAsync($"UserPermission/GetUserInPermissionById?NidUser={NidUser}").Result;
        //     if (UserInPermissionDTOResponse.IsSuccessStatusCode)
        //     {
        //         mpvm.User = UserInPermissionDTOResponse.Content.ReadAsAsync<UserInPermissionDTO>().Result;
        //     }
        //     HttpResponseMessage ResourceDTOResponse = client.GetAsync($"UserPermission/GetAllResources").Result;
        //     if (ResourceDTOResponse.IsSuccessStatusCode)
        //     {
        //         mpvm.Resources = ResourceDTOResponse.Content.ReadAsAsync<List<ResourceDTO>>().Result;
        //     }
        // }
        // return View(mpvm);
        return view('User.ManagePermission');
    }
    public function EditUserPermission(array $ResourceIds,string $UserId,string $UserInfo)
    {
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     HttpResponseMessage response = null;
        //     if (ResourceIds != null)
        //     {
        //         response = client.GetAsync($"UserPermission/UpdateUserUserPermissions?NidUser={UserId}&Resources={string.Join(",", ResourceIds)}").Result;
        //     }
        //     else
        //     {
        //         response = response = client.GetAsync($"UserPermission/UpdateUserUserPermissions?NidUser={UserId}&Resources={""}").Result;
        //     }
        //     if(response.IsSuccessStatusCode)
        //     {
        //         TempData["EditUserPermissionSuccessMessage"] = $"دسترسی های کاربری {UserInfo} با موفقیت اعمال گردید";
        //         return Json(new JsonResults() { HasValue = true });
        //     }
        //     else
        //     {
        //         return Json(new JsonResults() { HasValue = false });
        //     }
        // }
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
    public function SubmitLogin(string $Username,string $Password)
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
