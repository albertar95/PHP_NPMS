<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $primaryKey = 'NidProject';
    protected $fillable = ['Subject','ScholarId','UnitId','GroupId','Supervisor','SupervisorMobile','Advisor','AdvisorMobile','Refree1','Refree2','Editor','TenPercentLetterDate','PreImploymentLetterDate','ImploymentDate','SecurityLetterDate','ThesisDefenceDate','ThesisDefenceLetterDate','ReducePeriod','Commision','HasBookPublish','TitleApproved','ThirtyPercentLetterDate','SixtyPercentLetterDate','ATFLetterDate','FinalApprove'];
    public $incrementing = false;
    public    $timestamps = false;
    // protected $visible = [];
    // protected $hidden = [];
    public function scholar()
    {
        return $this->belongsTo(Scholars::class,'ScholarId','NidScholar');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'UserId','NidUser');
    }
    public function unit()
    {
        return $this->belongsTo(Units::class,'UnitId','NidUnit');
    }
    public function unitGroup()
    {
        return $this->belongsTo(UnitGroups::class,'GroupId','NidGroup');
    }
}
