<?php

namespace App\Domains\Repositories;

use App\Domains\Interfaces\ILogRepository;
use App\Models\Logs;
use App\Models\User;
use Illuminate\Support\Str;

class LogRepository implements ILogRepository{

    public function AddLog(Logs $log)
    {
        return $log->save();
    }
}
