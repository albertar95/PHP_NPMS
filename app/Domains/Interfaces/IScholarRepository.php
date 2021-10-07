<?php
namespace App\Domains\Interfaces;

use App\DTOs\scholarDetailDTO;
use App\DTOs\scholarDTO;
use App\DTOs\scholarListDTO;
use App\Models\Scholars;
use Illuminate\Support\Collection;

interface IScholarRepository
{
    public function GetGrades(int $Pagesize = 10,bool $IncludeDeleted = false):Collection;
    public function GetColleges(int $Pagesize = 10, bool $IncludeDeleted = false):Collection;
    public function GetCollaborationTypes(int $Pagesize = 10, bool $IncludeDeleted = false) :Collection;
    public function GetMillitaryStatuses(int $Pagesize = 10, bool $IncludeDeleted = false):Collection;
    public function GetMajors(int $Pagesize = 10):Collection;
    public function GetOreintations(int $Pagesize = 10):Collection;
    public function GetOreintationByMajorId(string $MajorId, int $Pagesize = 10) :Collection;
    public function GetScholarDTOById(string $ScholarId):scholarDTO;
    public function GetScholarById(string $ScholarId):Scholars;
    public function GetScholars(int $Pagesize = 10):Collection;
    public function GetScholarList(int $Pagesize = 10) :Collection;
    public function GetScholarDetail(string $ScholarId):scholarDetailDTO;
    public function CheckProjectsOfScholar(string $ScholarId):int;
    public function DeleteScholar(string $ScholarId):bool;//tuple<bool,string>
    public function GetScholarListById(string $ScholarId,bool $IsDeleted = false):scholarListDTO;
    public function AddScholar(Scholars $Scholar):bool;
    public function UpdateScholar(Scholars $Scholar):bool;
}
