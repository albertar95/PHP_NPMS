<?php
namespace App\Domains\Interfaces;

use App\Models\Logs;

interface ILogRepository
{
    public function AddLog(Logs $log);
    public function GetAllLogActionType(int $pagesize = 10);
    public function UserLogReport(string $FromDate,string $ToDate,int $LogActionId,string $UserName = "");
    public function CurrentUserLogReport(string $NidUser);
    public function CurrentUserLoginReport(string $NidUser);
}
