<?php

namespace App\Domains\Repositories;

use App\Domains\Eloquent\BaseRepository;
use App\Domains\Interfaces\IAlarmRepository;
use App\Models\Alarms;
use App\Models\Projects;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Guid\Guid;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AlarmRepository extends BaseRepository implements IAlarmRepository
{
    public function __construct(Alarms $model)
    {
        parent::__construct($model);
    }

    private function ProjectProcess(Projects $CurrentProj):bool
    {
        $res = new Collection();
        $result = true;
        if (!isEmptyOrNullString($CurrentProj->ATFLetterDate))
        {
            if (isEmptyOrNullString($CurrentProj->PreImploymentLetterDate))
            {
                // $diff = (DateTime->Now - Helpers.Casts.ConvertToGeorgianDate(CurrentProj.ATFLetterDate)).Days;
                // res.Add(AlarmProcess(CurrentProj.NidProject, 1, diff, CurrentProj.Subject));
            }
            else
            {
                $res->push($this->AlarmCancelation($CurrentProj->NidProject, 1));
            }
        }
        if (isEmptyOrNullString($CurrentProj->SecurityLetterDate))
        {
            // int diff = (DateTime.Now - CurrentProj.CreateDate).Days;
            // res.Add(AlarmProcess(CurrentProj.NidProject, 2, diff, CurrentProj.Subject));
        }
        else
        {
            $res->push($this->AlarmCancelation($CurrentProj->NidProject, 2));
        }
        if (!isEmptyOrNullString($CurrentProj->ImploymentDate))
        {
            if (isEmptyOrNullString($CurrentProj->ThirtyPercentLetterDate))
            {
                // int diff = (DateTime.Now - Helpers.Casts.ConvertToGeorgianDate(CurrentProj.ImploymentDate)).Days;
                // res.Add(AlarmProcess(CurrentProj.NidProject, 3, diff, CurrentProj.Subject));
            }
            else
            {
                $res->push($this->AlarmCancelation($CurrentProj->NidProject, 3));
            }
            if (isEmptyOrNullString($CurrentProj->SixtyPercentLetterDate))
            {
                // int diff = (DateTime.Now - Helpers.Casts.ConvertToGeorgianDate(CurrentProj.ImploymentDate)).Days;
                // res.Add(AlarmProcess(CurrentProj.NidProject, 4, diff, CurrentProj.Subject));
            }
            else
            {
                $res->push($this->AlarmCancelation($CurrentProj->NidProject, 4));
            }
            if (!isEmptyOrNullString($CurrentProj->SixtyPercentLetterDate))
            {
                if (isEmptyOrNullString($CurrentProj->ThesisDefenceDate))
                {
                    // int diff = (DateTime.Now - Helpers.Casts.ConvertToGeorgianDate(CurrentProj.SixtyPercentLetterDate)).Days;
                    // res.Add(AlarmProcess(CurrentProj.NidProject, 5, diff, CurrentProj.Subject));
                }
                else
                {
                    $res->push($this->AlarmCancelation($CurrentProj->NidProject, 5));
                }
                if (isEmptyOrNullString($CurrentProj->Referee1) || isEmptyOrNullString($CurrentProj->Referee2))
                {
                    $res->push($this->AlarmProcess($CurrentProj->NidProject, 6, 0, $CurrentProj->Subject));
                }
                else
                {
                    $res->push($this->AlarmCancelation($CurrentProj->NidProject, 6));
                }
                if (!isEmptyOrNullString($CurrentProj->ThesisDefenceDate))
                {
                    if (isEmptyOrNullString($CurrentProj->Editor))
                        $res->push($this->AlarmProcess($CurrentProj->NidProject, 7, 0, $CurrentProj->Subject));
                    else
                    {
                        $res->push($this->AlarmCancelation($CurrentProj->NidProject, 7));
                    }
                }
            }
            if (isEmptyOrNullString($CurrentProj->Supervisor) || isEmptyOrNullString($CurrentProj->Advisor))
            {
                $res->push($this->AlarmProcess($CurrentProj->NidProject, 8, 0, $CurrentProj->Subject));
            }
            else
            {
                $res->push($this->AlarmCancelation($CurrentProj->NidProject, 8));
            }
        }
        foreach ($res as $rec)
        {
            if (!$rec)
                $result = false;
        }
        return $result;
    }

    private function AlarmProcess(string $NidMaster,int $ProccessId,int $diff,string $MasterName = ""):bool
    {
            $result = false;
            switch ($ProccessId)
            {
                case 1:
                    $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','PreImployment')->firstOrFail();
                    if (!is_null($alarm))
                    {
                        if ($diff > 14)
                        {
                            if (($diff / 14) < 2)
                                $alarm->AlarmStatus = 1;
                            else
                                $alarm->AlarmStatus = 2;
                        }
                        else
                            $alarm->AlarmStatus = 0;
                        $alarm->Description = sprintf("پروژه با موضوع %s از تاریخ ارسال مدارک به عتف %d روز می گذرد اما هنوز نامه روگرفت آن در سامانه ثبت نگردیده است",$MasterName,$diff);
                        try{
                            $alarm->save();
                            $result = true;
                        }catch(\Exception)
                        {
                            $result = false;
                        }
                    }
                    else
                    {
                        $alarm = new Alarms();
                        $alarm->NidAlarm = Str::uuid();
                        $alarm->AlarmSubject = "PreImployment";
                        $alarm->NidMaster = $NidMaster;
                        $alarm->Description = sprintf("پروژه با موضوع %s از تاریخ ارسال مدارک به عتف %d روز می گذرد اما هنوز نامه روگرفت آن در سامانه ثبت نگردیده است",$MasterName,$diff);
                        if ($diff > 14)
                        {
                            if (($diff / 14) < 2)
                                $alarm->AlarmStatus = 1;
                            else
                                $alarm->AlarmStatus = 2;
                        }
                        else
                            $alarm->AlarmStatus = 0;
                        try
                        {
                            $alarm->save();
                            $result = true;
                        }
                        catch (\Exception)
                        {
                            $result = false;
                        }
                    }
                    break;
                case 2:
                    $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','SecurityLetter')->firstOrFail();
                    if (!is_null($alarm))
                    {
                        if ($diff > 30)
                        {
                            if (($diff / 30) < 2)
                                $alarm->AlarmStatus = 1;
                            else
                                $alarm->AlarmStatus = 2;
                        }
                        else
                            $alarm->AlarmStatus = 0;
                        $alarm->Description = sprintf("پروژه با موضوع %s از تاریخ ایجاد پروژه %d روز می گذرد اما هنوز نامه حفاظت آن در سامانه ثبت نگردیده است",$MasterName,$diff);
                        try
                        {
                            $alarm->save();
                            $result = true;
                        }
                        catch (\Exception)
                        {
                            $result = false;
                        }
                    }
                    else
                    {
                        $alarm = new Alarms();
                        $alarm->NidAlarm = Str::uuid();
                        $alarm->AlarmSubject = "SecurityLetter";
                        $alarm->NidMaster = $NidMaster;
                        $alarm->Description = sprintf("پروژه با موضوع %s از تاریخ ایجاد پروژه %d روز می گذرد اما هنوز نامه حفاظت آن در سامانه ثبت نگردیده است",$MasterName,$diff);
                        if ($diff > 30)
                        {
                            if (($diff / 30) < 2)
                                $alarm->AlarmStatus = 1;
                            else
                                $alarm->AlarmStatus = 2;
                        }
                        else
                            $alarm->AlarmStatus = 0;
                        try
                        {
                            $alarm->save();
                            $result = true;
                        }
                        catch (\Exception)
                        {
                            $result = false;
                        }
                    }
                    break;
                case 3:
                    $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','ThirtyLetter')->firstOrFail();
                    if (!is_null($alarm))
                    {
                        if ($diff > 90)
                        {
                            if (($diff / 90) < 2)
                                $alarm->AlarmStatus = 1;
                            else
                                $alarm->AlarmStatus = 2;
                        }
                        else
                            $alarm->AlarmStatus = 0;
                        $alarm->Description = sprintf("پروژه با موضوع %s از تاریخ بکارگیری %d روز می گذرد اما هنوز فرم 30 درصد در سامانه ثبت نگردیده است",$MasterName,$diff);
                        try
                        {
                            $alarm->save();
                            $result = true;
                        }
                        catch (\Exception)
                        {
                            $result = false;
                        }
                    }
                    else
                    {
                        $alarm = new Alarms();
                        $alarm->NidAlarm = Str::uuid();
                        $alarm->AlarmSubject = "ThirtyLetter";
                        $alarm->NidMaster = $NidMaster;
                        $alarm->Description = sprintf("پروژه با موضوع %s از تاریخ بکارگیری %d روز می گذرد اما هنوز فرم 30 درصد در سامانه ثبت نگردیده است",$MasterName,$diff);
                        if ($diff > 90)
                        {
                            if (($diff / 90) < 2)
                                $alarm->AlarmStatus = 1;
                            else
                                $alarm->AlarmStatus = 2;
                        }
                        else
                            $alarm->AlarmStatus = 0;
                        try
                        {
                            $alarm->save();
                            $result = true;
                        }
                        catch (\Exception)
                        {
                            $result = false;
                        }
                    }
                    break;
                case 4:
                    $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','SixtyLetter')->firstOrFail();
                    if (!is_null($alarm))
                    {
                        if ($diff > 180)
                        {
                            if (($diff / 180) < 2)
                                $alarm->AlarmStatus = 1;
                            else
                                $alarm->AlarmStatus = 2;
                        }
                        else
                            $alarm->AlarmStatus = 0;
                        $alarm->Description = sprintf("پروژه با موضوع %s از تاریخ بکارگیری %d روز می گذرد اما هنوز فرم 60 درصد در سامانه ثبت نگردیده است",$MasterName,$diff);
                        try
                        {
                            $alarm->save();
                            $result = true;
                        }
                        catch (\Exception)
                        {
                            $result = false;
                        }
                    }
                    else
                    {
                        $alarm = new Alarms();
                        $alarm->NidAlarm = Str::uuid();
                        $alarm->AlarmSubject = "SixtyLetter";
                        $alarm->NidMaster = $NidMaster;
                        $alarm->Description = sprintf("پروژه با موضوع %s از تاریخ بکارگیری %d روز می گذرد اما هنوز فرم 60 درصد در سامانه ثبت نگردیده است",$MasterName,$diff);
                        if ($diff > 180)
                        {
                            if (($diff / 180) < 2)
                                $alarm->AlarmStatus = 1;
                            else
                                $alarm->AlarmStatus = 2;
                        }
                        else
                            $alarm->AlarmStatus = 0;
                        try
                        {
                            $alarm->save();
                            $result = true;
                        }
                        catch (\Exception)
                        {
                            $result = false;
                        }
                    }
                    break;
                case 5:
                    $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','ThesisLetter')->firstOrFail();
                    if (!is_null($alarm))
                    {
                        if ($diff > 90)
                        {
                            if (($diff / 90) < 2)
                                $alarm->AlarmStatus = 1;
                            else
                                $alarm->AlarmStatus = 2;
                        }
                        else
                            $alarm->AlarmStatus = 0;
                        $alarm->Description = sprintf("پروژه با موضوع %s از تاریخ ارائه فرم 60 درصد %d روز می گذرد اما هنوز تاریخ دفاعیه در سامانه ثبت نگردیده است",$MasterName,$diff);
                        try
                        {
                            $alarm->save();
                            $result = true;
                        }
                        catch (\Exception)
                        {
                            $result = false;
                        }
                    }
                    else
                    {
                        $alarm = new Alarms();
                        $alarm->NidAlarm = Str::uuid();
                        $alarm->AlarmSubject = "ThesisLetter";
                        $alarm->NidMaster = $NidMaster;
                        $alarm->Description = sprintf("پروژه با موضوع %s از تاریخ ارائه فرم 60 درصد %d روز می گذرد اما هنوز تاریخ دفاعیه در سامانه ثبت نگردیده است",$MasterName,$diff);
                        if ($diff > 90)
                        {
                            if (($diff / 90) < 2)
                                $alarm->AlarmStatus = 1;
                            else
                                $alarm->AlarmStatus = 2;
                        }
                        else
                            $alarm->AlarmStatus = 0;
                        try
                        {
                            $alarm->save();
                            $result = true;
                        }
                        catch (\Exception)
                        {
                            $result = false;
                        }
                    }
                    break;
                case 6:
                    $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','RefInfo')->firstOrFail();
                    if (!is_null($alarm))
                    {
                        $alarm->AlarmStatus = 1;
                        $alarm->Description = sprintf("پروژه با موضوع %s فاقد داور 1 یا 2 می باشد",$MasterName);
                        try
                        {
                            $alarm->save();
                            $result = true;
                        }
                        catch (\Exception)
                        {
                            $result = false;
                        }
                    }
                    else
                    {
                        $alarm = new Alarms();
                        $alarm->NidAlarm = Str::uuid();
                        $alarm->AlarmSubject = "RefInfo";
                        $alarm->NidMaster = $NidMaster;
                        $alarm->AlarmStatus = 1;
                        $alarm->Description = sprintf("پروژه با موضوع %s فاقد داور 1 یا 2 می باشد",$MasterName);
                        try
                        {
                            $alarm->save();
                            $result = true;
                        }
                        catch (\Exception)
                        {
                            $result = false;
                        }
                    }
                    break;
                case 7:
                    $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','EditorInfo')->firstOrFail();
                    if (!is_null($alarm))
                    {
                        $alarm->AlarmStatus = 1;
                        $alarm->Description = sprintf("پروژه با موضوع %s فاقد ویراستار می باشد",$MasterName);
                        try
                        {
                            $alarm->save();
                            $result = true;
                        }
                        catch (\Exception)
                        {
                            $result = false;
                        }
                    }
                    else
                    {
                        $alarm = new Alarms();
                        $alarm->NidAlarm = Str::uuid();
                        $alarm->AlarmSubject = "EditorInfo";
                        $alarm->NidMaster = $NidMaster;
                        $alarm->AlarmStatus = 1;
                        $alarm->Description = sprintf("پروژه با موضوع %s فاقد ویراستار می باشد",$MasterName);
                        try
                        {
                            $alarm->save();
                            $result = true;
                        }
                        catch (\Exception)
                        {
                            $result = false;
                        }
                    }
                    break;
                case 8:
                    $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','AdvSupInfo')->firstOrFail();
                    if (!is_null($alarm))
                    {
                        $alarm->AlarmStatus = 1;
                        $alarm->Description = sprintf("پروژه با موضوع %s فاقد استاد راهنما یا استاد مشاور می باشد",$MasterName);
                        try
                        {
                            $alarm->save();
                            $result = true;
                        }
                        catch (\Exception)
                        {
                            $result = false;
                        }
                    }
                    else
                    {
                        $alarm = new Alarms();
                        $alarm->NidAlarm = Str::uuid();
                        $alarm->AlarmSubject = "AdvSupInfo";
                        $alarm->NidMaster = $NidMaster;
                        $alarm->AlarmStatus = 1;
                        $alarm->Description = sprintf("پروژه با موضوع %s فاقد استاد راهنما یا استاد مشاور می باشد",$MasterName);
                        try
                        {
                            $alarm->save();
                            $result = true;
                        }
                        catch (\Exception)
                        {
                            $result = false;
                        }
                    }
                    break;
            }
            return $result;
    }

    public function HandleAlarmsByProjectId(string $NidProject):bool
    {
        $tmpProject = $this->model->all()->where('NidProject','=',$NidProject)->firstOrFail();
        if (!is_null($tmpProject))
            return $this->ProjectProcess($tmpProject);
        else
            return false;
    }
    private function AlarmCancelation(string $NidMaster,int $ProcessId):bool
    {
            $result = false;
            switch ($ProcessId)
            {
                case 1:
                    $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','PreImployment')->firstOrFail();
                    if (!is_null($alarm))
                    {
                        $alarm->AlarmStatus = 0;
                        $alarm->save();
                    }
                    $result = true;
                    break;
                case 2:
                    $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','SecurityLetter')->firstOrFail();
                    if (!is_null($alarm))
                    {
                        $alarm->AlarmStatus = 0;
                        $alarm->save();
                    }
                    $result = true;
                    break;
                case 3:
                    $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','ThirtyLetter')->firstOrFail();
                    if (!is_null($alarm))
                    {
                        $alarm->AlarmStatus = 0;
                        $alarm->save();
                    }
                    $result = true;
                    break;
                case 4:
                    $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','SixtyLetter')->firstOrFail();
                    if (!is_null($alarm))
                    {
                        $alarm->AlarmStatus = 0;
                        $alarm->save();
                    }
                    $result = true;
                    break;
                case 5:
                    $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','ThesisLetter')->firstOrFail();
                    if (!is_null($alarm))
                    {
                        $alarm->AlarmStatus = 0;
                        $alarm->save();
                    }
                    $result = true;
                    break;
                case 6:
                    $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','RefInfo')->firstOrFail();
                    if (!is_null($alarm))
                    {
                        $alarm->AlarmStatus = 0;
                        $alarm->save();
                    }
                    $result = true;
                    break;
                case 7:
                    $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','EditorInfo')->firstOrFail();
                    if (!is_null($alarm))
                    {
                        $alarm->AlarmStatus = 0;
                        $alarm->save();
                    }
                    $result = true;
                    break;
                case 8:
                    $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','AdvSupInfo')->firstOrFail();
                    if (!is_null($alarm))
                    {
                        $alarm->AlarmStatus = 0;
                        $alarm->save();
                    }
                    $result = true;
                    break;
            }
            return $result;
    }

    public function HandleAlarmsJob(int $RunInterval = 12):bool
    {
        $results = new Collection();
        $projects = DB::select('select * from projects');
        $res = true;
        foreach ($projects as $prj)
        {
            $results->push($this->ProjectProcess($prj));
        }
        foreach ($results as $rs)
        {
            if (!$rs)
                $res = false;
        }
        return $res;
    }
    public function GetFirstLevelAlarms() :Collection
    {
        $result = new Collection();
        $tmpGrouped = DB::select('select AlarmSubject as Subject,count as cnt from Alarms where AlarmStatus <> ?', [0]);// db.Alarms.Where(p => p.AlarmStatus != 0).GroupBy(q => q.AlarmSubject).Select(w => new { Subject = w.Key,cnt = w.Count()});
        foreach ($tmpGrouped as $tmp)
        {
            $tmpAlarm = new Alarms();
            $tmpAlarm->AlarmSubject = $tmp->Subject;
            $tmpAlarm->Description = $tmp->cnt;
            $result->push($tmpAlarm);
        }
        return $result;
    }
    public function GetAllAlarms(int $pagesize = 100):Collection
    {
        if($pagesize != 0)
        {
            return $this->model->all()->where('AlarmStatus','!=',0)->take($pagesize);
        }
        else
        {
            return $this->model->all()->where('AlarmStatus','!=',0);
        }
    }
}

class AlarmRepositoryFactory
{
    public static function GetAlarmRepositoryObj():IAlarmRepository
    {
        return new AlarmRepository(new Alarms());
    }

}
