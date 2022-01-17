<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\NPMSController;
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
        $api = new NPMSController();
        $messages = $api->GetAllUsersMessages($NidUser);
        foreach ($messages as $key => $msg) {
            if(!$msg->IsRecieved)
            $api->RecieveMessage($msg->NidMessage);
        }
        $result = new JsonResults();
        $result->HasValue = true;
        $result->Html = view('Message._MessageSection',compact('messages'))->render();
        $result->Message = $messages->count();
        return response()->json($result);
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
    public function GetRecieveMessageNeeded(string $NidUser)
    {
        $api = new NPMSController();
        return $api->RecieveMessageNeeded($NidUser);
    }
    public function Messages(string $NidUser)
    {
        $api = new NPMSController();
        $Inbox = $api->GetAllUsersMessages($NidUser,true);
        $SendMessage = $api->GetAllUsersSendMessages($NidUser);
        $Recievers = $api->GetAllUserPermissionUsers();
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
        return view('Message.Messages',compact('Inbox','SendMessage','Recievers'));
    }
    public function GetSendMessages(string $NidUser)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $res = $api->GetAllUsersSendMessages($NidUser);
        $result->HasValue = true;
        $result->Html = view('Message._MessageTable',compact('res'))->render();
        return response()->json($result);
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
    public function SingleMessage(string $NidMessage,int $ReadBy)
    {
        $api = new NPMSController();
        $Inbox = $api->GetMessageHirarchyById($NidMessage);
        $SingleMessage = $api->GetMessageDTOById($NidMessage);
        $Recievers = $api->GetAllUserPermissionUsers();
        $readby = $ReadBy;
        return view('Message.SingleMessage',compact('Inbox','SingleMessage','Recievers','readby'));
    }
    public function SubmitSendMessage(Request $Message)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $res = $api->SendMessage($Message);
        if($res)
        {
            $result->HasValue = true;
            $result->Message = "پیام با موفقیت ارسال گردید";
        }else
        {
            $result->HasValue = false;
            $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        }
        return response()->json($result);
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
        $api = new NPMSController();
        $result = new JsonResults();
        $res = $api->SendMessage($Message);
        if($res)
        {
            $result->HasValue = true;
            $result->Message = "پیام با موفقیت ارسال گردید";
        }else
        {
            $result->HasValue = false;
            $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        }
        return response()->json($result);
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
        $api = new NPMSController();
        $result = new JsonResults();
        $res = $api->ReadMessage($NidMessage);
        if($res)
        {
            $result->HasValue = true;
        }else
        {
            $result->HasValue = false;
        }
        return response()->json($result);
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
