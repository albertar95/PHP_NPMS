<?php
namespace App\Domains\Interfaces;

use App\Domains\Repositories\ReportRawData;
use App\Domains\Repositories\ReportResultData;
use App\DTOs\reportDTO;
use App\Models\Reports;
use Illuminate\Support\Collection;

interface IReportRepository
{
    public function StatisticsReport(string $NidReport,array $paramsKey,array $paramsValue,bool $showConfidents);
    public function AddReport(Reports $report):bool;
    public function AddReportParameterList(Collection $parameters) :bool;
    public function GetReport(string $NidReport):reportDTO;
    public function GetReportsInput(string $NidReport):Collection;
    public function GetReportsOutput(string $NidReport):Collection;
    public function GetStatisticsReports() :Collection;
    public function DeleteReport(string $NidReport):bool;
    public function DeleteReportParametersByNidReport(string $NidReport):bool;
}
