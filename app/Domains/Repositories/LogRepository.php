<?php

namespace App\Domains\Repositories;

use App\Domains\Interfaces\ILogRepository;
use App\Models\LogActionTypes;
use App\Models\Logs;
use App\Models\User;
use Illuminate\Support\Str;

class LogRepository implements ILogRepository{

    public function AddLog(Logs $log)
    {
        return $log->save();
    }
    public function GetAllLogActionType(int $pagesize = 10)
    {
        return LogActionTypes::all()->take($pagesize);
    }
    public function UserLogReport(string $FromDate,string $ToDate,int $LogActionId,string $UserName = "")
    {
        if($LogActionId == 0)
        {
            if($UserName == "")
            {
                return Logs::all()->whereBetween('LogDate',[$FromDate,$ToDate]);
            }else
            {
                return Logs::all()->whereBetween('LogDate',[$FromDate,$ToDate])->where('Username','=',$UserName);
            }
        }else
        {
            if($UserName == "")
            {
                return Logs::all()->whereBetween('LogDate',[$FromDate,$ToDate])->where('ActionId','=',$LogActionId);
            }else
            {
                return Logs::all()->whereBetween('LogDate',[$FromDate,$ToDate])->where('ActionId','=',$LogActionId)->where('Username','=',$UserName);
            }
        }
    }
}
