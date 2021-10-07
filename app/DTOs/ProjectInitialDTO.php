<?php

namespace App\DTOs;
use Brick\Math\BigInteger;
use DateTime;
use Illuminate\Database\Eloquent\Model;

class projectInitialDTO extends Model
{
    public string $NidProject;
    public BigInteger $ProjectNumber;
    public string $Subject;
    public int $ProjectStatus;//tiny int
    public string $ScholarId;
    public string $ScholarName;
    public string $UnitId;
    public string $UnitName;
    public string $GroupId;
    public string $GroupName;
    public string $Supervisor;
    public string $SupervisorMobile;
    public string $Advisor;
    public string $AdvisorMobile;
    public DateTime $CreateDate;
    public string $PersianCreateDate;
    public string $UserId;
    public string $ATFLetterDate;
}
