<?php

namespace App\DTOs;

use Brick\Math\BigInteger;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

class projectDetailDTO extends Model
{
    public string $NidProject;
    public BigInteger $ProjectNumber;
    public string $Subject;
    public int $ProjectStatus;//tiny int
    public string $ScholarId;
    public string $UnitId;
    public string $UnitTitle;
    public string $GroupId;
    public string $GroupTitle;
    public string $Supervisor;
    public string $SupervisorMobile;
    public string $Advisor;
    public string $AdvisorMobile;
    public string $Referee1;
    public string $Referee2;
    public string $Editor;
    public string $CreateDate;
    public string $PersianCreateDate;
    public string $TenPercentLetterDate;
    public string $PreImploymentLetterDate;
    public string $ImploymentDate;
    public string $SecurityLetterDate;
    public string $ThesisDefenceDate;
    public string $ThesisDefenceLetterDate;
    public int $ReducePeriod;//tiny int
    public string $Commision;
    public bool $HasBookPublish;
    public string $UserId;
    public bool $TitleApproved;
    public string $ThirtyPercentLetterDate;
    public string $SixtyPercentLetterDate;
    public string $ATFLetterDate;
    public bool $FinalApprove;
    public bool $IsConfident;
}
