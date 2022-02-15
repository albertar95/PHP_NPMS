<?php
namespace App\Domains\Interfaces;

use App\DTOs\projectDetailDTO;
use App\DTOs\projectDTO;
use App\DTOs\projectInitialDTO;
use App\Models\Majors;
use App\Models\Oreintations;
use App\Models\Projects;
use App\Models\Settings;
use App\Models\UnitGroups;
use App\Models\Units;
use Brick\Math\BigInteger;
use Illuminate\Support\Collection;

interface IProjectRepository
{
    public function GetProjectInitials(int $pagesize = 100,int $skip = 0);
    public function AddProjectInitial(projectInitialDTO $projectInitial):bool;
    public function ProjectProgress(Projects $project) :bool;
    public function GetProjectDTOById(string $NidProject):projectDTO;
    public function GetProjectDetailDTOById(string $NidProject):projectDetailDTO;
    public function GetUnits(int $pagesize = 100):Collection;
    public function GetUnitGroups(int $pagesize = 100) :Collection;
    public function GetProjectScholars(int $pagesize = 100):Collection;
    public function GetProjectById(string $NidProject):Projects;
    public function GenerateProjectNumber():BigInteger;
    public function CheckForUnitGroupExist(string $NidUnit) :bool;
    public function CheckForOreintationExist(string $NidMajor):bool;
    public function GetUnitById(string $NidUnit):Units;
    public function GetUnitGroupById(string $NidUnitGroup):UnitGroups;
    public function GetMajorById(string $NidMajor) :Majors;
    public function GetOreintationById(string $NidOreintation):Oreintations;
    public function GetSettingById(string $NidSetting):Settings;
    public function GenerateSettingId(int $Type):int;
    public function ProjectStatusCalc(Projects $project) :int;
    public function AddUnit(Units $unit);
    public function UpdateUnit(Units $unit);
    public function DeleteUnit(Units $unit);
    public function AddUnitGroup(UnitGroups $unitgroup);
    public function UpdateUnitGroup(UnitGroups $unitgroup);
    public function DeleteUnitGroup(UnitGroups $unitgroup);
    public function AddMajor(Majors $major);
    public function UpdateMajor(Majors $major);
    public function DeleteMajor(Majors $major);
    public function AddOreintation(Oreintations $oreintation);
    public function UpdateOreintation(Oreintations $oreintation);
    public function DeleteOreintation(Oreintations $oreintation);
    public function AddSetting(Settings $setting);
    public function UpdateSetting(Settings $setting);
    public function DeleteSetting(Settings $setting);
    public function UpdateProject(Projects $project);
    public function AddProject(Projects $project);
}
