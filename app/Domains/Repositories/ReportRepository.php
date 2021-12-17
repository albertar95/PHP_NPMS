<?php

namespace App\Domains\Repositories;

use App\Domains\Eloquent\BaseRepository;
use App\Domains\Interfaces\IReportRepository;
use App\Domains\Interfaces\ISearchRepository;
use App\DTOs\DataMapper;
use App\DTOs\reportDTO;
use App\DTOs\reportParameterDTO;
use App\Helpers\Casts;
use App\Models\ReportParameters;
use App\Models\Reports;
use App\Models\Scholars;
use Guzzle\Service\Resource\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReportRepository extends BaseRepository implements IReportRepository{
    public function __construct(Reports $model)
    {
        parent::__construct($model);
    }
    public function AddReport(Reports $report):bool
    {
        $report->save();
        return true;
    }
    public function AddReportParameterList(Collection $parameters) :bool
    {
        foreach ($parameters as $par)
        {
            $par->save();
        }
        return true;
    }
    public function GetReport(string $NidReport):reportDTO
    {
        return DataMapper::MapToReportDTO($this->model->all()->where('NidReport','=',$NidReport)->firstOrFail());
    }
    public function GetReportsInput(string $NidReport):Collection
    {
        $inputs = new Collection();
        $tmpParameters = ReportParameters::all()->where('IsDeleted','=',false)->where('Type','=',0)->where('ReportId','=',$NidReport);
        foreach ($tmpParameters as $parameter)
        {
            $inputs->push(DataMapper::MapToReportParameterDTO($parameter));
        }
        return $inputs;
    }
    public function GetReportsOutput(string $NidReport):Collection
    {
        $outputs = new Collection();
        $parameters = ReportParameters::all()->where('IsDeleted','=',false)->where('Type','=',1)->where('ReportId','=',$NidReport);
        foreach ($parameters as $outp)
        {
            $outputs->push(DataMapper::MapToReportParameterDTO($outp));
        }
        return $outputs;
    }
    public function GetStatisticsReports() :Collection
    {
        $result = new Collection();
        $tmpReports = $this->model->all();
        foreach ($tmpReports as $rep)
        {
            $result->push(DataMapper::MapToReportDTO($rep));
        }
        return $result;
    }
    public function DeleteReport(string $NidReport):bool
    {
        $report = $this->model->all()->where('NidReport','=',$NidReport)->firstOrFail();
        if (!is_null($report))
        {
            $report->delete();
            return true;
        }
        else
            return false;
    }
    public function DeleteReportParametersByNidReport(string $NidReport):bool
    {
        $reportParameters = ReportParameters::all()->where('ReportId','=',$NidReport);
        foreach ($reportParameters as $rp)
        {
            ReportParameters::all()->where('NidParameter','=',$rp->NidParameter)->firstOrFail()->delete();
        }
        return true;
    }
    public function StatisticsReport(string $NidReport,array $paramsKey,array $paramsValue):ReportResultData
    {
        $CurrentReport = Reports::all()->where('NidReport','=',$NidReport)->firstOrFail();
        return $this->ExecuteReport(1, $this->QueryBuilder($NidReport,$paramsKey,$paramsValue,$CurrentReport),$CurrentReport);
        // return $CurrentReport;
    }
    private function QueryBuilder(string $NidReport,array $paramsKey,array $paramsValue,Reports $CurrentReport)
    {
        $query = "select ";
        // $Outputs = ReportParameters::all()->where('ReportId','=',$NidReport)->where('Type','=',1);//  p.IsDeleted == false).ToList();
        //query += string.Join(",", Outputs.Select(p => p.ParameterKey).ToList());
        $query = Str::of($query)->append('* ');
        switch ($CurrentReport->ContextId)
        {
            case 1://scholar
                $query = Str::of($query)->append('from scholars ');
                break;
        }
        $query = Str::of($query)->append('where ');
        // $Inputs = ReportParameters::all()->where('ReportId','=',$CurrentReport->NidReport)->where('Type','=',0);//p.IsDeleted == false);
        for ($i=0; $i < count($paramsKey); $i++) {
            if ($i > 0)
            $query = Str::of($query)->append(' and ');
        if (!($paramsKey[$i] == "BirthDate"))
        {
            $query = Str::of($query)->append($paramsKey[$i]);
            $query = Str::of($query)->append(' = ');
            $query = Str::of($query)->append("'");
            $query = Str::of($query)->append($paramsValue[$i]);
            $query = Str::of($query)->append("'");
        }
        else
        {
            $query = Str::of($query)->append($paramsKey[$i]);
            $query = Str::of($query)->append(' = ');
            $query = Str::of($query)->append("N'");
            $query = Str::of($query)->append(Casts::EnglishToPersianDigits($paramsValue[$i]));
            $query = Str::of($query)->append("'");
        }
        }
        return $query;

        // return "select * from scholars";
    }
    private function ExecuteReport(int $type,string $query,Reports $CurrentReport)
    {
        $result = new ReportResultData();
        $result->ReportName = $CurrentReport->ReportName;
        switch ($type)
        {
            case 1://statistics
                switch ($CurrentReport->ContextId)
                {
                    case 1:
                        $schs = new Collection();//ScholarDetailDTO
                        $sr = new ScholarRepository(new Scholars());
                        $Nidschs = DB::select($query);// .SqlQuery(query).Select(q => q.NidScholar).ToList();
                        foreach ($Nidschs as $sch )
                        {
                            $detail = $sr->GetScholarDetail($sch->NidScholar);
                            if(!is_null($detail))
                            $schs->push($detail);
                        }
                        $result->Scholars = $schs;
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
    public Collection $Scholars;//scholardetaildto
    public array $OutputKey;
}
class ReportRepositoryFactory
{
    public static function GetReportRepositoryObj():IReportRepository
    {
        return new ReportRepository(new Reports());
    }

}
