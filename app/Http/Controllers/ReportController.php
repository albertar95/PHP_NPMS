<?php

namespace App\Http\Controllers;

use App\Domains\Repositories\ReportRawData;
use App\Http\Controllers\Api\NPMSController;
use Illuminate\Http\Request;

class ReportController extends Controller
{
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
        return view('Report.ExecuteReport',compact('report','inputs','outputs'));
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
        // return Json(new JsonResults() { HasValue = true, Html = JsonResults.RenderViewToString(this.ControllerContext, "_CustomReportPartial", ContextId) });
    }
    public function SubmitAddCustomReport(string $Name,int $ContextId,int $FieldId,array $Inputs,array $Outputs)
    {
        // Report newReport = new Report() {  NidReport = Guid.NewGuid(), ContextId = ContextId, FieldId = FieldId, ReportName = Name};
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     HttpResponseMessage response = client.PostAsJsonAsync("Report/AddReport", newReport).Result;
        //     if (response.IsSuccessStatusCode)
        //     {
        //         List<ReportParameter> inputs = new List<ReportParameter>();
        //         foreach (var inp in Inputs)
        //         {
        //             inputs.Add(new ReportParameter() {  IsDeleted = false, NidParameter = Guid.NewGuid(), ParameterKey = inp, ReportId = newReport.NidReport, Type = 0});
        //         }
        //         foreach (var outp in Outputs)
        //         {
        //             inputs.Add(new ReportParameter() { IsDeleted = false, NidParameter = Guid.NewGuid(), ParameterKey = outp, ReportId = newReport.NidReport, Type = 1 });
        //         }
        //         HttpResponseMessage response2 = client.PostAsJsonAsync("Report/AddReportParameters", inputs).Result;
        //         HttpResponseMessage response3 = client.PostAsJsonAsync("Report/AddReportParameters", Outputs).Result;
        //         if (response2.IsSuccessStatusCode && response3.IsSuccessStatusCode)
        //         {
        //             return Json(new JsonResults() { HasValue = true, Message = $"گزارش با نام {Name} با موفقیت ایجاد گردید" });
        //         }
        //         else
        //         {
        //             return Json(new JsonResults() { HasValue = false, Message = "خطا در سرور.لطفا مجددا امتحان نمایید" });
        //         }
        //     }
        //     else
        //     {
        //         return Json(new JsonResults() { HasValue = false, Message = "خطا در سرور.لطفا مجددا امتحان نمایید" });
        //     }
        // }
    }
    public function DeleteReport(string $NidReport)
    {
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     HttpResponseMessage deleteReportResult = client.GetAsync($"Report/DeleteReport?NidReport={NidReport}").Result;
        //     if (deleteReportResult.IsSuccessStatusCode)
        //     {
        //         TempData["DeleteReportSuccessMessage"] = $"گزارش با موفقیت حذف گردید";
        //         return Json(new JsonResults() { HasValue = true });
        //     }
        //     else
        //     {
        //         return Json(new JsonResults() { HasValue = false });
        //     }
        // }
    }
}
