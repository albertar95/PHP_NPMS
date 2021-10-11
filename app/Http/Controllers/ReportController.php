<?php

namespace App\Http\Controllers;

use App\Domains\Repositories\ReportRawData;
use App\Http\Controllers\Api\NPMSController;
use App\Models\ReportParameters;
use App\Models\Reports;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function StatisticReports()
    {
        $api = new NPMSController();
        $Report = $api->GetStatisticsReports();
        // $result = new JsonResults();
        // $result->HasValue = true;
        // $result->Html = view('User._UserDetail',compact('Users'))->render();
        // return response()->json($result);
        return view('Report.StatisticReports',compact('Report'));
    }
    public function ExecuteReport(string $NidReport)
    {
        $api = new NPMSController();
        $report = $api->GetReportById($NidReport);
        $inputs = $api->GetReportsInput($NidReport);
        $outputs = $api->GetReportsOutput($NidReport);
        return view('Report.ExecuteReport',compact('report','inputs','outputs'));
    }
    public function SubmitStatisticsReport(Request $report)//string $NidReport,array $PrameterKeys,array $ParameterValues,array $OutPutValues
    {
        $api = new NPMSController();
        $reportrawdata = new ReportRawData();
        $reportrawdata->NidReport = $report->NidReport;
        $reportrawdata->paramsKey = $report->PrameterKeys;
        $reportrawdata->paramsValue = $report->ParameterValues;
        $reportresult = $api->GetStatisticsReport($reportrawdata);
        $reportresult->OutputKey = $report->OutPutValues;
        $result = new JsonResults();
        $result->HasValue = true;
        $result->Html = view('User._ReportResult',compact('reportresult'))->render();
        return response()->json($result);
        // return view('Report.ExecuteReport',compact('report','inputs','outputs'));
    }
    public function ChartReports()
    {
        return view('Report.ChartReports');
    }
    public function CustomReports()
    {
        return view('Report.CustomReports');
    }
    public function CustomReportContextChanged(int $ContextId)
    {
        $result = new JsonResults();
        $result->HasValue = true;
        $result->Html = view('User._CustomReportPartial',compact('ContextId'))->render();
        return response()->json($result);
    }
    public function SubmitAddCustomReport(Request $report)//string $Name,int $ContextId,int $FieldId,array $Inputs,array $Outputs
    {
        $report = new Reports();
        $report->NidReport = Str::uuid();
        $report->ContextId = $report->ContextId;
        $report->FieldId = $report->FieldId;
        $report->ReportName = $report->Name;
        $api = new NPMSController();
        if($api->AddReport($report))
        {
            $inps = new Collection();
            foreach ($report->Inputs as $repInp) {
                $newIn = new ReportParameters();
                $newIn->IsDeleted = false;
                $newIn->NidParameter = Str::uuid();
                $newIn->ParameterKey = $repInp;
                $newIn->ReportId = $report->NidReport;
                $newIn->Type = 0;
            }
            $outs = new Collection();
            foreach ($report->Outputs as $repOut) {
                $newIn = new ReportParameters();
                $newIn->IsDeleted = false;
                $newIn->NidParameter = Str::uuid();
                $newIn->ParameterKey = $repOut;
                $newIn->ReportId = $report->NidReport;
                $newIn->Type = 1;
            }
            $api->AddReportParameters($outs);
            $api->AddReportParameters($inps);
            $result = new JsonResults();
            $result->HasValue = true;
            $result->Message = sprintf("گزارش با نام %s با موفقیت ایجاد گردید",$report->ReportName);
            return response()->json($result);
        }else
        {
            $result = new JsonResults();
            $result->HasValue = false;
            $result->Message = "خطا در سرور.لطفا مجددا امتحان نمایید";
            return response()->json($result);
        }
    }
    public function DeleteReport(string $NidReport)
    {
        $api = new NPMSController();
        if($api->DeleteReport($NidReport))
        {
            $result = new JsonResults();
            $result->HasValue = true;
            $result->Message = "گزارش با موفقیت حذف گردید";
            return response()->json($result);
        }else
        {
            $result = new JsonResults();
            $result->HasValue = false;
            return response()->json($result);
        }
    }
}
