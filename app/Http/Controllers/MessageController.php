<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\NPMSController;
use App\Http\Requests\MessageRequest;
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
    }
    public function SendMessage(Request $request)
    {
        $api = new NPMSController();
        $Recievers = $api->GetAllUserPermissionUsers();
        $api->AddLog(auth()->user(),$request->ip(),1,0,1,1,"ارسال پیام");
        return view('Message.SendMessage',compact('Recievers'));
    }
    public function GetRecieveMessageNeeded(string $NidUser)
    {
        $api = new NPMSController();
        return $api->RecieveMessageNeeded($NidUser);
    }
    public function Messages(Request $request,string $NidUser)
    {
        $api = new NPMSController();
        $Inbox = $api->GetAllUsersMessages($NidUser,true,200);
        $SendMessage = $api->GetAllUsersSendMessages($NidUser,200);
        $Recievers = $api->GetAllUserPermissionUsers();
        $api->AddLog(auth()->user(),$request->ip(),1,0,1,1,"پیام ها");
        return view('Message.Messages',compact('Inbox','SendMessage','Recievers'));
    }
    public function GetSendMessages(string $NidUser)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $txtLoadCount =  1;
        $messages = $api->GetAllUsersSendMessages($NidUser,200);
        $result->HasValue = true;
        $result->Html = view('Message._MessageTable',compact('messages','txtLoadCount'))->render();
        return response()->json($result);
    }
    public function SingleMessage(Request $request,string $NidMessage,int $ReadBy)
    {
        $api = new NPMSController();
        $Inbox = $api->GetMessageHirarchyById($NidMessage);
        $SingleMessage = $api->GetMessageDTOById($NidMessage);
        $Recievers = $api->GetAllUserPermissionUsers();
        $readby = $ReadBy;
        $api->AddLog(auth()->user(),$request->ip(),1,0,1,1,"پیام");
        return view('Message.SingleMessage',compact('Inbox','SingleMessage','Recievers','readby'));
    }
    public function SubmitSendMessage(MessageRequest $Message)
    {
        $Message->validated();
        $api = new NPMSController();
        $result = new JsonResults();
        $res = $api->SendMessage($Message);
        if($res)
        {
            $api->AddLog(auth()->user(),$Message->ip(),27,0,3,1,"ارسال پیام موفق");
            $result->HasValue = true;
            $result->Message = "پیام با موفقیت ارسال گردید";
        }else
        {
            $api->AddLog(auth()->user(),$Message->ip(),28,0,3,1,"ارسال پیام ناموفق");
            $result->HasValue = false;
            $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        }
        return response()->json($result);
    }
    public function SubmitReplyMessage(MessageRequest $Message)
    {
        $Message->validated();
        $api = new NPMSController();
        $result = new JsonResults();
        $res = $api->SendMessage($Message);
        if($res)
        {
            $api->AddLog(auth()->user(),$Message->ip(),27,0,3,1,"ارسال پیام موفق");
            $result->HasValue = true;
            $result->Message = "پیام با موفقیت ارسال گردید";
        }else
        {
            $api->AddLog(auth()->user(),$Message->ip(),28,0,3,1,"ارسال پیام ناموفق");
            $result->HasValue = false;
            $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
        }
        return response()->json($result);
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
    }
}
