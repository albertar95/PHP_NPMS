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
