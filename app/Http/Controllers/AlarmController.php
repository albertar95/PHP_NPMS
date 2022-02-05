<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\NPMSController;
use Illuminate\Http\Request;

class AlarmController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function GetAlarms()
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $alarms = $api->GetFirstPageAlarms();
        $result->Html = view('Alarm._AlarmSection',compact('alarms'))->render();
        $result->HasValue = true;
        $result->Message = $alarms->count();
        return response()->json($result);
    }
    public function Alarms(int $type = 0)
    {
        $api = new NPMSController();
        $Alarms = $api->GetAllAlarms(0);
        $Typo = $type;
        return view('Alarm.Alarms',compact('Alarms','Typo'));
    }
}
