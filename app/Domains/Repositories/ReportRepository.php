<?php

namespace App\Domains\Repositories;

use App\Domains\Eloquent\BaseRepository;
use App\Domains\Interfaces\IReportRepository;
use App\Domains\Interfaces\ISearchRepository;
use App\DTOs\DataMapper;
use App\DTOs\reportDTO;
use App\DTOs\reportParameterDTO;
use App\Helpers\Casts;
use App\Models\Projects;
use App\Models\ReportParameters;
use App\Models\Reports;
use App\Models\Scholars;
use App\Models\User;
use Guzzle\Service\Resource\Model;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReportRepository extends BaseRepository implements IReportRepository
{
    public function __construct(Reports $model)
    {
        parent::__construct($model);
    }
    public function AddReport(Reports $report): bool
    {
        $report->save();
        return true;
    }
    public function AddReportParameterList(Collection $parameters): bool
    {
        foreach ($parameters as $par) {
            $par->save();
        }
        return true;
    }
    public function GetReport(string $NidReport): reportDTO
    {
        return DataMapper::MapToReportDTO($this->model->all()->where('NidReport', '=', $NidReport)->firstOrFail());
    }
    public function GetReportsInput(string $NidReport): Collection
    {
        $inputs = new Collection();
        $tmpParameters = ReportParameters::all()->where('IsDeleted', '=', false)->where('Type', '=', 0)->where('ReportId', '=', $NidReport);
        foreach ($tmpParameters as $parameter) {
            $inputs->push(DataMapper::MapToReportParameterDTO($parameter));
        }
        return $inputs;
    }
    public function GetReportsOutput(string $NidReport): Collection
    {
        $outputs = new Collection();
        $parameters = ReportParameters::all()->where('IsDeleted', '=', false)->where('Type', '=', 1)->where('ReportId', '=', $NidReport);
        foreach ($parameters as $outp) {
            $outputs->push(DataMapper::MapToReportParameterDTO($outp));
        }
        return $outputs;
    }
    public function GetStatisticsReports(): Collection
    {
        $result = new Collection();
        $tmpReports = $this->model->all();
        foreach ($tmpReports as $rep) {
            $result->push(DataMapper::MapToReportDTO($rep));
        }
        return $result;
    }
    public function DeleteReport(string $NidReport): bool
    {
        $report = $this->model->all()->where('NidReport', '=', $NidReport)->firstOrFail();
        if (!is_null($report)) {
            $report->delete();
            return true;
        } else
            return false;
    }
    public function DeleteReportParametersByNidReport(string $NidReport): bool
    {
        $reportParameters = ReportParameters::all()->where('ReportId', '=', $NidReport);
        foreach ($reportParameters as $rp) {
            ReportParameters::all()->where('NidParameter', '=', $rp->NidParameter)->firstOrFail()->delete();
        }
        return true;
    }
    public function StatisticsReport(string $NidReport, array $paramsKey, array $paramsValue, bool $showConfidents)
    {
        $CurrentReport = Reports::all()->where('NidReport', '=', $NidReport)->firstOrFail();
        return $this->ExecuteReport(1, $this->QueryBuilder($showConfidents, $paramsKey, $paramsValue, $CurrentReport), $CurrentReport);
        // return $paramsValue;
    }
    public function PersianDateToGeorgian(string $Datee)
    {
        return Verta::getGregorian(intval(Casts::PersianToEnglishDigits(substr($Datee, 0, 8))), intval(Casts::PersianToEnglishDigits(substr(substr($Datee, 0, 13), -4))), intval(Casts::PersianToEnglishDigits(substr($Datee, -4))));
    }
    private function QueryBuilder(bool $showConfident, array $paramsKey, array $paramsValue, Reports $CurrentReport)
    {
        $query = "select ";
        // $query = Str::of($query)->append('* ');
        switch ($CurrentReport->ContextId) {
            case 1: //scholar
                $query = Str::of($query)->append('NidScholar from scholars ');
                break;
            case 2: //project
                $query = Str::of($query)->append('NidProject from projects ');
                break;
            case 4: //user
                $query = Str::of($query)->append('NidUser from user ');
                break;
        }
        if (!$showConfident && ($CurrentReport->ContextId == 1 || $CurrentReport->ContextId == 2))
            $query = Str::of($query)->append('where IsConfident = false and ');
        else
            $query = Str::of($query)->append('where ');
        $PersianDateFileds = ["BirthDate", "TenPercentLetterDate", "PreImploymentLetterDate", "ImploymentDate", "SecurityLetterDate", "ThesisDefenceDate", "ThesisDefenceLetterDate", "ThirtyPercentLetterDate", "SixtyPercentLetterDate", "ATFLetterDate"];
        $tmpConstaintAdd = false;
        for ($i = 0; $i < count($paramsKey); $i++) {
            if (!empty($paramsValue[$i])) {
                if ($paramsKey[$i] == "LastLoginDate") {
                    if ($tmpConstaintAdd) {
                        $query = Str::of($query)->append(' and ');
                        $tmpConstaintAdd = false;
                    }
                    $query = Str::of($query)->append('left(');
                    $query = Str::of($query)->append($paramsKey[$i]);
                    $query = Str::of($query)->append(',10)');
                    $query = Str::of($query)->append(' = ');
                    $query = Str::of($query)->append("'");
                    $tmpdateConvert = $this->PersianDateToGeorgian($paramsValue[$i])[0] . '-' . sprintf("%02d", $this->PersianDateToGeorgian($paramsValue[$i])[1]) . '-' . sprintf("%02d", $this->PersianDateToGeorgian($paramsValue[$i])[2]);
                    $query = Str::of($query)->append($tmpdateConvert);
                    $query = Str::of($query)->append("'");
                    $tmpConstaintAdd = true;
                } else {
                    if ($paramsKey[$i] == "PersianCreateDate") {
                        if ($tmpConstaintAdd) {
                            $query = Str::of($query)->append(' and ');
                            $tmpConstaintAdd = false;
                        }
                        $query = Str::of($query)->append('left(');
                        $query = Str::of($query)->append($paramsKey[$i]);
                        $query = Str::of($query)->append(',10)');
                        $query = Str::of($query)->append(' = ');
                        $query = Str::of($query)->append("N'");
                        $query = Str::of($query)->append(str_replace('/', '-', Casts::EnglishToPersianDigits($paramsValue[$i])));
                        $query = Str::of($query)->append("'");
                        $tmpConstaintAdd = true;
                    } else {
                        if (!(in_array($paramsKey[$i], $PersianDateFileds))) {
                            if ($paramsKey[$i] == "Referee") {
                                if ($tmpConstaintAdd) {
                                    $query = Str::of($query)->append(' and ');
                                    $tmpConstaintAdd = false;
                                }
                                $query = Str::of($query)->append('(');
                                $query = Str::of($query)->append('Referee1');
                                $query = Str::of($query)->append(' = ');
                                $query = Str::of($query)->append("'");
                                $query = Str::of($query)->append($paramsValue[$i]);
                                $query = Str::of($query)->append("'");
                                $query = Str::of($query)->append(" or ");
                                $query = Str::of($query)->append('Referee2');
                                $query = Str::of($query)->append(' = ');
                                $query = Str::of($query)->append("'");
                                $query = Str::of($query)->append($paramsValue[$i]);
                                $query = Str::of($query)->append("'");
                                $query = Str::of($query)->append(')');
                                $tmpConstaintAdd = true;
                            } else {
                                if ($tmpConstaintAdd) {
                                    $query = Str::of($query)->append(' and ');
                                    $tmpConstaintAdd = false;
                                }
                                $query = Str::of($query)->append($paramsKey[$i]);
                                $query = Str::of($query)->append(' = ');
                                $query = Str::of($query)->append("'");
                                $query = Str::of($query)->append($paramsValue[$i]);
                                $query = Str::of($query)->append("'");
                                $tmpConstaintAdd = true;
                            }
                        } else {
                            if ($tmpConstaintAdd) {
                                $query = Str::of($query)->append(' and ');
                                $tmpConstaintAdd = false;
                            }
                            $query = Str::of($query)->append($paramsKey[$i]);
                            $query = Str::of($query)->append(' >= ');
                            $query = Str::of($query)->append("N'");
                            $query = Str::of($query)->append(Casts::EnglishToPersianDigits($paramsValue[$i]));
                            $query = Str::of($query)->append("'");
                            $tmpConstaintAdd = true;
                        }
                    }
                }
            } else {
                if ($paramsValue[$i] == "0") {
                    if ($tmpConstaintAdd) {
                        $query = Str::of($query)->append(' and ');
                        $tmpConstaintAdd = false;
                    }
                    $query = Str::of($query)->append($paramsKey[$i]);
                    $query = Str::of($query)->append(' = ');
                    $query = Str::of($query)->append("'");
                    $query = Str::of($query)->append($paramsValue[$i]);
                    $query = Str::of($query)->append("'");
                    $tmpConstaintAdd = true;
                }
            }
        }
        switch ($CurrentReport->ContextId) {
            case 1: //scholar
                $query = Str::of($query)->append(' group by NidScholar');
                break;
            case 2: //project
                $query = Str::of($query)->append(' group by NidProject');
                break;
            case 4: //user
                $query = Str::of($query)->append(' group by NidUser');
                break;
        }
        return $query;

        // return "select * from scholars";
    }
    private function ResultBuilder(int $EntityId, string $whereStatement)
    {
        switch ($EntityId) {
            case 1:
                return collect(DB::select("select FirstName,LastName,NationalCode,BirthDate,FatherName,Mobile,IsSecurityApproved,SecurityApproveDate,t2.SettingTitle as GradeTitle,t3.SettingTitle as CollegeTitle,t4.SettingTitle as CollaborationTypeTitle,t5.SettingTitle as MillitaryStatusTitle,t6.Title as MajorTitle,t7.Title as OreintationTitle from scholars t1 join settings t2 on t1.GradeId = t2.SettingValue and t2.SettingKey = 'GradeId' join settings t3 on t1.college = t3.SettingValue and t3.SettingKey = 'College' join settings t4 on t1.CollaborationType = t4.SettingValue and t4.SettingKey = 'CollaborationType' join settings t5 on t1.MillitaryStatus = t5.SettingValue and t5.SettingKey = 'MillitaryStatus' join majors t6 on t1.MajorId = t6.NidMajor join oreintations t7 on t1.OreintationId = t7.NidOreintation where NidScholar in " . '( ' . $whereStatement . ' )'));
                break;
            case 2:
                return collect(DB::select("select ProjectNumber,Subject,PersianCreateDate,Supervisor,Advisor,Referee1,Referee2,ProjectStatus,TenPercentLetterDate,PreImploymentLetterDate,ImploymentDate,SecurityLetterDate,ThirtyPercentLetterDate,SixtyPercentLetterDate,ATFLetterDate,ThesisDefenceDate,ThesisDefenceLetterDate,ReducePeriod,SupervisorMobile,AdvisorMobile,Editor,TitleApproved,HasBookPublish,FinalApprove,t1.IsConfident,concat(t2.FirstName,' ',t2.LastName) as ScholarTitle,t3.Title as UnitTitle,t4.Title as GroupTitle,concat(t5.FirstName,' ',t5.LastName) as UserTitle from projects t1 join scholars t2 on t1.ScholarId = t2.NidScholar join units t3 on t1.UnitId = t3.NidUnit join unit_groups t4 on t1.GroupId = t4.NidGroup join user t5 on t1.UserId = t5.NidUser where NidProject in " . '( ' . $whereStatement . ' )'));
                break;
            case 4:
                return collect(DB::select("select UserName,FirstName,LastName,ProfilePicture,IsLockedOut,IsDisabled,LastLoginDate,IncorrectPasswordCount,t2.Title as RoleTitle FROM user t1 JOIN roles t2 on t1.RoleId = t2.NidRole where NidUser in " . '( ' . $whereStatement . ' )'));
                break;
            default:
                # code...
                break;
        }
    }
    private function ExecuteReport(int $type, string $query, Reports $CurrentReport)
    {
        $result = new ReportResultData();
        $result->ReportName = $CurrentReport->ReportName;
        $result->Scholars = new Collection();
        $result->Projects = new Collection();
        $result->Users = new Collection();
        switch ($type) {
            case 1: //statistics
                switch ($CurrentReport->ContextId) {
                    case 1:
                        $result->Scholars = $this->ResultBuilder(1, $query);
                        break;
                    case 2:
                        $result->Projects = $this->ResultBuilder(2, $query);
                        break;
                    case 4:
                        $result->Users = $this->ResultBuilder(4, $query);
                        break;
                }
                break;
        }
        return $result;
    }
}
class ReportRawData
{
    public string $NidReport;
    public array $paramsKey;
    public array $paramsValue;
}
class ReportResultData
{
    public string $ReportName;
    public Collection $Scholars; //scholardetaildto
    public Collection $Projects; //scholardetaildto
    public Collection $Users; //scholardetaildto
    public array $OutputKey;
}
class ReportRepositoryFactory
{
    public static function GetReportRepositoryObj(): IReportRepository
    {
        return new ReportRepository(new Reports());
    }
}
