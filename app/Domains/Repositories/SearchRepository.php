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

class SearchRepository implements ISearchRepository
{
    public int $SectionId;
    public int $ById;
    public bool $Similar;
    public Collection $Scholars; //ScholarListDTO
    public Collection $Projects; //ProjectInitialDTO
    public Collection $Users; //UserDTO
    public Collection $BaseInfo; //Setting
    public function AdvancedSearchProcess(string $searchText, int $SectionId, int $Similar, int $ById)
    {
        $ProjectResult = new Collection();
        $ScholarResult = new Collection();
        $UserResult = new Collection();
        $BaseInfoResult = new Collection();
        switch ($SectionId) {
            case 0:
                $ScholarResult = $this->SearchInScholars($searchText, $Similar, $ById);
                $ProjectResult = $this->SearchInProjects($searchText, $Similar, $ById);
                $UserResult = $this->SearchInUsers($searchText, $Similar, $ById);
                $BaseInfoResult = $this->SearchInBaseInfo($searchText, $Similar, $ById);
                break;
            case 1:
                $ScholarResult = $this->SearchInScholars($searchText, $Similar, $ById);
                break;
            case 2:
                $ProjectResult = $this->SearchInProjects($searchText, $Similar, $ById);
                break;
            case 3:
                $UserResult = $this->SearchInUsers($searchText, $Similar, $ById);
                break;
            case 4:
                $BaseInfoResult = $this->SearchInBaseInfo($searchText, $Similar, $ById);
                break;
        }
        return [$ScholarResult, $ProjectResult, $UserResult, $BaseInfoResult];
        // return $this->SearchInUsers($searchText,$Similar,$ById);
    }
    public function ComplexSearch(string $searchText, bool $Similar, int $ById)
    {
        $ScholarResult = $this->SearchInScholars($searchText, $Similar, $ById);
        $ProjectResult = $this->SearchInProjects($searchText, $Similar, $ById);
        $UserResult = $this->SearchInUsers($searchText, $Similar, $ById);
        return [$ProjectResult, $ScholarResult, $UserResult];
    }
    private function QueryRepository(int $EntityId, string $searchText, bool $Similar, int $ById)
    {
        if ($Similar) {
            switch ($EntityId) {
                case 1:
                    switch ($ById) {
                        case 0:
                            return DB::select("select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE IsDeleted = false and t1.IsConfident = false and FirstName LIKE '%" . $searchText . "%'" . " UNION ALL select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE IsDeleted = false and t1.IsConfident = false and LastName LIKE '%" . $searchText . "%'" . " UNION ALL select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE IsDeleted = false and t1.IsConfident = false and NationalCode LIKE '%" . $searchText . "%'" . " UNION ALL select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE IsDeleted = false and t1.IsConfident = false and Mobile LIKE '%" . $searchText . "%'" . " UNION ALL select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation join settings t4 on t1.MillitaryStatus = t4.SettingValue and t4.SettingKey = 'MillitaryStatus' WHERE t1.IsDeleted = false and t1.IsConfident = false and t4.SettingTitle LIKE '%" . $searchText . "%'" . " UNION ALL select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation join settings t4 on t1.CollaborationType = t4.SettingValue and t4.SettingKey = 'CollaborationType' WHERE t1.IsDeleted = false and t1.IsConfident = false and t4.SettingTitle LIKE '%" . $searchText . "%'" . " UNION ALL select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE IsDeleted = false and t1.IsConfident = false and t2.Title LIKE '%" . $searchText . "%'" . " UNION ALL select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE IsDeleted = false and t1.IsConfident = false and t3.Title LIKE '%" . $searchText . "%'" . " UNION ALL select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation join settings t4 on t1.GradeId = t4.SettingValue and t4.SettingKey = 'GradeId' WHERE t1.IsDeleted = false and t1.IsConfident = false and t4.SettingTitle LIKE '%" . $searchText . "%'" . " UNION ALL select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation join settings t4 on t1.college = t4.SettingValue and t4.SettingKey = 'College' WHERE t1.IsDeleted = false and t1.IsConfident = false and t4.SettingTitle LIKE '%" . $searchText . "%'" . " UNION ALL select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE IsDeleted = false and t1.IsConfident = false and SecurityApproveDate LIKE '%" . $searchText . "%'");
                            break;
                        case 1:
                            return DB::select("select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE IsDeleted = false and t1.IsConfident = false and FirstName LIKE '%" . $searchText . "%' UNION ALL select NidScholar,FirstName,LastName,NationalCode,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE IsDeleted = false and LastName LIKE '%" . $searchText . "%'");
                            break;
                        case 2:
                            return DB::select("select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE IsDeleted = false and t1.IsConfident = false and NationalCode LIKE '%" . $searchText . "%'");
                            break;
                        case 3:
                            return DB::select("select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE IsDeleted = false and t1.IsConfident = false and Mobile LIKE '%" . $searchText . "%'");
                            break;
                        case 4:
                            return DB::select("select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation join settings t4 on t1.MillitaryStatus = t4.SettingValue and t4.SettingKey = 'MillitaryStatus' WHERE t1.IsDeleted = false and t1.IsConfident = false and t4.SettingTitle LIKE '%" . $searchText . "%'");
                            break;
                        case 5: //CollaborationType
                            return DB::select("select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation join settings t4 on t1.CollaborationType = t4.SettingValue and t4.SettingKey = 'CollaborationType' WHERE t1.IsDeleted = false and t1.IsConfident = false and t4.SettingTitle LIKE '%" . $searchText . "%'");
                            break;
                        case 6:
                            return DB::select("select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE IsDeleted = false and t1.IsConfident = false and t2.Title LIKE '%" . $searchText . "%'");
                            break;
                        case 7:
                            return DB::select("select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE IsDeleted = false and t1.IsConfident = false and t3.Title LIKE '%" . $searchText . "%'");
                            break;
                        case 8:
                            return DB::select("select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation join settings t4 on t1.GradeId = t4.SettingValue and t4.SettingKey = 'GradeId' WHERE t1.IsDeleted = false and t1.IsConfident = false and t4.SettingTitle LIKE '%" . $searchText . "%'");
                            break;
                        case 9:
                            return DB::select("select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation join settings t4 on t1.college = t4.SettingValue and t4.SettingKey = 'College' WHERE t1.IsDeleted = false and t1.IsConfident = false and t4.SettingTitle LIKE '%" . $searchText . "%'");
                            break;
                        case 10:
                            $searchText = Casts::EnglishToPersianDigits($searchText);
                            return DB::select("select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE IsDeleted = false and t1.IsConfident = false and SecurityApproveDate LIKE '%" . $searchText . "%'");
                            break;
                        default:
                            break;
                    }
                case 2:
                    switch ($ById) {
                        case 0:
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and Subject LIKE '%" . $searchText . "%'" . " UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and t2.Title LIKE '%" . $searchText . "%' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and t3.Title LIKE '%" . $searchText . "%' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and ProjectNumber LIKE '%" . $searchText . "%' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and t4.FirstName LIKE '%" . $searchText . "%'" . " UNION ALL select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and t4.LastName LIKE '%" . $searchText . "%' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and ImploymentDate LIKE '%" . $searchText . "%' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and TenPercentLetterDate LIKE '%" . $searchText . "%' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and PreImploymentLetterDate LIKE '%" . $searchText . "%' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and ThirtyPercentLetterDate LIKE '%" . $searchText . "%' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and SixtyPercentLetterDate LIKE '%" . $searchText . "%' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and Supervisor LIKE '%" . $searchText . "%' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and Advisor LIKE '%" . $searchText . "%' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and Referee1 LIKE '%" . $searchText . "%' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and Referee2 LIKE '%" . $searchText . "%' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and ThesisDefenceLetterDate LIKE '%" . $searchText . "%'");
                            break;
                        case 1:
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and Subject LIKE '%" . $searchText . "%'");
                            break;
                        case 2:
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and t2.Title LIKE '%" . $searchText . "%'");
                            break;
                        case 3:
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and t3.Title LIKE '%" . $searchText . "%'");
                            break;
                        case 4:
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and ProjectNumber LIKE '%" . $searchText . "%'");
                            break;
                        case 5: //CollaborationType
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and t4.FirstName LIKE '%" . $searchText . "%'" . "UNION ALL select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t4.LastName LIKE '%" . $searchText . "%'");
                            break;
                        case 6:
                            $searchText = Casts::EnglishToPersianDigits($searchText);
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and ImploymentDate LIKE '%" . $searchText . "%'");
                            break;
                        case 7:
                            $searchText = Casts::EnglishToPersianDigits($searchText);
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and TenPercentLetterDate LIKE '%" . $searchText . "%'");
                            break;
                        case 8:
                            $searchText = Casts::EnglishToPersianDigits($searchText);
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and PreImploymentLetterDate LIKE '%" . $searchText . "%'");
                            break;
                        case 9:
                            $searchText = Casts::EnglishToPersianDigits($searchText);
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and ThirtyPercentLetterDate LIKE '%" . $searchText . "%'");
                            break;
                        case 10:
                            $searchText = Casts::EnglishToPersianDigits($searchText);
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and SixtyPercentLetterDate LIKE '%" . $searchText . "%'");
                            break;
                        case 11:
                            // $searchText = Casts::EnglishToPersianDigits($searchText);
                            // return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE SecurityLetterDate LIKE '%" . $searchText . "%'");
                            break;
                        case 12:
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and Supervisor LIKE '%" . $searchText . "%'");
                            break;
                        case 13:
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and Advisor LIKE '%" . $searchText . "%'");
                            break;
                        case 14:
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and Referee1 LIKE '%" . $searchText . "%'");
                            break;
                        case 15:
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and Referee2 LIKE '%" . $searchText . "%'");
                            break;
                        case 16:
                            $searchText = Casts::EnglishToPersianDigits($searchText);
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and ThesisDefenceLetterDate LIKE '%" . $searchText . "%'");
                            break;
                        default:
                            break;
                    }
                    break;
                case 3:
                    switch ($ById) {
                        case 0:
                            return DB::select("select NidUser,UserName,FirstName,LastName,ProfilePicture,t2.IsAdmin from user t1 join roles t2 on t1.RoleId = t2.NidRole where UserName LIKE '%" . $searchText . "%' UNION ALL " . "select NidUser,UserName,FirstName,LastName,ProfilePicture,t2.IsAdmin from user t1 join roles t2 on t1.RoleId = t2.NidRole where FirstName LIKE '%" . $searchText . "%' UNION ALL " . "select NidUser,UserName,FirstName,LastName,ProfilePicture,t2.IsAdmin from user t1 join roles t2 on t1.RoleId = t2.NidRole where LastName LIKE '%" . $searchText . "%'");
                            break;
                        case 1:
                            return DB::select("select NidUser,UserName,FirstName,LastName,ProfilePicture,t2.IsAdmin from user t1 join roles t2 on t1.RoleId = t2.NidRole where UserName LIKE '%" . $searchText . "%'");
                            break;
                        case 2:
                            return DB::select("select NidUser,UserName,FirstName,LastName,ProfilePicture,t2.IsAdmin from user t1 join roles t2 on t1.RoleId = t2.NidRole where FirstName LIKE '%" . $searchText . "%' UNION ALL " . "select NidUser,UserName,FirstName,LastName,ProfilePicture,t2.IsAdmin from user t1 join roles t2 on t1.RoleId = t2.NidRole where LastName LIKE '%" . $searchText . "%'");
                            break;
                        default:
                            break;
                    }
                    break;
                case 4:
                    switch ($ById) {
                        case 0:
                            return DB::select("select SettingKey,SettingTitle from settings where SettingKey in ('CollaborationType','College','GradeId','MillitaryStatus') and IsDeleted = false and SettingTitle like '%" . $searchText . "%'");
                            break;
                        case 1:
                            return DB::select("select SettingKey,SettingTitle from settings where SettingKey in ('CollaborationType','College','GradeId','MillitaryStatus') and IsDeleted = false and SettingTitle like '%" . $searchText . "%'");
                            break;
                    }
                    break;
                default:
                    # code...
                    break;
            }
        } else {
            switch ($EntityId) {
                case 1:
                    switch ($ById) {
                        case 0:
                            return DB::select("select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE t1.IsConfident = false and IsDeleted = false and FirstName = '" . $searchText . "'" . " UNION ALL select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE t1.IsConfident = false and IsDeleted = false and LastName = '" . $searchText . "'" . " UNION ALL select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE t1.IsConfident = false and IsDeleted = false and NationalCode = '" . $searchText . "'" . " UNION ALL select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE t1.IsConfident = false and IsDeleted = false and Mobile = '" . $searchText . "'" . " UNION ALL select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation join settings t4 on t1.MillitaryStatus = t4.SettingValue and t4.SettingKey = 'MillitaryStatus' WHERE t1.IsConfident = false and t1.IsDeleted = false and t4.SettingTitle = '" . $searchText . "'" . " UNION ALL select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation join settings t4 on t1.CollaborationType = t4.SettingValue and t4.SettingKey = 'CollaborationType' WHERE t1.IsConfident = false and t1.IsDeleted = false and t4.SettingTitle = '" . $searchText . "'" . " UNION ALL select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE t1.IsConfident = false and IsDeleted = false and t2.Title = '" . $searchText . "'" . " UNION ALL select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE t1.IsConfident = false and IsDeleted = false and t3.Title = '" . $searchText . "'" . " UNION ALL select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation join settings t4 on t1.GradeId = t4.SettingValue and t4.SettingKey = 'GradeId' WHERE t1.IsConfident = false and t1.IsDeleted = false and t4.SettingTitle = '" . $searchText . "'" . " UNION ALL select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation join settings t4 on t1.college = t4.SettingValue and t4.SettingKey = 'College' WHERE t1.IsConfident = false and t1.IsDeleted = false and t4.SettingTitle = '" . $searchText . "'"." UNION ALL select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE t1.IsConfident = false and IsDeleted = false and SecurityApproveDate = '" . $searchText . "'");
                            break;
                        case 1:
                            return DB::select("select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE t1.IsConfident = false and IsDeleted = false and FirstName = '" . $searchText . "' UNION ALL select NidScholar,FirstName,LastName,NationalCode,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE IsDeleted = false and LastName = '" . $searchText . "'");
                            break;
                        case 2:
                            return DB::select("select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE t1.IsConfident = false and IsDeleted = false and NationalCode = '" . $searchText . "'");
                            break;
                        case 3:
                            return DB::select("select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE t1.IsConfident = false and IsDeleted = false and Mobile = '" . $searchText . "'");
                            break;
                        case 4:
                            return DB::select("select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation join settings t4 on t1.MillitaryStatus = t4.SettingValue and t4.SettingKey = 'MillitaryStatus' WHERE t1.IsConfident = false and t1.IsDeleted = false and t4.SettingTitle = '" . $searchText . "'");
                            break;
                        case 5: //CollaborationType
                            return DB::select("select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation join settings t4 on t1.CollaborationType = t4.SettingValue and t4.SettingKey = 'CollaborationType' WHERE t1.IsConfident = false and t1.IsDeleted = false and t4.SettingTitle = '" . $searchText . "'");
                            break;
                        case 6:
                            return DB::select("select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE t1.IsConfident = false and IsDeleted = false and t2.Title = '" . $searchText . "'");
                            break;
                        case 7:
                            return DB::select("select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE t1.IsConfident = false and IsDeleted = false and t3.Title = '" . $searchText . "'");
                            break;
                        case 8:
                            return DB::select("select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation join settings t4 on t1.GradeId = t4.SettingValue and t4.SettingKey = 'GradeId' WHERE t1.IsConfident = false and t1.IsDeleted = false and t4.SettingTitle = '" . $searchText . "'");
                            break;
                        case 9:
                            return DB::select("select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation join settings t4 on t1.college = t4.SettingValue and t4.SettingKey = 'College' WHERE t1.IsConfident = false and t1.IsDeleted = false and t4.SettingTitle = '" . $searchText . "'");
                            break;
                        case 10:
                            $searchText = Casts::EnglishToPersianDigits($searchText);
                            return DB::select("select NidScholar,FirstName,LastName,NationalCode,IsSecurityApproved,SecurityApproveDate,t2.Title as MajorName,t3.Title as OreintationName from scholars t1 join majors t2 on t1.MajorId = t2.NidMajor join oreintations t3 on t1.OreintationId = t3.NidOreintation WHERE t1.IsConfident = false and IsDeleted = false and SecurityApproveDate = '" . $searchText . "'");
                            break;
                        default:
                            break;
                    }
                    break;
                case 2:
                    switch ($ById) {
                        case 0:
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and Subject = '" . $searchText . "' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and t2.Title = '" . $searchText . "' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and t3.Title = '" . $searchText . "' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and ProjectNumber = '" . $searchText . "' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and t4.FirstName = '" . $searchText . "'" . " UNION ALL select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and t4.LastName = '" . $searchText . "' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and ImploymentDate = '" . $searchText . "' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and TenPercentLetterDate = '" . $searchText . "' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and PreImploymentLetterDate = '" . $searchText . "' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and ThirtyPercentLetterDate = '" . $searchText . "' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and SixtyPercentLetterDate = '" . $searchText . "' UNION ALL ". "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and Supervisor = '" . $searchText . "' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and Advisor = '" . $searchText . "' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and Referee1 = '" . $searchText . "' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and Referee2 = '" . $searchText . "' UNION ALL " . "select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and ThesisDefenceLetterDate = '" . $searchText . "'");
                            break;
                        case 1:
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and Subject = '" . $searchText . "'");
                            break;
                        case 2:
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and t2.Title = '" . $searchText . "'");
                            break;
                        case 3:
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and t3.Title = '" . $searchText . "'");
                            break;
                        case 4:
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and ProjectNumber = '" . $searchText . "'");
                            break;
                        case 5: //CollaborationType
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and t4.FirstName = '" . $searchText . "'" . "UNION ALL select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and t4.LastName = '" . $searchText . "'");
                            break;
                        case 6:
                            $searchText = Casts::EnglishToPersianDigits($searchText);
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and ImploymentDate = '" . $searchText . "'");
                            break;
                        case 7:
                            $searchText = Casts::EnglishToPersianDigits($searchText);
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and TenPercentLetterDate = '" . $searchText . "'");
                            break;
                        case 8:
                            $searchText = Casts::EnglishToPersianDigits($searchText);
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and PreImploymentLetterDate = '" . $searchText . "'");
                            break;
                        case 9:
                            $searchText = Casts::EnglishToPersianDigits($searchText);
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and ThirtyPercentLetterDate = '" . $searchText . "'");
                            break;
                        case 10:
                            $searchText = Casts::EnglishToPersianDigits($searchText);
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and SixtyPercentLetterDate = '" . $searchText . "'");
                            break;
                        case 11:
                            // $searchText = Casts::EnglishToPersianDigits($searchText);
                            // return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE SecurityLetterDate = '" . $searchText . "'");
                            break;
                        case 12:
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and Supervisor = '" . $searchText . "'");
                            break;
                        case 13:
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and Advisor = '" . $searchText . "'");
                            break;
                        case 14:
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and Referee1 = '" . $searchText . "'");
                            break;
                        case 15:
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and Referee2 = '" . $searchText . "'");
                            break;
                        case 16:
                            $searchText = Casts::EnglishToPersianDigits($searchText);
                            return DB::select("select NidProject,ProjectNumber,Subject,ProjectStatus,t2.Title as UnitName,t3.Title as GroupName,concat(t4.FirstName,' ',t4.LastName) as ScholarName FROM projects t1 join units t2 on t1.UnitId = t2.NidUnit join unit_groups t3 on t1.GroupId = t3.NidGroup join scholars t4 on t1.ScholarId = t4.NidScholar WHERE t1.IsDisabled = false and t1.IsConfident = false and ThesisDefenceLetterDate = '" . $searchText . "'");
                            break;
                        default:
                            break;
                        case 3:
                            switch ($ById) {
                                case 0:
                                    return DB::select("select NidUser,UserName,FirstName,LastName,ProfilePicture,t2.IsAdmin from user t1 join roles t2 on t1.RoleId = t2.NidRole where UserName = '" . $searchText . "' UNION ALL " . "select NidUser,UserName,FirstName,LastName,ProfilePicture,t2.IsAdmin from user t1 join roles t2 on t1.RoleId = t2.NidRole where FirstName = '" . $searchText . "' UNION ALL " . "select NidUser,UserName,FirstName,LastName,ProfilePicture,t2.IsAdmin from user t1 join roles t2 on t1.RoleId = t2.NidRole where LastName = '" . $searchText . "'");
                                    break;
                                case 1:
                                    return DB::select("select NidUser,UserName,FirstName,LastName,ProfilePicture,t2.IsAdmin from user t1 join roles t2 on t1.RoleId = t2.NidRole where UserName = '" . $searchText . "'");
                                    break;
                                case 2:
                                    return DB::select("select NidUser,UserName,FirstName,LastName,ProfilePicture,t2.IsAdmin from user t1 join roles t2 on t1.RoleId = t2.NidRole where FirstName = '" . $searchText . "' UNION ALL " . "select NidUser,UserName,FirstName,LastName,ProfilePicture,t2.IsAdmin from user t1 join roles t2 on t1.RoleId = t2.NidRole where LastName = '" . $searchText . "'");
                                    break;
                                default:
                                    break;
                            }
                            break;
                        case 4:
                            switch ($ById) {
                                case 0:
                                    return DB::select("select SettingKey,SettingTitle from settings where SettingKey in ('CollaborationType','College','GradeId','MillitaryStatus') and IsDeleted = false and SettingTitle = '" . $searchText . "'");
                                    break;
                                case 1:
                                    return DB::select("select SettingKey,SettingTitle from settings where SettingKey in ('CollaborationType','College','GradeId','MillitaryStatus') and IsDeleted = false and SettingTitle = '" . $searchText . "'");
                                    break;
                            }
                            break;
                    }
                    break;
                default:
                    # code...
                    break;
            }
        }
    }
    private function SearchInScholars(string $searchText, bool $Similar, int $ById): Collection //scholarlistdto
    {
        return collect($this->QueryRepository(1, $searchText, $Similar, $ById))->unique();
    }
    private function SearchInProjects(string $searchText, bool $Similar, int $ById): Collection //ProjectInitialDTO
    {
        return collect($this->QueryRepository(2, $searchText, $Similar, $ById))->unique();
    }
    private function SearchInUsers(string $searchText, bool $Similar, int $ById) //UserDTO
    {
        return collect($this->QueryRepository(3, $searchText, $Similar, $ById))->unique();
    }
    private function SearchInBaseInfo(string $searchText, bool $Similar, int $ById): Collection //Setting
    {
        return collect($this->QueryRepository(4, $searchText, $Similar, $ById))->unique();
    }
}

class SearchRepositoryFactory
{
    public static function GetSearchRepositoryObj(): ISearchRepository
    {
        return new SearchRepository();
    }
}
