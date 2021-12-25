<?php

namespace App\Domains\Repositories;

use App\Domains\Interfaces\ISearchRepository;
use App\DTOs\DataMapper;
use App\Models\Projects;
use App\Models\Scholars;
use App\Models\Settings;
use App\Models\User;
use App\Models\Users;
use App\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Collection;

class SearchRepository implements ISearchRepository{
    public int $SectionId;
    public int $ById;
    public bool $Similar;
    public Collection $Scholars;//ScholarListDTO
    public Collection $Projects;//ProjectInitialDTO
    public Collection $Users;//UserDTO
    public Collection $BaseInfo;//Setting
    public function AdvancedSearch(string $searchText,int $SectionId,bool $Similar,int $ById):SearchRepository
    {
        switch ($SectionId)
        {
            case 0:
                $this->Scholars = $this->SearchInScholars($searchText,$Similar,$ById);
                $this->Projects = $this->SearchInProjects($searchText,$Similar,$ById);
                $this->Users = $this->SearchInUsers($searchText,$Similar,$ById);
                $this->BaseInfo = $this->SearchInBaseInfo($searchText,$Similar,$ById);
                break;
            case 1:
                $this->Scholars = $this->SearchInScholars($searchText,$Similar,$ById);
                break;
            case 2:
                $this->Projects = $this->SearchInProjects($searchText,$Similar,$ById);
                break;
            case 3:
                $this->Users = $this->SearchInUsers($searchText,$Similar,$ById);
                break;
            case 4:
                $this->BaseInfo = $this->SearchInBaseInfo($searchText,$Similar,$ById);
                break;
        }
        return $this;
    }
    public function ComplexSearch(string $searchText,bool $Similar,int $ById):SearchRepository
    {
        $this->Scholars = $this->SearchInScholars($searchText,$Similar,$ById);
        $this->Projects = $this->SearchInProjects($searchText,$Similar,$ById);
        $this->Users = $this->SearchInUsers($searchText,$Similar,$ById);
        return $this;
    }
    private function SearchInScholars(string $searchText,bool $Similar,int $ById):Collection//scholarlistdto
    {
        $result = new Collection();
        if($Similar)
        {
            switch ($ById)
            {
                case 0:
                    // foreach (var sch in db.Scholars.Where(p => (p.FirstName + " " + p.LastName).Contains(searchtext) && p.IsDeleted == false))
                    // {
                    //     result.Add(mapper.MapToScholarListDTO(sch));
                    // }
                    $tmpScholar = Scholars::all()->where('IsDeleted','=',false)->where('NationalCode','like','%'.$searchText.'%');//->get('NationalCode')->contains($searchText);
                    foreach ($tmpScholar as $scholar)
                    {
                        $result->push(DataMapper::MapToScholarListDTO($scholar));
                    }
                    $tmpScholar = Scholars::all()->where('IsDeleted','=',false)->where('Mobile','like','%'.$searchText.'%');//->get('Mobile')->contains($searchText);
                    foreach ($tmpScholar as $scholar)
                    {
                        $result->push(DataMapper::MapToScholarListDTO($scholar));
                    }
                    $tmpSetting = Settings::all()->where('SettingKey','=','MillitaryStatus')->where('SettingTitle','like','%'.$searchText.'%');//->get('SettingTitle')->contains($searchText);
                    foreach ($tmpSetting as $setting)
                    {
                        $tmpScholar = Scholars::all()->where('IsDeleted','=',false)->where('MillitaryStatus','=',$setting->SettingValue);
                        foreach ($tmpScholar as $scholar)
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    $tmpSetting = Settings::all()->where('SettingKey','=','CollaborationType')->where('SettingTitle','like','%'.$searchText.'%');//->get('SettingTitle')->contains($searchText);
                    foreach ($tmpSetting as $setting)
                    {
                        $tmpScholar = Scholars::all()->where('IsDeleted','=',false)->where('CollaborationType','=',$setting->SettingValue);
                        foreach ($tmpScholar as $scholar)
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    // foreach (var sch in db.Scholars.Where(p => p.Major.Title.Contains(searchtext) && p.IsDeleted == false))
                    // {
                    //     result.Add(mapper.MapToScholarListDTO(sch));
                    // }
                    // foreach (var sch in db.Scholars.Where(p => p.Oreintation.Title.Contains(searchtext) && p.IsDeleted == false))
                    // {
                    //     result.Add(mapper.MapToScholarListDTO(sch));
                    // }
                    $tmpSetting = Settings::all()->where('SettingKey','=','GradeId')->where('SettingTitle','like','%'.$searchText.'%');//->get('SettingTitle')->contains($searchText);
                    foreach ($tmpSetting as $setting)
                    {
                        $tmpScholar = Scholars::all()->where('IsDeleted','=',false)->where('GradeId','=',$setting->SettingValue);
                        foreach ($tmpScholar as $scholar)
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    $tmpSetting = Settings::all()->where('SettingKey','=','College')->where('SettingTitle','like','%'.$searchText.'%');//->get('SettingTitle')->contains($searchText);
                    foreach ($tmpSetting as $setting)
                    {
                        $tmpScholar = Scholars::all()->where('IsDeleted','=',false)->where('college','=',$setting->SettingValue);
                        foreach ($tmpScholar as $scholar)
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    break;
                case 1:
                    // foreach (var sch in db.Scholars.Where(p => (p.FirstName + " " + p.LastName).Contains(searchtext) && p.IsDeleted == false))
                    // {
                    //     result.Add(mapper.MapToScholarListDTO(sch));
                    // }
                    break;
                case 2:
                    $tmpScholar = Scholars::all()->where('IsDeleted','=',false)->where('NationalCode','like','%'.$searchText.'%');//->get('NationalCode')->contains($searchText);
                    foreach ($tmpScholar as $scholar)
                    {
                        $result->push(DataMapper::MapToScholarListDTO($scholar));
                    }
                    break;
                case 3:
                    $tmpScholar = Scholars::all()->where('IsDeleted','=',false)->where('Mobile','like','%'.$searchText.'%');//->get('Mobile')->contains($searchText);
                    foreach ($tmpScholar as $scholar)
                    {
                        $result->push(DataMapper::MapToScholarListDTO($scholar));
                    }
                    break;
                case 4:
                    $tmpSetting = Settings::all()->where('SettingKey','=','MillitaryStatus')->where('SettingTitle','like','%'.$searchText.'%');//->get('SettingTitle')->contains($searchText);
                    foreach ($tmpSetting as $setting)
                    {
                        $tmpScholar = Scholars::all()->where('IsDeleted','=',false)->where('MillitaryStatus','=',$setting->SettingValue);
                        foreach ($tmpScholar as $scholar)
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    break;
                case 5:
                    $tmpSetting = Settings::all()->where('SettingKey','=','CollaborationType')->where('SettingTitle','like','%'.$searchText.'%');//->get('SettingTitle')->contains($searchText);
                    foreach ($tmpSetting as $setting)
                    {
                        $tmpScholar = Scholars::all()->where('IsDeleted','=',false)->where('CollaborationType','=',$setting->SettingValue);
                        foreach ($tmpScholar as $scholar)
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    break;
                case 6:
                    // foreach (var sch in db.Scholars.Where(p => p.Major.Title.Contains(searchtext) && p.IsDeleted == false))
                    // {
                    //     result.Add(mapper.MapToScholarListDTO(sch));
                    // }
                    break;
                case 7:
                    // foreach (var sch in db.Scholars.Where(p => p.Oreintation.Title.Contains(searchtext) && p.IsDeleted == false))
                    // {
                    //     result.Add(mapper.MapToScholarListDTO(sch));
                    // }
                    break;
                case 8:
                    $tmpSetting = Settings::all()->where('SettingKey','=','GradeId')->where('SettingTitle','like','%'.$searchText.'%');//->get('SettingTitle')->contains($searchText);
                    foreach ($tmpSetting as $setting)
                    {
                        $tmpScholar = Scholars::all()->where('IsDeleted','=',false)->where('GradeId','=',$setting->SettingValue);
                        foreach ($tmpScholar as $scholar)
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
                        }
                    }
                    break;
                case 9:
                    $tmpSetting = Settings::all()->where('SettingKey','=','College')->where('SettingTitle','like','%'.$searchText.'%');//->get('SettingTitle')->contains($searchText);
                    foreach ($tmpSetting as $setting)
                    {
                        $tmpScholar = Scholars::all()->where('IsDeleted','=',false)->where('college','=',$setting->SettingValue);
                        foreach ($tmpScholar as $scholar)
                        {
                            $result->push(DataMapper::MapToScholarListDTO($scholar));
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
                    // foreach (var sch in db.Scholars.Where(p => (p.FirstName + " " + p.LastName) == searchtext && p.IsDeleted == false))
                    // {
                    //     result.Add(mapper.MapToScholarListDTO(sch));
                    // }
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
                    // foreach (var sch in db.Scholars.Where(p => p.Major.Title == searchtext && p.IsDeleted == false))
                    // {
                    //     result.Add(mapper.MapToScholarListDTO(sch));
                    // }
                    // foreach (var sch in db.Scholars.Where(p => p.Oreintation.Title == searchtext && p.IsDeleted == false))
                    // {
                    //     result.Add(mapper.MapToScholarListDTO(sch));
                    // }
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
                    // foreach (var sch in db.Scholars.Where(p => (p.FirstName + " " + p.LastName) == searchtext && p.IsDeleted == false))
                    // {
                    //     result.Add(mapper.MapToScholarListDTO(sch));
                    // }
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
                    // foreach (var sch in db.Scholars.Where(p => p.Major.Title == searchtext && p.IsDeleted == false))
                    // {
                    //     result.Add(mapper.MapToScholarListDTO(sch));
                    // }
                    break;
                case 7:
                    // foreach (var sch in db.Scholars.Where(p => p.Oreintation.Title == searchtext && p.IsDeleted == false))
                    // {
                    //     result.Add(mapper.MapToScholarListDTO(sch));
                    // }
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
        $uniques = new Collection();//ScholarListDTO
        $grouped = $result->groupBy('NidScholar');
        foreach ($grouped as $itm)
        {
            $uniques->push($result->where('NidScholar','=',$itm)->firstOrFail());
        }
        return $uniques;
    }
    private function SearchInProjects(string $searchText,bool $Similar,int $ById):Collection//ProjectInitialDTO
    {
        $result = new Collection();
        if ($Similar)
        {
            switch ($ById)
            {
                case 0:
                    $tmpProject = Projects::all()->where('Subject','like','%'.$searchText.'%');//->get('Subject')->contains($searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    // foreach (var prj in db.Projects.Where(p => p.Unit.Title.Contains(searchtext)))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    // foreach (var prj in db.Projects.Where(p => p.UnitGroup.Title.Contains(searchtext)))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    $tmpProject = Projects::all()->where('ProjectNumber','like','%'.$searchText.'%');//->get('ProjectNumber')->contains($searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    // foreach (var prj in db.Projects.Where(p => (p.Scholar.FirstName + " " + p.Scholar.LastName).Contains(searchtext)))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.ImploymentDate.Contains(searchtext)))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.TenPercentLetterDate.Contains(searchtext)))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.PreImploymentLetterDate.Contains(searchtext)))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.ThirtyPercentLetterDate.Contains(searchtext)))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.SixtyPercentLetterDate.Contains(searchtext)))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.SecurityLetterDate.Contains(searchtext)))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    $tmpProject = Projects::all()->where('Supervisor','like','%'.$searchText.'%');//->get('Supervisor')->contains($searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    $tmpProject = Projects::all()->where('Advisor','like','%'.$searchText.'%');//->get('Advisor')->contains($searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    $tmpProject = Projects::all()->where('Referee1','like','%'.$searchText.'%');//->get('Referee1')->contains($searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    $tmpProject = Projects::all()->where('Referee2','like','%'.$searchText.'%');//->get('Referee2')->contains($searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.ThesisDefenceDate.Contains(searchtext)))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    break;
                case 1:
                    $tmpProject = Projects::all()->where('Subject','like','%'.$searchText.'%');//->get('Subject')->contains($searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    break;
                case 2:
                    // foreach (var prj in db.Projects.Where(p => p.Unit.Title.Contains(searchtext)))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    break;
                case 3:
                    // foreach (var prj in db.Projects.Where(p => p.UnitGroup.Title.Contains(searchtext)))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    break;
                case 4:
                    $tmpProject = Projects::all()->where('ProjectNumber','like','%'.$searchText.'%');//->get('ProjectNumber')->contains($searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    break;
                case 5:
                    // foreach (var prj in db.Projects.Where(p => (p.Scholar.FirstName + " " + p.Scholar.LastName).Contains(searchtext)))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    break;
                case 6:
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.ImploymentDate.Contains(searchtext)))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    break;
                case 7:
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.TenPercentLetterDate.Contains(searchtext)))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    break;
                case 8:
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.PreImploymentLetterDate.Contains(searchtext)))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    break;
                case 9:
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.ThirtyPercentLetterDate.Contains(searchtext)))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    break;
                case 10:
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.SixtyPercentLetterDate.Contains(searchtext)))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    break;
                case 11:
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.SecurityLetterDate.Contains(searchtext)))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    break;
                case 12:
                    $tmpProject = Projects::all()->where('Supervisor','like','%'.$searchText.'%');//->get('Supervisor')->contains($searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    break;
                case 13:
                    $tmpProject = Projects::all()->where('Advisor','like','%'.$searchText.'%');//->get('Advisor')->contains($searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    break;
                case 14:
                    $tmpProject = Projects::all()->where('Referee1','like','%'.$searchText.'%');//->get('Referee1')->contains($searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    break;
                case 15:
                    $tmpProject = Projects::all()->where('Referee2','like','%'.$searchText.'%');//->get('Referee2')->contains($searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    break;
                case 16:
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.ThesisDefenceDate.Contains(searchtext)))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
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
                    // foreach (var prj in db.Projects.Where(p => p.Unit.Title == searchtext))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    // foreach (var prj in db.Projects.Where(p => p.UnitGroup.Title == searchtext))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    $tmpProject = Projects::all()->where('ProjectNumber','=',$searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    // foreach (var prj in db.Projects.Where(p => (p.Scholar.FirstName + " " + p.Scholar.LastName) == searchtext))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.ImploymentDate == searchtext))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.TenPercentLetterDate == searchtext))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.PreImploymentLetterDate == searchtext))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.ThirtyPercentLetterDate == searchtext))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.SixtyPercentLetterDate == searchtext))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.SecurityLetterDate == searchtext))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
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
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.ThesisDefenceDate == searchtext))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    break;
                case 1:
                    $tmpProject = Projects::all()->where('Subject','=',$searchText);
                    foreach ($tmpProject as $project)
                    {
                        $result->push(DataMapper::MapToProjectInitialDTO($project));
                    }
                    break;
                case 2:
                    // foreach (var prj in db.Projects.Where(p => p.Unit.Title == searchtext))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    break;
                case 3:
                    // foreach (var prj in db.Projects.Where(p => p.UnitGroup.Title == searchtext))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
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
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.ImploymentDate == searchtext))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    break;
                case 7:
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.TenPercentLetterDate == searchtext))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    break;
                case 8:
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.PreImploymentLetterDate == searchtext))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    break;
                case 9:
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.ThirtyPercentLetterDate == searchtext))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    break;
                case 10:
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.SixtyPercentLetterDate == searchtext))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    break;
                case 11:
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.SecurityLetterDate == searchtext))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
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
                    // searchtext = Helpers.Casts.EnglishToPersianDigits(searchtext);
                    // foreach (var prj in db.Projects.Where(p => p.ThesisDefenceDate == searchtext))
                    // {
                    //     result.Add(mapper.MapToProjectInitialDTO(prj));
                    // }
                    break;
            }
        }
        $uniques = new Collection();//ProjectInitialDTO
        $grouped = $result->groupBy('NidProject');
        foreach ($grouped as $itm)
        {
            $uniques->push($result->where('NidProject','=',$itm)->firstOrFail());
        }
        return $uniques;
    }
    private function SearchInUsers(string $searchText,bool $Similar,int $ById):Collection//UserDTO
    {
        $result = new Collection();//UserDTO
        if($Similar)
        {
            switch ($ById)
            {
                case 0:
                    $tmpUser = User::all()->where('Username','like','%'.$searchText.'%');//->get('Username')->contains($searchText);
                    foreach ($tmpUser as $user)
                    {
                        $result->push(DataMapper::MapToUserDTO($user));
                    }
                    // foreach (var usr in db.Users.Where(p => (p.FirstName + " " + p.LastName).Contains(searchtext) && p.IsDisabled == false))
                    // {
                    //     result.Add(mapper.MapToUserDTO(usr));
                    // }
                    // foreach (var res in db.UserPermissions.Where(p => p.Resource.ResourceName.Contains(searchtext)).get(q => q.UserId))
                    // {
                    //     foreach (var usr in db.Users.Where(p => p.NidUser == res && p.IsDisabled == false))
                    //     {
                    //         result.Add(mapper.MapToUserDTO(usr));
                    //     }
                    // }
                    break;
                case 1:
                    $tmpUser = User::all()->where('UserName','like','%'.$searchText.'%');//->get('Username')->contains($searchText);
                    foreach ($tmpUser as $user)
                    {
                        $result->push(DataMapper::MapToUserDTO($user));
                    }
                    break;
                case 2:
                    // foreach (var usr in db.Users.Where(p => (p.FirstName + " " + p.LastName).Contains(searchtext) && p.IsDisabled == false))
                    // {
                    //     result.Add(mapper.MapToUserDTO(usr));
                    // }
                    break;
                case 3:
                    // foreach (var res in db.UserPermissions.Where(p => p.Resource.ResourceName.Contains(searchtext)).get(q => q.UserId))
                    // {
                    //     foreach (var usr in db.Users.Where(p => p.NidUser == res && p.IsDisabled == false))
                    //     {
                    //         result.Add(mapper.MapToUserDTO(usr));
                    //     }
                    // }
                    break;
            }
        }
        else
        {
            switch ($ById)
            {
                case 0:
                    $tmpUser = User::all()->where('Username','=',$searchText);
                    foreach ($tmpUser as $user)
                    {
                        $result->push(DataMapper::MapToUserDTO($user));
                    }
                    // foreach (var usr in db.Users.Where(p => (p.FirstName + " " + p.LastName) == searchtext && p.IsDisabled == false))
                    // {
                    //     result.Add(mapper.MapToUserDTO(usr));
                    // }
                    // foreach (var res in db.UserPermissions.Where(p => p.Resource.ResourceName == searchtext).get(q => q.UserId))
                    // {
                    //     foreach (var usr in db.Users.Where(p => p.NidUser == res && p.IsDisabled == false))
                    //     {
                    //         result.Add(mapper.MapToUserDTO(usr));
                    //     }
                    // }
                    break;
                case 1:
                    $tmpUser = User::all()->where('Username','=',$searchText);
                    foreach ($tmpUser as $user)
                    {
                        $result->push(DataMapper::MapToUserDTO($user));
                    }
                    break;
                case 2:
                    // foreach (var usr in db.Users.Where(p => (p.FirstName + " " + p.LastName) == searchtext && p.IsDisabled == false))
                    // {
                    //     result.Add(mapper.MapToUserDTO(usr));
                    // }
                    break;
                case 3:
                    // foreach (var res in db.UserPermissions.Where(p => p.Resource.ResourceName == searchtext).get(q => q.UserId))
                    // {
                    //     foreach (var usr in db.Users.Where(p => p.NidUser == res && p.IsDisabled == false))
                    //     {
                    //         result.Add(mapper.MapToUserDTO(usr));
                    //     }
                    // }
                    break;
            }
        }
        $uniques = new Collection();//UserDTO
        $grouped = $result->groupBy('NidUser');
        foreach ($grouped as $itm)
        {
            $uniques->push($result->where('NidUser','=',$itm)->firstOrFail());
        }
        return $uniques;
    }
    private function SearchInBaseInfo(string $searchText,bool $Similar,int $ById):Collection//Setting
    {
        $result = new Collection();//Setting
        if ($Similar)
        {
            switch ($ById)
            {
                case 0:
                    $tmpSetting = Settings::all()->where('IsDeleted','=',false)->where('SettingTitle','like','%'.$searchText.'%');//->get('SettingTitle')->contains($searchText);
                    foreach ($tmpSetting as $setting)
                    {
                        $result->push($setting);
                    }
                    break;
                case 1:
                    $tmpSetting = Settings::all()->where('IsDeleted','=',false)->where('SettingTitle','like','%'.$searchText.'%');//->get('SettingTitle')->contains($searchText);
                    foreach ($tmpSetting as $setting)
                    {
                        $result->push($setting);
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
        $uniques = new Collection();//Setting
        $grouped = $result->groupBy('NidSetting');
        foreach ($grouped as $itm)
        {
            $uniques->push($result->where('NidUser','=',$itm)->firstOrFail());
        }
        return $uniques;
    }
}

class SearchRepositoryFactory
{
    public static function GetSearchRepositoryObj():ISearchRepository
    {
        return new SearchRepository();
    }

}
