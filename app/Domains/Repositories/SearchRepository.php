<?php

namespace App\Domains\Repositories;

use App\Domains\Interfaces\ISearchRepository;
use App\DTOs\DataMapper;
use App\Helpers\Casts;
use App\Models\Majors;
use App\Models\Oreintations;
use App\Models\Projects;
use App\Models\Scholars;
use App\Models\Settings;
use App\Models\UnitGroups;
use App\Models\Units;
use App\Models\User;
use App\Models\Users;
use App\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SearchRepository implements ISearchRepository{
    public int $SectionId;
    public int $ById;
    public bool $Similar;
    public Collection $Scholars;//ScholarListDTO
    public Collection $Projects;//ProjectInitialDTO
    public Collection $Users;//UserDTO
    public Collection $BaseInfo;//Setting
    public function AdvancedSearchProcess(string $searchText,int $SectionId,int $Similar,int $ById)
    {
        $ProjectResult = new Collection();
        $ScholarResult = new Collection();
        $UserResult = new Collection();
        $BaseInfoResult = new Collection();
        switch ($SectionId)
        {
            case 0:
                $ScholarResult = $this->SearchInScholars($searchText,$Similar,$ById);
                $ProjectResult = $this->SearchInProjects($searchText,$Similar,$ById);
                $UserResult = $this->SearchInUsers($searchText,$Similar,$ById);
                $BaseInfoResult = $this->SearchInBaseInfo($searchText,$Similar,$ById);
                break;
            case 1:
                $ScholarResult = $this->SearchInScholars($searchText,$Similar,$ById);
                break;
            case 2:
                $ProjectResult = $this->SearchInProjects($searchText,$Similar,$ById);
                break;
            case 3:
                $UserResult = $this->SearchInUsers($searchText,$Similar,$ById);
                break;
            case 4:
                $BaseInfoResult = $this->SearchInBaseInfo($searchText,$Similar,$ById);
                break;
        }
        return [$ScholarResult,$ProjectResult,$UserResult,$BaseInfoResult];
        // return $this->SearchInUsers($searchText,$Similar,$ById);
    }
    public function ComplexSearch(string $searchText,bool $Similar,int $ById)
    {
        $ScholarResult = $this->SearchInScholars($searchText,$Similar,$ById);
        $ProjectResult = $this->SearchInProjects($searchText,$Similar,$ById);
        $UserResult = $this->SearchInUsers($searchText,$Similar,$ById);
        return [$ScholarResult,$ProjectResult,$UserResult];
    }
    private function SearchInScholars(string $searchText,bool $Similar,int $ById):Collection//scholarlistdto
    {
        $result = new Collection();
        if($Similar)
        {
            switch ($ById)
            {
                case 0:
                    foreach (Scholars::all()->where('IsDeleted','=',false) as $key => $scholar) {
                        if(Str::contains($scholar->FirstName,$searchText) || Str::contains($scholar->LastName,$searchText))
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                        if(Str::contains($scholar->NationalCode,$searchText))
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                        if(Str::contains($scholar->Mobile,$searchText))
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                        if(Str::contains(Majors::all()->where('NidMajor','=',$scholar->MajorId)->firstOrFail()->Title,$searchText))
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                        if(Str::contains(Oreintations::all()->where('NidOreintation','=',$scholar->OreintationId)->firstOrFail()->Title,$searchText))
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    foreach (Settings::all()->where('SettingKey','=','MillitaryStatus') as $key => $setting) {
                        if(Str::contains($setting->SettingTitle,$searchText))
                        {
                            $tmpScholar = Scholars::all()->where('IsDeleted','=',false)->where('MillitaryStatus','=',$setting->SettingValue);
                            foreach ($tmpScholar as $scholar)
                            {
                                $result->push(DataMapper::MapToScholarListDTO($scholar));
                            }
                        }
                    }
                    foreach (Settings::all()->where('SettingKey','=','CollaborationType') as $key => $setting) {
                        if(Str::contains($setting->SettingTitle,$searchText))
                        {
                            $tmpScholar = Scholars::all()->where('IsDeleted','=',false)->where('CollaborationType','=',$setting->SettingValue);
                            foreach ($tmpScholar as $scholar)
                            {
                                $result->push(DataMapper::MapToScholarListDTO($scholar));
                            }
                        }
                    }
                    foreach (Settings::all()->where('SettingKey','=','GradeId') as $key => $setting) {
                        if(Str::contains($setting->SettingTitle,$searchText))
                        {
                            $tmpScholar = Scholars::all()->where('IsDeleted','=',false)->where('GradeId','=',$setting->SettingValue);
                            foreach ($tmpScholar as $scholar)
                            {
                                $result->push(DataMapper::MapToScholarListDTO($scholar));
                            }
                        }
                    }
                    foreach (Settings::all()->where('SettingKey','=','College') as $key => $setting) {
                        if(Str::contains($setting->SettingTitle,$searchText))
                        {
                            $tmpScholar = Scholars::all()->where('IsDeleted','=',false)->where('college','=',$setting->SettingValue);
                            foreach ($tmpScholar as $scholar)
                            {
                                $result->push(DataMapper::MapToScholarListDTO($scholar));
                            }
                        }
                    }
                    break;
                case 1:
                    foreach (Scholars::all()->where('IsDeleted','=',false) as $key => $scholar) {
                        if(Str::contains($scholar->FirstName,$searchText) || Str::contains($scholar->LastName,$searchText))
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    break;
                case 2:
                    foreach (Scholars::all()->where('IsDeleted','=',false) as $key => $scholar) {
                        if(Str::contains($scholar->NationalCode,$searchText))
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    break;
                case 3:
                    foreach (Scholars::all()->where('IsDeleted','=',false) as $key => $scholar) {
                        if(Str::contains($scholar->Mobile,$searchText))
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    break;
                case 4:
                    foreach (Settings::all()->where('SettingKey','=','MillitaryStatus') as $key => $setting) {
                        if(Str::contains($setting->SettingTitle,$searchText))
                        {
                            $tmpScholar = Scholars::all()->where('IsDeleted','=',false)->where('MillitaryStatus','=',$setting->SettingValue);
                            foreach ($tmpScholar as $scholar)
                            {
                                $result->push(DataMapper::MapToScholarListDTO($scholar));
                            }
                        }
                    }
                    break;
                case 5:
                    foreach (Settings::all()->where('SettingKey','=','CollaborationType') as $key => $setting) {
                        if(Str::contains($setting->SettingTitle,$searchText))
                        {
                            $tmpScholar = Scholars::all()->where('IsDeleted','=',false)->where('CollaborationType','=',$setting->SettingValue);
                            foreach ($tmpScholar as $scholar)
                            {
                                $result->push(DataMapper::MapToScholarListDTO($scholar));
                            }
                        }
                    }
                    break;
                case 6:
                    foreach (Scholars::all()->where('IsDeleted','=',false) as $key => $scholar) {
                        if(Str::contains(Majors::all()->where('NidMajor','=',$scholar->MajorId)->firstOrFail()->Title,$searchText))
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    break;
                case 7:
                    foreach (Scholars::all()->where('IsDeleted','=',false) as $key => $scholar) {
                        if(Str::contains(Oreintations::all()->where('NidOreintation','=',$scholar->OreintationId)->firstOrFail()->Title,$searchText))
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    break;
                case 8:
                    foreach (Settings::all()->where('SettingKey','=','GradeId') as $key => $setting) {
                        if(Str::contains($setting->SettingTitle,$searchText))
                        {
                            $tmpScholar = Scholars::all()->where('IsDeleted','=',false)->where('GradeId','=',$setting->SettingValue);
                            foreach ($tmpScholar as $scholar)
                            {
                                $result->push(DataMapper::MapToScholarListDTO($scholar));
                            }
                        }
                    }
                    break;
                case 9:
                    foreach (Settings::all()->where('SettingKey','=','College') as $key => $setting) {
                        if(Str::contains($setting->SettingTitle,$searchText))
                        {
                            $tmpScholar = Scholars::all()->where('IsDeleted','=',false)->where('college','=',$setting->SettingValue);
                            foreach ($tmpScholar as $scholar)
                            {
                                $result->push(DataMapper::MapToScholarListDTO($scholar));
                            }
                        }
                    }
                    break;
            }
        }
        else
        {
            switch ($ById)
            {
                case 0:
                    foreach (Scholars::all() as $scholar)
                    {
                        if($scholar->FirstName.' '.$scholar->LastName == $searchText)
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    $tmpScholar = Scholars::all()->where('NationalCode','=',$searchText)->where('IsDeleted','=',false);
                    foreach ($tmpScholar as $scholar)
                    {
                        $result->push(DataMapper::MapToScholarListDTO($scholar));
                    }
                    $tmpScholar = Scholars::all()->where('Mobile','=',$searchText)->where('IsDeleted','=',false);
                    foreach ($tmpScholar as $scholar)
                    {
                        $result->push(DataMapper::MapToScholarListDTO($scholar));
                    }
                    $tmpSetting = Settings::all()->where('SettingTitle','=',$searchText)->where('SettingKey','=','MillitaryStatus');
                    foreach($tmpSetting as $setting)
                    {
                        $tmpScholar = Scholars::all()->where('MillitaryStatus','=',$setting->SettingValue)->where('IsDeleted','=',false);
                        foreach ($tmpScholar as $scholar)
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    $tmpSetting = Settings::all()->where('SettingTitle','=',$searchText)->where('SettingKey','=','CollaborationType');
                    foreach($tmpSetting as $setting)
                    {
                        $tmpScholar = Scholars::all()->where('CollaborationType','=',$setting->SettingValue)->where('IsDeleted','=',false);
                        foreach ($tmpScholar as $scholar)
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    foreach (Scholars::all()->where('IsDeleted','=',false) as $key => $scholar) {
                        if(Majors::all()->where('NidMajor','=',$scholar->MajorId)->firstOrFail()->Title == $searchText)
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    foreach (Scholars::all()->where('IsDeleted','=',false) as $key => $scholar) {
                        if(Oreintations::all()->where('NidOreintation','=',$scholar->OreintationId)->firstOrFail()->Title == $searchText)
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    $tmpSetting = Settings::all()->where('SettingTitle','=',$searchText)->where('SettingKey','=','GradeId');
                    foreach($tmpSetting as $setting)
                    {
                        $tmpScholar = Scholars::all()->where('GradeId','=',$setting->SettingValue)->where('IsDeleted','=',false);
                        foreach ($tmpScholar as $scholar)
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    $tmpSetting = Settings::all()->where('SettingTitle','=',$searchText)->where('SettingKey','=','College');
                    foreach($tmpSetting as $setting)
                    {
                        $tmpScholar = Scholars::all()->where('College','=',$setting->SettingValue)->where('IsDeleted','=',false);
                        foreach ($tmpScholar as $scholar)
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    break;
                case 1:
                    foreach (Scholars::all() as $scholar)
                    {
                        if($scholar->FirstName.' '.$scholar->LastName == $searchText)
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    break;
                case 2:
                    $tmpScholar = Scholars::all()->where('NationalCode','=',$searchText)->where('IsDeleted','=',false);
                    foreach ($tmpScholar as $scholar)
                    {
                        $result->push(DataMapper::MapToScholarListDTO($scholar));
                    }
                    break;
                case 3:
                    $tmpScholar = Scholars::all()->where('Mobile','=',$searchText)->where('IsDeleted','=',false);
                    foreach ($tmpScholar as $scholar)
                    {
                        $result->push(DataMapper::MapToScholarListDTO($scholar));
                    }
                    break;
                case 4:
                    $tmpSetting = Settings::all()->where('SettingTitle','=',$searchText)->where('SettingKey','=','MillitaryStatus');
                    foreach($tmpSetting as $setting)
                    {
                        $tmpScholar = Scholars::all()->where('MillitaryStatus','=',$setting->SettingValue)->where('IsDeleted','=',false);
                        foreach ($tmpScholar as $scholar)
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    break;
                case 5:
                    $tmpSetting = Settings::all()->where('SettingTitle','=',$searchText)->where('SettingKey','=','CollaborationType');
                    foreach($tmpSetting as $setting)
                    {
                        $tmpScholar = Scholars::all()->where('CollaborationType','=',$setting->SettingValue)->where('IsDeleted','=',false);
                        foreach ($tmpScholar as $scholar)
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    break;
                case 6:
                    foreach (Scholars::all()->where('IsDeleted','=',false) as $key => $scholar) {
                        if(Majors::all()->where('NidMajor','=',$scholar->MajorId)->firstOrFail()->Title == $searchText)
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    break;
                case 7:
                    foreach (Scholars::all()->where('IsDeleted','=',false) as $key => $scholar) {
                        if(Oreintations::all()->where('NidOreintation','=',$scholar->OreintationId)->firstOrFail()->Title == $searchText)
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    break;
                case 8:
                    $tmpSetting = Settings::all()->where('SettingTitle','=',$searchText)->where('SettingKey','=','GradeId');
                    foreach($tmpSetting as $setting)
                    {
                        $tmpScholar = Scholars::all()->where('GradeId','=',$setting->SettingValue)->where('IsDeleted','=',false);
                        foreach ($tmpScholar as $scholar)
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    break;
                case 9:
                    $tmpSetting = Settings::all()->where('SettingTitle','=',$searchText)->where('SettingKey','=','College');
                    foreach($tmpSetting as $setting)
                    {
                        $tmpScholar = Scholars::all()->where('College','=',$setting->SettingValue)->where('IsDeleted','=',false);
                        foreach ($tmpScholar as $scholar)
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    break;
            }
        }
        return $result->unique();
    }
    private function SearchInProjects(string $searchText,bool $Similar,int $ById):Collection//ProjectInitialDTO
    {
        $result = new Collection();
        if ($Similar)
        {
            switch ($ById)
            {
                case 0:
                    foreach (Projects::all() as $key => $project) {
                        if(Str::contains($project->Subject,$searchText))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                        if(Str::contains(Units::all()->where('NidUnit','=',$project->UnitId)->firstOrFail()->Title,$searchText))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                        if(Str::contains(UnitGroups::all()->where('NidGroup','=',$project->GroupId)->firstOrFail()->Title,$searchText))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                        if(Str::contains($project->ProjectNumber,$searchText))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                        if(Str::contains($project->FirstName,$searchText) || Str::contains($project->LastName,$searchText))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                        if(Str::contains($project->Supervisor,$searchText))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                        if(Str::contains($project->Advisor,$searchText))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                        if(Str::contains($project->Referee1,$searchText))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                        if(Str::contains($project->Referee2,$searchText))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                    }
                    $searchtext = Casts::EnglishToPersianDigits($searchText);
                    foreach (Projects::all() as $key => $project) {
                        if(Str::contains($project->ImploymentDate,$searchtext))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                        if(Str::contains($project->TenPercentLetterDate,$searchtext))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                        if(Str::contains($project->PreImploymentLetterDate,$searchtext))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                        if(Str::contains($project->ThirtyPercentLetterDate,$searchtext))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                        if(Str::contains($project->SixtyPercentLetterDate,$searchtext))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                        if(Str::contains($project->SecurityLetterDate,$searchtext))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                        if(Str::contains($project->ThesisDefenceDate,$searchtext))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                    }
                    break;
                case 1:
                    foreach (Projects::all() as $key => $project) {
                        if(Str::contains($project->Subject,$searchText))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                    }
                    break;
                case 2:
                    foreach (Projects::all() as $key => $project) {
                        if(Str::contains(Units::all()->where('NidUnit','=',$project->UnitId)->firstOrFail()->Title,$searchText))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                    }
                    break;
                case 3:
                    foreach (Projects::all() as $key => $project) {
                        if(Str::contains(UnitGroups::all()->where('NidGroup','=',$project->GroupId)->firstOrFail()->Title,$searchText))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                    }
                    break;
                case 4:
                    foreach (Projects::all() as $key => $project) {
                        if(Str::contains($project->ProjectNumber,$searchText))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                    }
                    break;
                case 5:
                    foreach (Projects::all() as $key => $project) {
                        if(Str::contains($project->FirstName,$searchText) || Str::contains($project->LastName,$searchText))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                    }
                    break;
                case 6:
                    $searchtext = Casts::EnglishToPersianDigits($searchText);
                    foreach (Projects::all() as $key => $project) {
                        if(Str::contains($project->ImploymentDate,$searchtext))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                    }
                    break;
                case 7:
                    $searchtext = Casts::EnglishToPersianDigits($searchText);
                    foreach (Projects::all() as $key => $project) {
                        if(Str::contains($project->TenPercentLetterDate,$searchtext))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                    }
                    break;
                case 8:
                    $searchtext = Casts::EnglishToPersianDigits($searchText);
                    foreach (Projects::all() as $key => $project) {
                        if(Str::contains($project->PreImploymentLetterDate,$searchtext))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                    }
                    break;
                case 9:
                    $searchtext = Casts::EnglishToPersianDigits($searchText);
                    foreach (Projects::all() as $key => $project) {
                        if(Str::contains($project->ThirtyPercentLetterDate,$searchtext))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                    }
                    break;
                case 10:
                    $searchtext = Casts::EnglishToPersianDigits($searchText);
                    foreach (Projects::all() as $key => $project) {
                        if(Str::contains($project->SixtyPercentLetterDate,$searchtext))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                    }
                    break;
                case 11:
                    $searchtext = Casts::EnglishToPersianDigits($searchText);
                    foreach (Projects::all() as $key => $project) {
                        if(Str::contains($project->SecurityLetterDate,$searchtext))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                    }
                    break;
                case 12:
                    foreach (Projects::all() as $key => $project) {
                        if(Str::contains($project->Supervisor,$searchText))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                    }
                    break;
                case 13:
                    foreach (Projects::all() as $key => $project) {
                        if(Str::contains($project->Advisor,$searchText))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                    }
                    break;
                case 14:
                    foreach (Projects::all() as $key => $project) {
                        if(Str::contains($project->Referee1,$searchText))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                    }
                    break;
                case 15:
                    foreach (Projects::all() as $key => $project) {
                        if(Str::contains($project->Referee2,$searchText))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                    }
                    break;
                case 16:
                    $searchtext = Casts::EnglishToPersianDigits($searchText);
                    foreach (Projects::all() as $key => $project) {
                        if(Str::contains($project->ThesisDefenceDate,$searchtext))
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                    }
                    break;
            }
        }
        else
        {
            switch ($ById)
            {
                case 0:
                    $tmpProject = Projects::all()->where('Subject','=',$searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    foreach (Projects::all() as $project)
                    {
                        if(Units::all()->where('NidUnit','=',$project->UnitId)->firstOrFail()->Title == $searchText)
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                        if(UnitGroups::all()->where('NidGroup','=',$project->GroupId)->firstOrFail()->Title == $searchText)
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                    }
                    $tmpProject = Projects::all()->where('ProjectNumber','=',$searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    $searchtext = Casts::EnglishToPersianDigits($searchText);
                    $tmpProject = Projects::all()->where('ImploymentDate','=',$searchtext);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    $tmpProject = Projects::all()->where('TenPercentLetterDate','=',$searchtext);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    $tmpProject = Projects::all()->where('PreImploymentLetterDate','=',$searchtext);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    $tmpProject = Projects::all()->where('ThirtyPercentLetterDate','=',$searchtext);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    $tmpProject = Projects::all()->where('SixtyPercentLetterDate','=',$searchtext);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    $tmpProject = Projects::all()->where('SecurityLetterDate','=',$searchtext);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    $tmpProject = Projects::all()->where('ThesisDefenceDate','=',$searchtext);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    $tmpProject = Projects::all()->where('Supervisor','=',$searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    $tmpProject = Projects::all()->where('Advisor','=',$searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    $tmpProject = Projects::all()->where('Referee1','=',$searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    $tmpProject = Projects::all()->where('Referee2','=',$searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    break;
                case 1:
                    $tmpProject = Projects::all()->where('Subject','=',$searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    break;
                case 2:
                    foreach (Projects::all() as $project)
                    {
                        if(Units::all()->where('NidUnit','=',$project->UnitId)->firstOrFail()->Title == $searchText)
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                    }
                    break;
                case 3:
                    foreach (Projects::all() as $project)
                    {
                        if(UnitGroups::all()->where('NidGroup','=',$project->GroupId)->firstOrFail()->Title == $searchText)
                        {
                            $result->push(DataMapper::MapToProjectInitialDTO($project));
                        }
                    }
                    break;
                case 4:
                    $tmpProject = Projects::all()->where('ProjectNumber','=',$searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    break;
                case 5:
                    // foreach (var prj in db.Projects.Where(p => (p.Scholar.FirstName + " " + p.Scholar.LastName) == searchtext))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    break;
                case 6:
                    $searchtext = Casts::EnglishToPersianDigits($searchText);
                    $tmpProject = Projects::all()->where('ImploymentDate','=',$searchtext);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    break;
                case 7:
                    $searchtext = Casts::EnglishToPersianDigits($searchText);
                    $tmpProject = Projects::all()->where('TenPercentLetterDate','=',$searchtext);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    break;
                case 8:
                    $searchtext = Casts::EnglishToPersianDigits($searchText);
                    $tmpProject = Projects::all()->where('PreImploymentLetterDate','=',$searchtext);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    break;
                case 9:
                    $searchtext = Casts::EnglishToPersianDigits($searchText);
                    $tmpProject = Projects::all()->where('ThirtyPercentLetterDate','=',$searchtext);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    break;
                case 10:
                    $searchtext = Casts::EnglishToPersianDigits($searchText);
                    $tmpProject = Projects::all()->where('SixtyPercentLetterDate','=',$searchtext);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    break;
                case 11:
                    $searchtext = Casts::EnglishToPersianDigits($searchText);
                    $tmpProject = Projects::all()->where('SecurityLetterDate','=',$searchtext);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    break;
                case 12:
                    $tmpProject = Projects::all()->where('Supervisor','=',$searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    break;
                case 13:
                    $tmpProject = Projects::all()->where('Advisor','=',$searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    break;
                case 14:
                    $tmpProject = Projects::all()->where('Referee1','=',$searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    break;
                case 15:
                    $tmpProject = Projects::all()->where('Referee2','=',$searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    break;
                case 16:
                    $searchtext = Casts::EnglishToPersianDigits($searchText);
                    $tmpProject = Projects::all()->where('ThesisDefenceDate','=',$searchtext);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    break;
            }
        }
        return $result->unique();
    }
    private function SearchInUsers(string $searchText,bool $Similar,int $ById)//UserDTO
    {
        $result = new Collection();//UserDTO
        if($Similar)
        {
            switch ($ById)
            {
                case 0:
                    foreach (User::all() as $user)
                    {
                        if(Str::contains($user->UserName, $searchText))
                        {
                            $result->push(DataMapper::MapToUserDTO($user));
                        }
                        if(Str::contains($user->FirstName, $searchText) || Str::contains($user->LastName, $searchText))
                        {
                            $result->push(DataMapper::MapToUserDTO($user));
                        }
                    }
                    break;
                case 1:
                    foreach (User::all() as $user)
                    {
                        if(Str::contains($user->UserName, $searchText))
                        {
                            $result->push(DataMapper::MapToUserDTO($user));
                        }
                    }
                    break;
                case 2:
                    foreach (User::all() as $user)
                    {
                        if(Str::contains($user->FirstName, $searchText) || Str::contains($user->LastName, $searchText))
                        {
                            $result->push(DataMapper::MapToUserDTO($user));
                        }
                    }
                    break;
            }
        }
        else
        {
            switch ($ById)
            {
                case 0:
                    foreach (User::all() as $user)
                    {
                        if($user->FirstName.' '.$user->LastName == $searchText || $user->UserName == $searchText)
                        {
                            $result->push(DataMapper::MapToUserDTO($user));
                        }
                    }
                    break;
                case 1:
                    foreach (User::all()->where('UserName','=',$searchText) as $user)
                    {
                        $result->push(DataMapper::MapToUserDTO($user));
                    }
                    break;
                case 2:
                    foreach (User::all() as $user)
                    {
                        if($user->FirstName.' '.$user->LastName == $searchText)
                        {
                            $result->push(DataMapper::MapToUserDTO($user));
                        }
                    }
                    break;
            }
        }
        return $result->unique();
    }
    private function SearchInBaseInfo(string $searchText,bool $Similar,int $ById):Collection//Setting
    {
        $result = new Collection();//Setting
        if ($Similar)
        {
            switch ($ById)
            {
                case 0:
                    foreach (Settings::all()->where('IsDeleted','=',false) as $setting)
                    {
                        if(Str::contains($setting->SettingTitle,$searchText))
                        {
                            $result->push($setting);
                        }
                    }
                    break;
                case 1:
                    foreach (Settings::all()->where('IsDeleted','=',false) as $setting)
                    {
                        if(Str::contains($setting->SettingTitle,$searchText))
                        {
                            $result->push($setting);
                        }
                    }
                    break;
            }
        }
        else
        {
            switch ($ById)
            {
                case 0:
                    $tmpSetting = Settings::all()->where('IsDeleted','=',false)->where('SettingTitle','=',$searchText);
                    foreach ($tmpSetting as $setting)
                    {
                        $result->push($setting);
                    }
                    break;
                case 1:
                    $tmpSetting = Settings::all()->where('IsDeleted','=',false)->where('SettingTitle','=',$searchText);
                    foreach ($tmpSetting as $setting)
                    {
                        $result->push($setting);
                    }
                    break;
            }
        }
        return $result->unique();
    }
}

class SearchRepositoryFactory
{
    public static function GetSearchRepositoryObj():ISearchRepository
    {
        return new SearchRepository();
    }

}
