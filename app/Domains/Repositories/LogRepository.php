<?php

namespace App\Domains\Repositories;

use App\Domains\Interfaces\ILogRepository;
use App\DTOs\DataMapper;
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
        $result = new Collection();
        if($LogActionId == 0)
        {
            if(empty($UserName))
            {
                $result = Logs::all()->whereBetween('LogDate',[$FromDate,$ToDate]);
            }else
            {
                $result = Logs::all()->whereBetween('LogDate',[$FromDate,$ToDate])->where('Username','=',$UserName);
            }
        }else
        {
            if(empty($UserName))
            {
                $result = Logs::all()->whereBetween('LogDate',[$FromDate,$ToDate])->where('ActionId','=',$LogActionId);
            }else
            {
                $result = Logs::all()->whereBetween('LogDate',[$FromDate,$ToDate])->where('ActionId','=',$LogActionId)->where('Username','=',$UserName);
            }
        }
        $resultDto = new Collection();
        foreach ($result as $lg) {
            $resultDto->push(DataMapper::MapToLogDTO($lg));
        }
        return $resultDto;
    }
    public function CurrentUserLogReport(string $NidUser)
    {
        $result = Logs::all()->where('UserId','=',$NidUser)->sortByDesc('LogTime')->sortByDesc('LogDate')->take(500);
        $resultDto = new Collection();
        foreach ($result as $lg) {
            $resultDto->push(DataMapper::MapToLogDTO($lg));
        }
        return $resultDto;
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
