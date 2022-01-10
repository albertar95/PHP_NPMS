<?php

namespace App\Domains\Repositories;

use App\Domains\Eloquent\BaseRepository;
use App\Domains\Interfaces\IAlarmRepository;
use App\Helpers\Casts;
use App\Models\Alarms;
use App\Models\Projects;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
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
    public function PersianDateToGeorgian(string $Datee)
    {
        return Verta::getGregorian(intval(Casts::PersianToEnglishDigits(substr($Datee,0,8))),intval(Casts::PersianToEnglishDigits(substr(substr($Datee,0,13),-4))),intval(Casts::PersianToEnglishDigits(substr($Datee,-4))));
    }
    private function ProjectProcess(Projects $CurrentProj):bool
    {
        $res = new Collection();
        $result = true;
        $nowDate = Carbon::now();
        if (!empty($CurrentProj->ATFLetterDate))
        {
            if (empty($CurrentProj->PreImploymentLetterDate))
            {
                $cdate = $this->PersianDateToGeorgian($CurrentProj->ATFLetterDate);
                $parsedDate = $cdate[0].'-'.$cdate[1].'-'.$cdate[2].' 01:00:00';
                $diff = $nowDate->diffInDays(Carbon::parse($parsedDate));
                $res->push($this->AlarmProcess($CurrentProj->NidProject, 1, $diff, $CurrentProj->Subject));
            }
            else
            {
                $res->push($this->AlarmCancelation($CurrentProj->NidProject, 1));
            }
        }
        if (empty($CurrentProj->SecurityLetterDate))
        {
            $cdate = $this->PersianDateToGeorgian($CurrentProj->CreateDate);
            $parsedDate = $cdate[0].'-'.$cdate[1].'-'.$cdate[2].' 01:00:00';
            $diff = $nowDate->diffInDays(Carbon::parse($parsedDate));
            $res->push($this->AlarmProcess($CurrentProj->NidProject, 2, $diff, $CurrentProj->Subject));
        }
        else
        {
            $res->push($this->AlarmCancelation($CurrentProj->NidProject, 2));
        }
        if (!empty($CurrentProj->ImploymentDate))
        {
            if (empty($CurrentProj->ThirtyPercentLetterDate))
            {
                $cdate = $this->PersianDateToGeorgian($CurrentProj->ImploymentDate);
                $parsedDate = $cdate[0].'-'.$cdate[1].'-'.$cdate[2].' 01:00:00';
                $diff = $nowDate->diffInDays(Carbon::parse($parsedDate));
                $res->push($this->AlarmProcess($CurrentProj->NidProject, 3, $diff, $CurrentProj->Subject));
            }
            else
            {
                $res->push($this->AlarmCancelation($CurrentProj->NidProject, 3));
            }
            if (empty($CurrentProj->SixtyPercentLetterDate))
            {
                $cdate = $this->PersianDateToGeorgian($CurrentProj->ImploymentDate);
                $parsedDate = $cdate[0].'-'.$cdate[1].'-'.$cdate[2].' 01:00:00';
                $diff = $nowDate->diffInDays(Carbon::parse($parsedDate));
                $res->push($this->AlarmProcess($CurrentProj->NidProject, 4, $diff, $CurrentProj->Subject));
            }
            else
            {
                $res->push($this->AlarmCancelation($CurrentProj->NidProject, 4));
            }
            if (!empty($CurrentProj->SixtyPercentLetterDate))
            {
                if (empty($CurrentProj->ThesisDefenceDate))
                {
                    $cdate = $this->PersianDateToGeorgian($CurrentProj->SixtyPercentLetterDate);
                    $parsedDate = $cdate[0].'-'.$cdate[1].'-'.$cdate[2].' 01:00:00';
                    $diff = $nowDate->diffInDays(Carbon::parse($parsedDate));
                    $res->push($this->AlarmProcess($CurrentProj->NidProject, 5, $diff, $CurrentProj->Subject));
                }
                else
                {
                    $res->push($this->AlarmCancelation($CurrentProj->NidProject, 5));
                }
                if (empty($CurrentProj->Referee1) || empty($CurrentProj->Referee2))
                {
                    $res->push($this->AlarmProcess($CurrentProj->NidProject, 6, 0, $CurrentProj->Subject));
                }
                else
                {
                    $res->push($this->AlarmCancelation($CurrentProj->NidProject, 6));
                }
                if (!empty($CurrentProj->ThesisDefenceDate))
                {
                    if (empty($CurrentProj->Editor))
                        $res->push($this->AlarmProcess($CurrentProj->NidProject, 7, 0, $CurrentProj->Subject));
                    else
                    {
                        $res->push($this->AlarmCancelation($CurrentProj->NidProject, 7));
                    }
                }
            }
            if (empty($CurrentProj->Supervisor) || empty($CurrentProj->Advisor))
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
                    if ($this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','PreImployment')->count() > 0)
                    {
                        $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','PreImployment')->firstOrFail();
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
                            Alarms::where('NidAlarm',$alarm->NidAlarm)->update(
                                [
                                    "AlarmStatus" => $alarm->AlarmStatus,
                                    "Description" => $alarm->Description
                                ]);
                            // $alarm->save();
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
                    if ($this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','SecurityLetter')->count() > 0)
                    {
                        $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','SecurityLetter')->firstOrFail();
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
                            Alarms::where('NidAlarm',$alarm->NidAlarm)->update(
                                [
                                    "AlarmStatus" => $alarm->AlarmStatus,
                                    "Description" => $alarm->Description
                                ]);
                            // $alarm->save();
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
                    if ($this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','ThirtyLetter')->count() > 0)
                    {
                        $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','ThirtyLetter')->firstOrFail();
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
                            Alarms::where('NidAlarm',$alarm->NidAlarm)->update(
                                [
                                    "AlarmStatus" => $alarm->AlarmStatus,
                                    "Description" => $alarm->Description
                                ]);
                            // $alarm->save();
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
                    if ($this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','SixtyLetter')->count() > 0)
                    {
                        $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','SixtyLetter')->firstOrFail();
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
                            Alarms::where('NidAlarm',$alarm->NidAlarm)->update(
                                [
                                    "AlarmStatus" => $alarm->AlarmStatus,
                                    "Description" => $alarm->Description
                                ]);
                            // $alarm->save();
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
                    if ($this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','ThesisLetter')->count() > 0)
                    {
                        $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','ThesisLetter')->firstOrFail();
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
                            Alarms::where('NidAlarm',$alarm->NidAlarm)->update(
                                [
                                    "AlarmStatus" => $alarm->AlarmStatus,
                                    "Description" => $alarm->Description
                                ]);
                            // $alarm->save();
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
                    if ($this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','RefInfo')->count() > 0)
                    {
                        $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','RefInfo')->firstOrFail();
                        $alarm->AlarmStatus = 1;
                        $alarm->Description = sprintf("پروژه با موضوع %s فاقد داور 1 یا 2 می باشد",$MasterName);
                        try
                        {
                            Alarms::where('NidAlarm',$alarm->NidAlarm)->update(
                                [
                                    "AlarmStatus" => $alarm->AlarmStatus,
                                    "Description" => $alarm->Description
                                ]);
                            // $alarm->save();
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
                    if ($this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','EditorInfo')->count() > 0)
                    {
                        $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','EditorInfo')->firstOrFail();
                        $alarm->AlarmStatus = 1;
                        $alarm->Description = sprintf("پروژه با موضوع %s فاقد ویراستار می باشد",$MasterName);
                        try
                        {
                            Alarms::where('NidAlarm',$alarm->NidAlarm)->update(
                                [
                                    "AlarmStatus" => $alarm->AlarmStatus,
                                    "Description" => $alarm->Description
                                ]);
                            // $alarm->save();
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
                    if ($this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','AdvSupInfo')->count() > 0)
                    {
                        $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','AdvSupInfo')->firstOrFail();
                        $alarm->AlarmStatus = 1;
                        $alarm->Description = sprintf("پروژه با موضوع %s فاقد استاد راهنما یا استاد مشاور می باشد",$MasterName);
                        try
                        {
                            Alarms::where('NidAlarm',$alarm->NidAlarm)->update(
                                [
                                    "AlarmStatus" => $alarm->AlarmStatus,
                                    "Description" => $alarm->Description
                                ]);
                            // $alarm->save();
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
        // $tmpProject = $this->model->all()->where('NidProject','=',$NidProject)->firstOrFail();
        if ($this->model->all()->where('NidProject','=',$NidProject)->count() > 0)
            return $this->ProjectProcess($this->model->all()->where('NidProject','=',$NidProject)->firstOrFail());
        else
            return false;
    }
    private function AlarmCancelation(string $NidMaster,int $ProcessId):bool
    {
            $result = false;
            switch ($ProcessId)
            {
                case 1:
                    if($this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','PreImployment')->count() > 0)
                    {
                        $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','PreImployment')->firstOrFail();
                        if (!is_null($alarm))
                        {
                            Alarms::where('NidAlarm',$alarm->NidAlarm)->update(
                                [
                                    "AlarmStatus" => 0
                                ]);
                        }
                        $result = true;
                    }
                    break;
                case 2:
                    if($this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','SecurityLetter')->count() > 0)
                    {
                        $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','SecurityLetter')->firstOrFail();
                        if (!is_null($alarm))
                        {
                            Alarms::where('NidAlarm',$alarm->NidAlarm)->update(
                                [
                                    "AlarmStatus" => 0
                                ]);
                        }
                        $result = true;
                    }
                    break;
                case 3:
                    if($this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','ThirtyLetter')->count() > 0)
                    {
                        $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','ThirtyLetter')->firstOrFail();
                        if (!is_null($alarm))
                        {
                            Alarms::where('NidAlarm',$alarm->NidAlarm)->update(
                                [
                                    "AlarmStatus" => 0
                                ]);
                        }
                        $result = true;
                    }
                    break;
                case 4:
                    if($this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','SixtyLetter')->count() > 0)
                    {
                        $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','SixtyLetter')->firstOrFail();
                        if (!is_null($alarm))
                        {
                            Alarms::where('NidAlarm',$alarm->NidAlarm)->update(
                                [
                                    "AlarmStatus" => 0
                                ]);
                        }
                        $result = true;
                    }
                    break;
                case 5:
                    if($this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','ThesisLetter')->count() > 0)
                    {
                        $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','ThesisLetter')->firstOrFail();
                        if (!is_null($alarm))
                        {
                            Alarms::where('NidAlarm',$alarm->NidAlarm)->update(
                                [
                                    "AlarmStatus" => 0
                                ]);
                        }
                        $result = true;
                    }
                    break;
                case 6:
                    if($this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','RefInfo')->count() > 0)
                    {
                        $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','RefInfo')->firstOrFail();
                        if (!is_null($alarm))
                        {
                            Alarms::where('NidAlarm',$alarm->NidAlarm)->update(
                                [
                                    "AlarmStatus" => 0
                                ]);
                        }
                        $result = true;
                    }
                    break;
                case 7:
                    if($this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','EditorInfo')->count() > 0)
                    {
                        $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','EditorInfo')->firstOrFail();
                        if (!is_null($alarm))
                        {
                            Alarms::where('NidAlarm',$alarm->NidAlarm)->update(
                                [
                                    "AlarmStatus" => 0
                                ]);
                        }
                        $result = true;
                    }
                    break;
                case 8:
                    if($this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','AdvSupInfo')->count() > 0)
                    {
                        $alarm = $this->model->all()->where('NidMaster','=',$NidMaster)->where('AlarmSubject','=','AdvSupInfo')->firstOrFail();
                        if (!is_null($alarm))
                        {
                            Alarms::where('NidAlarm',$alarm->NidAlarm)->update(
                                [
                                    "AlarmStatus" => 0
                                ]);
                        }
                        $result = true;
                    }
                    break;
            }
            return $result;
    }

    public function HandleAlarmsJob(int $RunInterval = 12):bool
    {
        $results = new Collection();
        $projects = Projects::all();
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
        $tmpGrouped = DB::select('select AlarmSubject as Subject,count(*) as cnt from Alarms where AlarmStatus <> ? group by AlarmSubject', [0]);// db.Alarms.Where(p => p.AlarmStatus != 0).GroupBy(q => q.AlarmSubject).Select(w => new { Subject = w.Key,cnt = w.Count()});
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
