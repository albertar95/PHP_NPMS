<?php

namespace App\DTOs;

use Illuminate\Database\Eloquent\Model;

class LogDTO extends Model
{
    public string $NidLog;
    public string $UserId;
    public string $Username;
    public string $LogDate;
    public string $PersianLogDate;
    public string $IP;
    public string $LogTime;
    public string $ActionId;
    public string $ActionName;
    public string $Description;
    public string $LogStatus;
    public string $ImportanceLevel;
    public string $ConfidentialLevel;
}
