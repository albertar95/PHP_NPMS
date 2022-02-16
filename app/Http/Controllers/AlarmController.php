<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\NPMSController;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AlarmController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    private function CheckAuthority(bool $checkSub,int $sub,string $cookie,int $entity = 0)
    {
        try {
            $row = explode('#',$cookie);
            $AccessedEntities = new Collection();
            foreach ($row as $r)
            {
                $AccessedEntities->push(explode(',',$r)[0]);
            }
            if($checkSub)
            {
                $AccessedSub = new Collection();
                foreach ($row as $r)
                {
                    $AccessedSub->push(["entity" => explode(',',$r)[0],"rowValue" => substr($r,2,strlen($r)-2)]);
                }
                if (in_array($entity, $AccessedEntities->toArray()))
                {
                    if (explode(',', $AccessedSub->where('entity', '=', $entity)->pluck('rowValue')[0])[$sub] == 1)
                    return true;
                    else
                    return false;
                }else
                return false;
            }else
            {
                if (in_array($entity, $AccessedEntities->toArray()))
                return true;
                else
                return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function GetAlarms(Request $request)
    {
        try {
            $api = new NPMSController();
            $result = new JsonResults();
            $alarms = new Collection();
            if ($this->CheckAuthority(false,0,$request->cookie('NPMS_Permissions')))
            {
                $alarms = $api->GetFirstPageAlarms();
            }else
            {
                $alarms = $api->GetUsersFirstPageAlarms(auth()->user()->NidUser);
            }
            $result->Html = view('Alarm._AlarmSection',compact('alarms'))->render();
            $result->HasValue = true;
            $result->Message = $alarms->count();
            return response()->json($result);
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function Alarms(Request $request, int $type = 0)
    {
        try {
            $api = new NPMSController();
            $Alarms = new Collection();
            if ($this->CheckAuthority(false,0,$request->cookie('NPMS_Permissions')))
            {
                $Alarms = $api->GetAllAlarms(0);
            }else
            {
                $Alarms = $api->GetUsersAlarms(auth()->user()->NidUser);
            }
            $Typo = $type;
            $api->AddLog(auth()->user(),$request->ip(),1,0,1,1,"اعلان ها");
            return view('Alarm.Alarms',compact('Alarms','Typo'));
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
}
