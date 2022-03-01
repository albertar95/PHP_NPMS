<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\NPMSController;
use App\Http\Requests\MessageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('XSS');
    }
    private function CheckAuthority(bool $checkSub, int $sub, string $cookie, int $entity = 5)
    {
        try {
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
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function GetMessages(string $NidUser,Request $request)
    {
        try {
            if ($this->CheckAuthority(false, 4, $request->cookie('NPMS_Permissions')))
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
            }else
            {
                return view('errors.401');
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SendMessage(Request $request)
    {
        try {
            if ($this->CheckAuthority(true, 0, $request->cookie('NPMS_Permissions')))
            {
                $api = new NPMSController();
                $Recievers = $api->GetAllUserPermissionUsers();
                $api->AddLog(auth()->user(),$request->ip(),1,0,1,1,"ارسال پیام");
                return view('Message.SendMessage',compact('Recievers'));
            }else
            {
                return view('errors.401');
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function GetRecieveMessageNeeded(string $NidUser)
    {
        try {
            $api = new NPMSController();
            return $api->RecieveMessageNeeded($NidUser);
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function Messages(Request $request,string $NidUser)
    {
        try {
            if ($this->CheckAuthority(true, 4, $request->cookie('NPMS_Permissions')))
            {
                $api = new NPMSController();
                $Inbox = $api->GetAllUsersMessages($NidUser,true,200);
                $SendMessage = $api->GetAllUsersSendMessages($NidUser,200);
                $Recievers = $api->GetAllUserPermissionUsers();
                $api->AddLog(auth()->user(),$request->ip(),1,0,1,1,"پیام ها");
                return view('Message.Messages',compact('Inbox','SendMessage','Recievers'));
            }else
            {
                return view('errors.401');
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function GetSendMessages(string $NidUser)
    {
        try {
            $api = new NPMSController();
            $result = new JsonResults();
            $txtLoadCount =  1;
            $messages = $api->GetAllUsersSendMessages($NidUser,200);
            $result->HasValue = true;
            $result->Html = view('Message._MessageTable',compact('messages','txtLoadCount'))->render();
            return response()->json($result);
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SingleMessage(Request $request,string $NidMessage,int $ReadBy)
    {
        try {
            if ($this->CheckAuthority(false, 4, $request->cookie('NPMS_Permissions')))
            {
                $api = new NPMSController();
                $Inbox = $api->GetMessageHirarchyById($NidMessage);
                $SingleMessage = $api->GetMessageDTOById($NidMessage);
                $Recievers = $api->GetAllUserPermissionUsers();
                $readby = $ReadBy;
                $api->AddLog(auth()->user(),$request->ip(),1,0,1,1,"پیام");
                return view('Message.SingleMessage',compact('Inbox','SingleMessage','Recievers','readby'));
            }else{
                return view('errors.401');
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SubmitSendMessage(MessageRequest $Message)
    {
        try {
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
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SubmitReplyMessage(MessageRequest $Message)
    {
        try {
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
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function ReadMessage(string $NidMessage)
    {
        try {
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
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
}
