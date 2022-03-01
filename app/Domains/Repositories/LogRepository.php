<?php

namespace App\Domains\Repositories;

use App\Domains\Interfaces\ILogRepository;
use App\DTOs\DataMapper;
use App\Models\LogActionTypes;
use App\Models\Logs;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
        // $result = new Collection();
        if($LogActionId == 0)
        {
            if(empty($UserName))
            {
                // $result = Logs::all()->whereBetween('LogDate',[$FromDate,$ToDate]);
                return collect(DB::select("select LogDate,LogTime,Username,Description,IP,ImportanceLevel,t2.Title as ActionName from logs t1 join log_action_types t2 on t1.ActionId = t2.NidAction where LogDate BETWEEN '".$FromDate."' and '".$ToDate."'"));
            }else
            {
                // $result = Logs::all()->whereBetween('LogDate',[$FromDate,$ToDate])->where('Username','=',$UserName);
                return collect(DB::select("select LogDate,LogTime,Username,Description,IP,ImportanceLevel,t2.Title as ActionName from logs t1 join log_action_types t2 on t1.ActionId = t2.NidAction where LogDate BETWEEN '".$FromDate."' and '".$ToDate."' and Username = '".$UserName."'"));
            }
        }else
        {
            if(empty($UserName))
            {
                // $result = Logs::all()->whereBetween('LogDate',[$FromDate,$ToDate])->where('ActionId','=',$LogActionId);
                return collect(DB::select("select LogDate,LogTime,Username,Description,IP,ImportanceLevel,t2.Title as ActionName from logs t1 join log_action_types t2 on t1.ActionId = t2.NidAction where LogDate BETWEEN '".$FromDate."' and '".$ToDate."' and ActionId = ".$LogActionId));
            }else
            {
                // $result = Logs::all()->whereBetween('LogDate',[$FromDate,$ToDate])->where('ActionId','=',$LogActionId)->where('Username','=',$UserName);
                return collect(DB::select("select LogDate,LogTime,Username,Description,IP,ImportanceLevel,t2.Title as ActionName from logs t1 join log_action_types t2 on t1.ActionId = t2.NidAction where LogDate BETWEEN '".$FromDate."' and '".$ToDate."' and Username = '".$UserName."' and ActionId = ".$LogActionId));
            }
        }
        // $resultDto = new Collection();
        // foreach ($result as $lg) {
        //     $resultDto->push(DataMapper::MapToLogDTO($lg));
        // }
        // return $resultDto;
    }
    public function CurrentUserLogReport(string $NidUser,int $pagesize = 200)
    {
        return DataMapper::MapToLogDTO2(Logs::with('actionTypes')->where('UserId','=',$NidUser)->get()->sortByDesc('LogTime')->sortByDesc('LogDate')->take($pagesize));
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
