<?php
namespace App\Domains\Interfaces;

use App\Models\Logs;

interface ILogRepository
{
    public function AddLog(Logs $log);
}
