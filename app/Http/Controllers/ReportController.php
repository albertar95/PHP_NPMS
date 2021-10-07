<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function StatisticReports()
    {
        // List<ReportDTO> reports = new List<ReportDTO>();
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     var response = client.GetAsync($"Report/GetStatisticsReports").Result;
        //     if (response.IsSuccessStatusCode)
        //         reports = response.Content.ReadAsAsync<List<ReportDTO>>().Result;
        // }
        // return View(reports);
        return view('Report.StatisticReports');
    }
    public function ExecuteReport(string $NidReport)
    {
        // ReportViewModel rvm = new ReportViewModel();
        // ReportDTO report = new ReportDTO();
        // List<ReportParameterDTO> inps = new List<ReportParameterDTO>();
        // List<ReportParameterDTO> outs = new List<ReportParameterDTO>();
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     var response = client.GetAsync($"Report/GetReportById?NidReport={NidReport}").Result;
        //     if (response.IsSuccessStatusCode)
        //     {
        //         report = response.Content.ReadAsAsync<ReportDTO>().Result;
        //         var response2 = client.GetAsync($"Report/GetReportsInput?NidReport={NidReport}").Result;
        //         if(response2.IsSuccessStatusCode)
        //             inps = response2.Content.ReadAsAsync<List<ReportParameterDTO>>().Result;
        //         var response3 = client.GetAsync($"Report/GetReportsOutput?NidReport={NidReport}").Result;
        //         if(response3.IsSuccessStatusCode)
        //             outs = response3.Content.ReadAsAsync<List<ReportParameterDTO>>().Result;
        //     }
        // }
        // rvm.report = report;
        // rvm.inputs = inps;
        // rvm.outputs = outs;
        // return View(rvm);
        return view('Report.ExecuteReport');
    }
    public function SubmitStatisticsReport(string $NidReport,array $PrameterKeys,array $ParameterValues,array $OutPutValues)
    {
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     DataAccessLibrary.Repositories.ReportRawData rrd = new DataAccessLibrary.Repositories.ReportRawData() {  NidReport = NidReport, paramsKey = PrameterKeys, paramsValue = ParameterValues};
        //     HttpResponseMessage response = client.PostAsJsonAsync("Report/StatisticsReport", rrd).Result;
        //     if (response.IsSuccessStatusCode)
        //     {
        //         DataAccessLibrary.Repositories.ReportResultData res = response.Content.ReadAsAsync<DataAccessLibrary.Repositories.ReportResultData>().Result;
        //         res.OutputKey = OutPutValues;
        //         return Json(new JsonResults() {  HasValue = true, Html = JsonResults.RenderViewToString(ControllerContext, "_ReportResult", res) });
        //     }
        //     else
        //     {
        //         return Json(new JsonResults() { HasValue = false, Html = JsonResults.RenderViewToString(ControllerContext, "_ReportResult", null) });
        //     }
        // }
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
