<?php

namespace App\Domains\Repositories;

use App\Domains\Eloquent\BaseRepository;
use App\Domains\Interfaces\IReportRepository;
use App\Domains\Interfaces\ISearchRepository;
use App\DTOs\DataMapper;
use App\DTOs\reportDTO;
use App\Models\ReportParameters;
use App\Models\Reports;
use Illuminate\Support\Collection;


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
    public function StatisticsReport(ReportRawData $Report):ReportResultData
    {
        // CurrentReport = db.Reports.Where(p => p.NidReport == Report.NidReport).FirstOrDefault();
        // return ExecuteReport(1, QueryBuilder(Report));
        return new ReportResultData();
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
