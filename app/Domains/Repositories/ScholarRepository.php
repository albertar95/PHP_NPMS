<?php

namespace App\Domains\Repositories;

use App\Domains\Eloquent\BaseRepository;
use App\Domains\Interfaces\IScholarRepository;
use App\DTOs\DataMapper;
use App\DTOs\majorDTO;
use App\DTOs\projectDTO;
use App\DTOs\scholarDetailDTO;
use App\DTOs\scholarDTO;
use App\DTOs\scholarListDTO;
use App\Models\Majors;
use App\Models\Oreintations;
use App\Models\Projects;
use App\Models\Scholars;
use App\Models\Settings;
use App\Models\Units;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\Boolean;

class ScholarRepository extends BaseRepository implements IScholarRepository{
    public function __construct(Scholars $model)
    {
        parent::__construct($model);
    }
    public function GetGrades(int $Pagesize = 10,bool $IncludeDeleted = false):Collection
    {
        if($IncludeDeleted == false)
        {
            if ($Pagesize != 0)
                return Settings::all()->where('SettingKey','=','GradeId')->where('IsDeleted','=',false)->take($Pagesize);
            else
                return Settings::all()->where('SettingKey','=','GradeId')->where('IsDeleted','=',false);
        }
        else
        {
            if ($Pagesize != 0)
                return Settings::all()->where('SettingKey','=','GradeId')->take($Pagesize);
            else
                return Settings::all()->where('SettingKey','=','GradeId');
        }
        // return Settings::all();
    }
    public function GetColleges(int $Pagesize = 10, bool $IncludeDeleted = false):Collection
    {
        if(!$IncludeDeleted)
        {
            if ($Pagesize != 0)
                return Settings::all()->where('SettingKey','=','College')->where('IsDeleted','=',false)->take($Pagesize);
            else
                return Settings::all()->where('SettingKey','=','College')->where('IsDeleted','=',false);
        }
        else
        {
            if ($Pagesize != 0)
                return Settings::all()->where('SettingKey','=','College')->take($Pagesize);
            else
                return Settings::all()->where('SettingKey','=','College');
        }
    }
    public function GetCollaborationTypes(int $Pagesize = 10, bool $IncludeDeleted = false) :Collection
    {
        if(!$IncludeDeleted)
        {
            if ($Pagesize != 0)
                return Settings::all()->where('SettingKey','=','CollaborationType')->where('IsDeleted','=',false)->take($Pagesize);
            else
                return Settings::all()->where('SettingKey','=','CollaborationType')->where('IsDeleted','=',false);
        }
        else
        {
            if ($Pagesize != 0)
                return Settings::all()->where('SettingKey','=','CollaborationType')->take($Pagesize);
            else
                return Settings::all()->where('SettingKey','=','CollaborationType');
        }
    }
    public function GetMillitaryStatuses(int $Pagesize = 10, bool $IncludeDeleted = false):Collection
    {
        if(!$IncludeDeleted)
        {
            if ($Pagesize != 0)
                return Settings::all()->where('SettingKey','=','MillitaryStatus')->where('IsDeleted','=',false)->take($Pagesize);
            else
                return Settings::all()->where('SettingKey','=','MillitaryStatus')->where('IsDeleted','=',false);
        }
        else
        {
            if ($Pagesize != 0)
                return Settings::all()->where('SettingKey','=','MillitaryStatus')->take($Pagesize);
            else
                return Settings::all()->where('SettingKey','=','MillitaryStatus');
        }
    }
    public function GetMajors(int $Pagesize = 10):Collection
    {
        $result = new Collection();
        if($Pagesize != 0)
        {
            $tmpMajor = Majors::all()->take($Pagesize);
            foreach ($tmpMajor as $major)
            {
                $result->push(DataMapper::MapToMajorDTO($major));
            }
        }
        else
        {
            $tmpMajor = Majors::all();
            foreach ($tmpMajor as $major)
            {
                $result->push(DataMapper::MapToMajorDTO($major));
            }
        }
        return $result;
    }
    public function GetOreintations(int $Pagesize = 10):Collection
    {
        $result = new Collection();
        if($Pagesize != 0)
        {
            $tmpOrientation = Oreintations::all()->take($Pagesize);
            foreach ($tmpOrientation as $orientation)
            {
                $result->push(DataMapper::MapToOreintationDTO($orientation));
            }
        }
        else
        {
            $tmpOrientation = Oreintations::all();
            foreach ($tmpOrientation as $orientation)
            {
                $result->push(DataMapper::MapToOreintationDTO($orientation));
            }
        }
        return $result;
    }
    public function GetOreintationByMajorId(string $MajorId, int $Pagesize = 10)
    {
        $result = new Collection();
        $tmpOrientation = Oreintations::all()->where('MajorId','=',$MajorId)->take($Pagesize);
        foreach ($tmpOrientation as $orien)
        {
            $result->push(DataMapper::MapToOreintationDTO($orien));
        }
        return $result;
    }
    public function GetScholarDTOById(string $ScholarId):scholarDTO
    {
        return DataMapper::MapToScholarDTO(Scholars::all()->where('NidScholar','=',$ScholarId)->where('IsDeleted','=',false)->firstOrFail());
    }
    public function GetScholarById(string $ScholarId):Scholars
    {
        return Scholars::all()->where('NidScholar','=',$ScholarId)->where('IsDeleted','=',false)->firstOrFail();
    }
    public function GetScholars(int $Pagesize = 10):Collection
    {
        $result = new Collection();
        if($Pagesize != 0)
        {
            $tmpScholars = Scholars::all()->where('IsDeleted','=',false)->take($Pagesize);
            foreach ($tmpScholars as $Scholar)
            {
                $result->push(DataMapper::MapToScholarDTO($Scholar));
            }
        }
        else
        {
            $tmpScholars = Scholars::all()->where('IsDeleted','=',false);
            foreach ($tmpScholars as $Scholar)
            {
                $result->push(DataMapper::MapToScholarDTO($Scholar));
            }
        }
        return $result;
    }
    public function GetScholarList(int $Pagesize = 10) :Collection
    {
        $result = new Collection();
        if ($Pagesize != 0)
        {
            $tmpScholars = Scholars::all()->where('IsDeleted','=',0)->take($Pagesize);
            foreach ($tmpScholars as $scholar)
            {
                $tmpScholarList = DataMapper::MapToScholarListDTO($scholar);
                try
                {
                    $tmpScholarList->Grade = ($this->GetGrades(0, true)->where('SettingValue','=',$scholar->GradeId)->firstOrFail()->SettingTitle)->get();
                    $tmpScholarList->collegeName = $this->GetColleges(0, true)->where('SettingValue','=',$scholar->college)->firstOrFail()->SettingTitle;
                    $tmpScholarList->MajorName = $this->GetMajors(0)->where('NidMajor','=',$scholar->MajorId)->firstOrFail()->Title;
                    $tmpScholarList->OreintationName = $this->GetOreintations(0)->where('NidOreintation','=',$scholar->OreintationId)->firstOrFail()->Title;
                }
                catch (\Exception)
                {
                }
                $result->push($tmpScholarList);
            }
        }
        else
        {
            $tmpScholars = Scholars::all()->where('IsDeleted','=',0);
            foreach ($tmpScholars as $scholar)
            {
                $tmpScholarList = DataMapper::MapToScholarListDTO($scholar);
                try
                {
                    $tmpScholarList->Grade = $this->GetGrades(0, true)->where('SettingValue','=',$scholar->GradeId)->firstOrFail()->SettingTitle;
                    $tmpScholarList->collegeName = $this->GetColleges(0, true)->where('SettingValue','=',$scholar->college)->firstOrFail()->SettingTitle;
                    $tmpScholarList->MajorName = $this->GetMajors(0)->where('NidMajor','=',$scholar->MajorId)->firstOrFail()->Title;
                    $tmpScholarList->OreintationName = $this->GetOreintations(0)->where('NidOreintation','=',$scholar->OreintationId)->firstOrFail()->Title;
                }
                catch (\Exception)
                {
                }
                $result->push($tmpScholarList);
            }
        }
        return $result;
    }
    public function GetScholarDetail(string $ScholarId):scholarDetailDTO
    {
        $scholar = Scholars::all()->where('NidScholar','=',$ScholarId)->firstOrFail();//->where('IsDeleted','=','0')
        // $scholar = Scholars::all()->firstOrFail();
        if(!is_null($scholar))
        {
            $tmpScholarDetail = DataMapper::MapToScholarDetailDTO($scholar);
            $tmpScholarDetail->GradeTitle = $this->GetGrades(0, true)->Where('SettingValue','=',$scholar->GradeId)->firstOrFail()->SettingTitle;
            $tmpScholarDetail->CollaborationTypeTitle = $this->GetCollaborationTypes(0, true)->Where('SettingValue','=',$scholar->CollaborationType)->firstOrFail()->SettingTitle;
            $tmpScholarDetail->MillitaryStatusTitle = $this->GetMillitaryStatuses(0, true)->Where('SettingValue','=',$scholar->MillitaryStatus)->firstOrFail()->SettingTitle;
            $tmpScholarDetail->CollegeTitle = $this->GetColleges(0, true)->Where('SettingValue','=',$scholar->college)->firstOrFail()->SettingTitle;

            $tmpScholarDetail->Major = $this->GetMajors(0)->where('NidMajor','=',$scholar->MajorId)->firstOrFail();
            $tmpScholarDetail->Oreintation = $this->GetOreintations(0)->where('NidOreintation','=',$scholar->OreintationId)->firstOrFail();
            $tmpScholarDetail->Projects = Projects::all()->where('ScholarId','=',$scholar->NidScholar);
            return $tmpScholarDetail;
        }
        else
        {
            return null;
        }
    }
    public function CheckProjectsOfScholar(string $ScholarId):int
    {
        return Projects::all()->where('ScholarId','=',$ScholarId)->count();
    }
    public function DeleteScholar(string $ScholarId):bool
    {
        Scholars::where('NidScholar',$ScholarId)->update(
            [
                'IsDeleted' => true,
                'DeleteDate' => Carbon::now(),
                'DeleteUser' => auth()->user()->NidUser
            ]
            );
            return true;
    }//tuple<bool,string>
    public function GetScholarListById(string $ScholarId,bool $IsDeleted = false):scholarListDTO
    {
        return DataMapper::MapToScholarListDTO(Scholars::all()->where('NidScholar','=',$ScholarId)->where('IsDeleted','=',$IsDeleted)->firstOrFail());
    }
    public function AddScholar(Scholars $Scholar):bool
    {
        $Scholar->IsDeleted = false;
        $Scholar->save();
        return true;
    }
    public function UpdateScholar(Scholars $Scholar):bool
    {
        if(empty($Scholar->DeleteDate))
        {
            $Scholar->DeleteDate = null;
        }
        $current = Scholars::where('NidScholar',$Scholar->NidScholar)->update(
            [
                'FirstName' => $Scholar->FirstName,
                'LastName' => $Scholar->LastName,
                'NationalCode' => $Scholar->NationalCode,
                'BirthDate' => $Scholar->BirthDate,
                'FatherName' => $Scholar->FatherName,
                'Mobile' => $Scholar->Mobile,
                'MillitaryStatus' => $Scholar->MillitaryStatus,
                'GradeId' => $Scholar->GradeId,
                'MajorId' => $Scholar->MajorId,
                'OreintationId' => $Scholar->OreintationId,
                'college' => $Scholar->college,
                'CollaborationType' => $Scholar->CollaborationType,
                'ProfilePicture' => $Scholar->ProfilePicture,
                'UserId' => $Scholar->UserId,
                'IsDeleted' => $Scholar->IsDeleted ?? boolval(false),
                'DeleteDate' => $Scholar->DeleteDate,
                'DeleteUser' => $Scholar->DeleteUser,
                'IsConfident' => $Scholar->IsConfident ?? 0,
            ]
            );
        return true;
    }
}

class ScholarRepositoryFactory
{
    public static function GetScholarRepositoryObj():IScholarRepository
    {
        return new ScholarRepository(new Scholars());
    }

}
