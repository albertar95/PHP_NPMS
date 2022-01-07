<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('XSS');
    }
    public function GetMessages(string $NidUser)
    {
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     HttpResponseMessage response = client.GetAsync($"Message/GetAllUsersMessages?NidUser={NidUser}").Result;
        //     if (response.IsSuccessStatusCode)
        //     {
        //         List<MessageDTO> res = response.Content.ReadAsAsync<List<MessageDTO>>().Result;
        //         foreach (var msg in res)
        //         {
        //             if(!msg.IsRecieved)
        //             client.GetAsync($"Message/RecieveMessage?NidMessage={msg.NidMessage}");
        //         }
        //         return Json(new JsonResults() { HasValue = true, Html = JsonResults.RenderViewToString(this.ControllerContext, "_MessageSection", res), Message = res.Count.ToString() });
        //     }
        //     else
        //     {
        //         return Json(new JsonResults() { HasValue = false, Html = "",Message = "0" });
        //     }
        // }
    }
    public function Messages(string $NidUser)
    {
        // MessageViewModel mvm = new MessageViewModel();
        // List<MessageDTO> res = new List<MessageDTO>();
        // List<MessageDTO> res2 = new List<MessageDTO>();
        // List<UserInPermissionDTO> res3 = new List<UserInPermissionDTO>();
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     HttpResponseMessage response = client.GetAsync($"Message/GetAllUsersMessages?NidUser={NidUser}&ShowAll= {true}").Result;
        //     if (response.IsSuccessStatusCode)
        //         res = response.Content.ReadAsAsync<List<MessageDTO>>().Result;
        //     HttpResponseMessage response2 = client.GetAsync($"Message/GetAllUsersSendMessages?NidUser={NidUser}").Result;
        //     if (response2.IsSuccessStatusCode)
        //         res2 = response2.Content.ReadAsAsync<List<MessageDTO>>().Result;
        //     HttpResponseMessage UserDTOResponse = client.GetAsync($"UserPermission/GetAllUserPermissionUsers").Result;
        //     if (UserDTOResponse.IsSuccessStatusCode)
        //     {
        //         res3 = UserDTOResponse.Content.ReadAsAsync<List<UserInPermissionDTO>>().Result;
        //     }
        // }
        // mvm.Inbox = res;
        // mvm.SendMessage = res2;
        // mvm.Recievers = res3;
        // return View(mvm);
        return view('Message.Messages');
    }
    public function GetSendMessages(string $NidUser)
    {
        // List<MessageDTO> res = new List<MessageDTO>();
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     HttpResponseMessage response = client.GetAsync($"Message/GetAllUsersSendMessages?NidUser={NidUser}").Result;
        //     if (response.IsSuccessStatusCode)
        //         res = response.Content.ReadAsAsync<List<MessageDTO>>().Result;
        // }
        // return Json(new JsonResults() {  HasValue = true, Html = JsonResults.RenderViewToString(this.ControllerContext, "_MessageTable", res) });
    }
    public function SingleMessage(string $NidMessage,int $ReadBy = 0)
    {
        // MessageViewModel mvm = new MessageViewModel();
        // List<MessageDTO> messages = new List<MessageDTO>();
        // MessageDTO message = new MessageDTO();
        // List<UserInPermissionDTO> res3 = new List<UserInPermissionDTO>();
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     HttpResponseMessage response = client.GetAsync($"Message/GetMessageHirarchyById?NidMessage={NidMessage}").Result;
        //     if (response.IsSuccessStatusCode)
        //         messages = response.Content.ReadAsAsync<List<MessageDTO>>().Result;
        //     HttpResponseMessage response2 = client.GetAsync($"Message/GetMessageDTOById?NidMessage={NidMessage}").Result;
        //     if (response2.IsSuccessStatusCode)
        //         message = response2.Content.ReadAsAsync<MessageDTO>().Result;
        //     HttpResponseMessage UserDTOResponse = client.GetAsync($"UserPermission/GetAllUserPermissionUsers").Result;
        //     if (UserDTOResponse.IsSuccessStatusCode)
        //     {
        //         res3 = UserDTOResponse.Content.ReadAsAsync<List<UserInPermissionDTO>>().Result;
        //     }
        // }
        // mvm.Inbox = messages;
        // mvm.SingleMessage = message;
        // mvm.Recievers = res3;
        // mvm.ReadBy = ReadBy;
        // return View(mvm);
        return view('Message.SingleMessage');
    }
    public function SubmitSendMessage(Request $Message)
    {
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     HttpResponseMessage SendMessageResponse = client.PostAsJsonAsync($"Message/SendMessage", Message).Result;
        //     if (SendMessageResponse.IsSuccessStatusCode)
        //     {
        //         return Json(new JsonResults() { HasValue = true, Message = "پیام با موفقیت ارسال گردید" });
        //     }
        //     else
        //     {
        //         return Json(new JsonResults() { HasValue = false, Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید" });
        //     }
        // }
    }
    public function SubmitReplyMessage(Request $Message)
    {
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     HttpResponseMessage SendMessageResponse = client.PostAsJsonAsync($"Message/SendMessage", Message).Result;
        //     if (SendMessageResponse.IsSuccessStatusCode)
        //     {
        //         return Json(new JsonResults() { HasValue = true, Message = "پیام با موفقیت ارسال گردید" });
        //     }
        //     else
        //     {
        //         return Json(new JsonResults() { HasValue = false, Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید" });
        //     }
        // }
    }
    public function ReadMessage(string $NidMessage)
    {
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     HttpResponseMessage response = client.GetAsync($"Message/ReadMessage?NidMessage={NidMessage}").Result;
        //     if (response.IsSuccessStatusCode)
        //         return Json(new JsonResults() { HasValue = true });
        //     else
        //         return Json(new JsonResults() { HasValue = false });
        // }
    }
}
