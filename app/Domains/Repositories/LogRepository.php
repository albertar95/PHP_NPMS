<?php

namespace App\Domains\Repositories;

use App\Domains\Interfaces\ILogRepository;
use App\Models\LogActionTypes;
use App\Models\Logs;
use App\Models\User;
use Illuminate\Support\Collection;
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
            if(empty($UserName))
            {
                return Logs::all()->whereBetween('LogDate',[$FromDate,$ToDate]);
            }else
            {
                return Logs::all()->whereBetween('LogDate',[$FromDate,$ToDate])->where('Username','=',$UserName);
            }
        }else
        {
            if(empty($UserName))
            {
                return Logs::all()->whereBetween('LogDate',[$FromDate,$ToDate])->where('ActionId','=',$LogActionId);
            }else
            {
                return Logs::all()->whereBetween('LogDate',[$FromDate,$ToDate])->where('ActionId','=',$LogActionId)->where('Username','=',$UserName);
            }
        }
    }
    public function CurrentUserLogReport(string $NidUser)
    {
        return Logs::all()->where('UserId','=',$NidUser)->sortByDesc('LogTime')->sortByDesc('LogDate')->take(500);
    }
    public function CurrentUserLoginReport(string $NidUser)
    {
        $res = new Collection();
        foreach (Logs::all()->where('UserId','=',$NidUser)->where('ActionId','=',15)->sortByDesc('LogTime')->sortByDesc('LogDate')->take(5) as $key => $value) {
            $res->push($value);
        }
        foreach (Logs::all()->where('UserId','=',$NidUser)->where('ActionId','=',16)->sortByDesc('LogTime')->sortByDesc('LogDate')->take(5) as $key2 => $value2) {
            $res->push($value2);
        }
        return $res;
    }
}
