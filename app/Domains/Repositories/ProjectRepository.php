<?php

namespace App\Domains\Repositories;

use App\Domains\Eloquent\BaseRepository;
use App\Domains\Interfaces\IProjectRepository;
use App\DTOs\DataMapper;
use App\DTOs\projectDetailDTO;
use App\DTOs\projectDTO;
use App\DTOs\projectInitialDTO;
use App\DTOs\unitGroupDTO;
use App\Models\Majors;
use App\Models\Oreintations;
use App\Models\Projects;
use App\Models\Scholars;
use App\Models\Settings;
use App\Models\UnitGroups;
use App\Models\Units;
use Brick\Math\BigInteger;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectRepository extends BaseRepository implements IProjectRepository
{
    public function __construct(Projects $model)
    {
        parent::__construct($model);
    }
    public function GetProjectInitials(int $pagesize = 100):Collection
    {
        $result = new Collection();
        if($pagesize != 0)
        {
            $tmpProject = $this->model->all()->take($pagesize);
            foreach ($tmpProject as $prj)
            {
                $tmpprojectinitial = DataMapper::MapToProjectInitialDTO($prj);
                $tmpscholar = Scholars::all()->where('NidScholar','=',$tmpprojectinitial->ScholarId)->firstOrFail();
                $tmpprojectinitial->ScholarName = $tmpscholar->FirstName.' '.$tmpscholar->LastName;
                $tmpprojectinitial->UnitName = $this->GetUnitById($tmpprojectinitial->UnitId)->Title;
                $tmpprojectinitial->GroupName = $this->GetUnitGroupById($tmpprojectinitial->GroupId)->Title;
                $result->push($tmpprojectinitial);
            }
        }else
        {
            $tmpProject = $this->model->all();
            foreach ($tmpProject as $prj)
            {
                $tmpprojectinitial = DataMapper::MapToProjectInitialDTO($prj);
                $tmpscholar = Scholars::all()->where('NidScholar','=',$tmpprojectinitial->ScholarId)->firstOrFail();
                $tmpprojectinitial->ScholarName = $tmpscholar->FirstName.' '.$tmpscholar->LastName;
                $tmpprojectinitial->UnitName = $this->GetUnitById($tmpprojectinitial->UnitId)->Title;
                $tmpprojectinitial->GroupName = $this->GetUnitGroupById($tmpprojectinitial->GroupId)->Title;
                $result->push($tmpprojectinitial);
            }
        }
        // return $result;
        return $result;
    }
    public function AddProjectInitial(projectInitialDTO $projectInitial):bool
    {
        $tmpProject = DataMapper::MapToProjectFromProjectInitialDTO($projectInitial);
        $tmpProject->save();
        return true;
    }
    public function ProjectProgress(Projects $project) :bool
    {
        $project->save();
        return true;
    }
    public function GetProjectDTOById(string $NidProject):projectDTO
    {
        return DataMapper::MapToProjectDTO($this->model->all()->where('NidProject','=',$NidProject)->firstOrFail());
    }
    public function GetProjectDetailDTOById(string $NidProject):projectDetailDTO
    {
        $tmpDetail = DataMapper::MapToProjectDetailDTO(Projects::all()->where('NidProject','=',$NidProject)->firstOrFail());
        if(!is_null($tmpDetail))
        {
            $tmpDetail->GroupTitle = $this->GetUnitGroupById($tmpDetail->GroupId)->Title;
            $tmpDetail->UnitTitle = $this->GetUnitById($tmpDetail->UnitId)->Title;
            return $tmpDetail;
        }else
        {
            return new projectDetailDTO();
        }
    }
    public function GetUnits(int $pagesize = 100):Collection
    {
        $result = new Collection();
        if ($pagesize == 0)
        {
            $tmpUnits = Units::all();
            foreach ($tmpUnits as $uni)
            {
                $result->push(DataMapper::MapToUnitDTO($uni));
            }
        }
        else
        {
            $tmpUnits = Units::all()->take($pagesize);
            foreach ($tmpUnits as $uni)
            {
                $result->push(DataMapper::MapToUnitDTO($uni));
            }
        }
        return $result;
        // return Units::all();
    }
    public function GetUnitGroups(int $pagesize = 100) :Collection
    {
        $result = new Collection();
        if ($pagesize == 0)
        {
            $tmpUnitGroups = UnitGroups::all();
            foreach ($tmpUnitGroups as $uni)
            {
                $result->push(DataMapper::MapToUnitGroupDTO($uni));
            }
        }
        else
        {
            $tmpUnitGroups = UnitGroups::all()->take($pagesize);
            foreach ($tmpUnitGroups as $uni)
            {
                $result->push(DataMapper::MapToUnitGroupDTO($uni));
            }
        }
        return $result;
    }
    public function GetProjectScholars(int $pagesize = 100):Collection
    {
        $result = new Collection();
        if($pagesize == 0)
        {
            // $tmpUnitGroups = Scholars::all()->where('IsDeleted','=',null)->orWhere('IsDeleted','=',false);
            $tmpUnitGroups = Scholars::all()->where('IsDeleted','=',false);
            foreach ($tmpUnitGroups as $sch)
            {
                $result->push(DataMapper::MapToScholarListDTO($sch));
            }
        }
        else
        {
            // $tmpUnitGroups = Scholars::all()->where('IsDeleted','=',null)->orWhere('IsDeleted','=',false)->take($pagesize);
            $tmpUnitGroups = Scholars::all()->where('IsDeleted','=',false)->take($pagesize);
            foreach ($tmpUnitGroups as $sch)
            {
                $result->push(DataMapper::MapToScholarListDTO($sch));
            }
        }
        return $result;
    }
    public function GetProjectById(string $NidProject):Projects
    {
        return $this->model->all()->where('NidProject','=',$NidProject)->firstOrFail();
    }
    public function GenerateProjectNumber():BigInteger
    {
        if($this->model->all()->count() > 0)
        {
            return BigInteger::of($this->model->all()->max('ProjectNumber') + 1);
        }
        else
        {
            return BigInteger::of(1001);
        }
    }
    public function CheckForUnitGroupExist(string $NidUnit) :bool
    {
        if(UnitGroups::all()->where('UnitId','=',$NidUnit)->count() > 0)
        {
            return true;
        }else{
            return false;
        }
    }
    public function CheckForOreintationExist(string $NidMajor):bool
    {
        if(Oreintations::all()->where('MajorId','=',$NidMajor)->count() > 0)
        {
            return true;
        }else
        {
            return false;
        }
    }
    public function GetUnitById(string $NidUnit):Units
    {
        return Units::all()->where('NidUnit','=',$NidUnit)->firstOrFail();
    }
    public function GetUnitGroupById(string $NidUnitGroup):UnitGroups
    {
        return UnitGroups::all()->where('NidGroup','=',$NidUnitGroup)->firstOrFail();
    }
    public function GetMajorById(string $NidMajor) :Majors
    {
        return Majors::all()->where('NidMajor','=',$NidMajor)->firstOrFail();
    }
    public function GetOreintationById(string $NidOreintation):Oreintations
    {
        return Oreintations::all()->where('NidOreintation','=',$NidOreintation)->firstOrFail();
    }
    public function GetSettingById(string $NidSetting):Settings
    {
        return Settings::all()->where('NidSetting','=',$NidSetting)->firstOrFail();
    }
    public function GenerateSettingId(int $Type):int
    {
        $result = 1;
        switch ($Type)
        {
            case 1://grade
                if (Settings::all()->where('SettingKey','=','GradeId')->count() > 0)
                    $result = Settings::all()->where('SettingKey','=','GradeId')->max('SettingValue') + 1;
                break;
            case 2://college
                if (Settings::all()->where('SettingKey','=','College')->count() > 0)
                    $result = Settings::all()->where('SettingKey','=','College')->max('SettingValue') + 1;
                break;
            case 3://millit
                if (Settings::all()->where('SettingKey','=','MillitaryStatus')->count() > 0)
                    $result = Settings::all()->where('SettingKey','=','MillitaryStatus')->max('SettingValue') + 1;
                break;
            case 4://collab
                if (Settings::all()->where('SettingKey','=','CollaborationType')->count() > 0)
                    $result = Settings::all()->where('SettingKey','=','CollaborationType')->max('SettingValue') + 1;
                break;
        }
        return $result;
    }
    public function ProjectStatusCalc(Projects $project) :int
    {
        $result = 0;
        if (!empty($project->SecurityLetterDate))
            $result += 5;
        if (!empty($project->Advisor) && !empty($project->Supervisor))
            $result += 5;
        if (!empty($project->ImploymentDate))
            $result += 5;
        if (!empty($project->TenPercentLetterDate))
            $result += 5;
        if (!empty($project->ThirtyPercentLetterDate))
            $result += 15;
        if (!empty($project->SixtyPercentLetterDate))
            $result += 20;
        if (!empty($project->ThesisDefenceDate))
            $result += 20;
        if (!empty($project->Editor))
            $result += 5;
        if (!empty($project->Commision))
            $result += 5;
        if ($project->TitleApproved != null && $project->TitleApproved == true)
            $result += 5;
        if ($project->HasBookPublish != null && $project->HasBookPublish == true)
            $result += 5;
        if ($project->FinalApprove != null && $project->FinalApprove == true)
            $result += 5;
        return $result;
    }
    public function AddUnit(Units $unit)
    {
        $unit->save();
        return $unit->Title;
    }
    public function UpdateUnit(Units $unit)
    {
        return Units::where('NidUnit',$unit->NidUnit)->update(
            [
                'Title' => $unit->Title
            ]);
    }
    public function DeleteUnit(Units $unit)
    {
        return $unit->delete();
    }
    public function AddUnitGroup(UnitGroups $unitgroup)
    {
        return $unitgroup->save();
    }
    public function UpdateUnitGroup(UnitGroups $unitgroup)
    {
        return UnitGroups::where('NidGroup',$unitgroup->NidGroup)->update(
            [
                'Title' => $unitgroup->Title,
                'UnitId' => $unitgroup->UnitId
            ]);
    }
    public function DeleteUnitGroup(UnitGroups $unitgroup)
    {
        return $unitgroup->delete();
    }
    public function AddMajor(Majors $major)
    {
        return $major->save();
    }
    public function UpdateMajor(Majors $major)
    {
        return Majors::where('NidMajor',$major->NidMajor)->update(
            [
                'Title' => $major->Title
            ]);
    }
    public function DeleteMajor(Majors $major)
    {
        return $major->delete();
    }
    public function AddOreintation(Oreintations $oreintation)
    {
        return $oreintation->save();
    }
    public function UpdateOreintation(Oreintations $oreintation)
    {
        return Oreintations::where('NidOreintation',$oreintation->NidOreintation)->update(
            [
                'Title' => $oreintation->Title,
                'MajorId' => $oreintation->MajorId
            ]);
    }
    public function DeleteOreintation(Oreintations $oreintation)
    {
        return $oreintation->delete();
    }
    public function AddSetting(Settings $setting)
    {
        return $setting->save();
    }
    public function UpdateSetting(Settings $setting)
    {
        Settings::where('NidSetting',$setting->NidSetting)->update(
            [
                'SettingKey'=>$setting->SettingKey,
                'SettingValue'=>$setting->SettingValue,
                'SettingTitle'=>$setting->SettingTitle,
                'IsDeleted'=>$setting->IsDeleted
            ]);
        return true;
    }
    public function DeleteSetting(Settings $setting)
    {
        return $setting->delete();
    }
    public function UpdateProject(Projects $project)
    {
        $current = Projects::where('NidProject',$project->NidProject)->update(
            [
                'ProjectNumber' => $project->ProjectNumber,
                'Subject' => $project->Subject,
                'ProjectStatus' => $project->ProjectStatus,
                'ScholarId' => $project->ScholarId,
                'UnitId' => $project->UnitId,
                'GroupId' => $project->GroupId,
                'Supervisor' => $project->Supervisor,
                'SupervisorMobile' => $project->SupervisorMobile,
                'Advisor' => $project->Advisor,
                'AdvisorMobile' => $project->AdvisorMobile,
                'Referee1' => $project->Referee1,
                'Referee2' => $project->Referee1,
                'Editor' => $project->Editor,
                'CreateDate' => $project->CreateDate,
                'PersianCreateDate' => $project->PersianCreateDate,
                'TenPercentLetterDate' => $project->TenPercentLetterDate,
                'PreImploymentLetterDate' => $project->PreImploymentLetterDate,
                'ImploymentDate' => $project->ImploymentDate,
                'SecurityLetterDate' => $project->SecurityLetterDate,
                'ThesisDefenceDate' => $project->ThesisDefenceDate,
                'ThesisDefenceLetterDate' => $project->ThesisDefenceLetterDate,
                'ReducePeriod' => $project->ReducePeriod,
                'Commision' => $project->Commision,
                'HasBookPublish' => boolval($project->HasBookPublish),
                'UserId' => $project->UserId,//,
                'TitleApproved' => boolval($project->TitleApproved),
                'ThirtyPercentLetterDate' => $project->ThirtyPercentLetterDate,
                'SixtyPercentLetterDate' => $project->SixtyPercentLetterDate,
                'ATFLetterDate' => $project->ATFLetterDate,
                'FinalApprove' => boolval($project->FinalApprove),
                'IsConfident' => boolval($project->IsConfident),
                'IsDisabled' => boolval($project->IsDisabled)
            ]
            );
            return true;
    }
    public function AddProject(Projects $project)
    {
        return $project->save();
    }
}

class ProjectRepositoryFactory
{
    public static function GetProjectRepositoryObj():IProjectRepository
    {
        return new ProjectRepository(new Projects());
    }

}
