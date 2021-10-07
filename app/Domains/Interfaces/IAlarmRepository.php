<?php
namespace App\Domains\Interfaces;

use Illuminate\Support\Collection;
use Ramsey\Uuid\Guid\Guid;

interface IAlarmRepository
{
    public function HandleAlarmsByProjectId(string $NidProject):bool;
    public function HandleAlarmsJob(int $RunInterval = 12):bool;
    public function GetFirstLevelAlarms() :Collection;
    public function GetAllAlarms(int $pagesize = 100):Collection;
}
