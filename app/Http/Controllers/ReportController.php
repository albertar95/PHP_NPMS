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
    public function GetReportParameterInfos()
    {
        $infos = new Collection();
        //scholar inputs
        $tmpinfo = new ReportParameterInfo(1,1,"BirthDate",0,'تاریخ تولد');
        $infos->push($tmpinfo);
        $tmpinfo = new ReportParameterInfo(1,2,"GradeId",0,'مقطع تحصیلی');
        $infos->push($tmpinfo);
        $tmpinfo = new ReportParameterInfo(1,3,"MajorId",0,'رشته تحصیلی');
        $infos->push($tmpinfo);
        $tmpinfo = new ReportParameterInfo(1,4,"OreintationId",0,'گرایش');
        $infos->push($tmpinfo);
        $tmpinfo = new ReportParameterInfo(1,5,"MillitaryStatus",0,'وضعیت خدمتی');
        $infos->push($tmpinfo);
        $tmpinfo = new ReportParameterInfo(1,6,"NationalCode",0,'کد ملی');
        $infos->push($tmpinfo);
        //scholar outputs
        $tmpinfo = new ReportParameterInfo(1,1,"FirstName",1,'نام');
        $infos->push($tmpinfo);
        $tmpinfo = new ReportParameterInfo(1,2,"LastName",1,'نام خانوادگی');
        $infos->push($tmpinfo);
        $tmpinfo = new ReportParameterInfo(1,3,"NationalCode",1,'کد ملی');
        $infos->push($tmpinfo);
        $tmpinfo = new ReportParameterInfo(1,4,"BirthDate",1,'تاریخ تولد');
        $infos->push($tmpinfo);
        $tmpinfo = new ReportParameterInfo(1,5,"FatherName",1,'نام پدر');
        $infos->push($tmpinfo);
        $tmpinfo = new ReportParameterInfo(1,6,"Mobile",1,'شماره همراه');
        $infos->push($tmpinfo);
        $tmpinfo = new ReportParameterInfo(1,7,"MillitaryStatus",1,'وضعیت خدمتی');
        $infos->push($tmpinfo);
        $tmpinfo = new ReportParameterInfo(1,8,"MajorId",1,'رشته تحصیلی');
        $infos->push($tmpinfo);
        $tmpinfo = new ReportParameterInfo(1,9,"OreintationId",1,'گرایش');
        $infos->push($tmpinfo);
        $tmpinfo = new ReportParameterInfo(1,10,"college",1,'دانشکده');
        $infos->push($tmpinfo);
        $tmpinfo = new ReportParameterInfo(1,11,"CollaborationType",1,'نوع همکاری');
        $infos->push($tmpinfo);
        $tmpinfo = new ReportParameterInfo(1,13,"GradeId",1,'مقطع تحصیلی');
        $infos->push($tmpinfo);
        return $infos;
    }
    public function StatisticReports(Request $request)
    {
        $api = new NPMSController();
        $Report = $api->GetStatisticsReports();
        $api->AddLog(auth()->user(),$request->ip(),1,0,1,1,"گزارشات آماری");
        return view('Report.StatisticReports',compact('Report'));
    }
    public function ExecuteReport(string $NidReport,Request $request)
    {
        $api = new NPMSController();
        $report = $api->GetReportById($NidReport);
        $inputs = $api->GetReportsInput($NidReport);
        $outputs = $api->GetReportsOutput($NidReport);
        $inputHtml = "";
        $ReportType = $report->ContextId;
        if (!is_null($inputs))
        {
            $Grades = $api->GetGrades();
            $Majors = $api->GetMajors();
            $Orientations = $api->GetOrientations();
            $MillitaryStatuses = $api->GetMillitaryStatuses();
            for ($i = 0; $i <= $inputs->count() / 3; $i++)
            {
                $inputHtml = $inputHtml.'<div class="form-group row" style="display:flex;">';
                foreach ($inputs->sortBy('NidParameter')->skip($i*3)->take(3) as $inp)
                {
                    $inputHtml = $inputHtml.'<div class="col-sm-4" style="text-align:right;"> <div style="display:flex;">';
                    $tmpparam = $this->GetReportParameterInfos()->where('ParameterType','=',0)->where('TypeId','=',$ReportType)->where('FieldName','=',$inp->ParameterKey)->firstOrFail();
                    $tmpview = view('Report._ExecuteReportPartial',compact('tmpparam','ReportType','Grades','Majors','Orientations','MillitaryStatuses'))->render();
                    $inputHtml = $inputHtml.$tmpview;
                    $inputHtml = $inputHtml.'</div></div>';
                }
                $inputHtml = $inputHtml.'</div>';
            }
        }
        $outputHtml = "";
        foreach ($outputs as $outy)
        {
            $outputHtml = $outputHtml.'<div class="col-sm-4"><div class="row" style="display:flex;">';
            $outputHtml = $outputHtml.sprintf("<input type=\"checkbox\" style=\"width:1rem;margin:unset !important;\" id=\"%s\" class=\"form-control checkbox\" alt=\"out\" checked />",$outy->ParameterKey);
            $outputHtml = $outputHtml.sprintf("<label for=\"%s\" style=\"margin:.45rem .45rem 0 0\">%s</label>",$outy->ParameterKey,$this->GetReportParameterInfos()->where('ParameterType','=',1)->where('FieldName','=',$outy->ParameterKey)->firstOrFail()->PersianName);
            $outputHtml = $outputHtml.'</div></div>';
        }
        $api->AddLog(auth()->user(),$request->ip(),1,0,1,1,"گزارش آماری");
        return view('Report.ExecuteReport',compact('report','inputs','outputs','inputHtml','outputHtml'));
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
        $api->AddLog(auth()->user(),$report->ip(),24,0,2,2,$report->ReportName);
        return response()->json($result);
        // return view('Report.ExecuteReport',compact('report','inputs','outputs'));
    }
    public function ChartReports(Request $request)
    {
        $api = new NPMSController();
        $api->AddLog(auth()->user(),$request->ip(),1,0,1,1,"گزارش نموداری");
        return view('Report.ChartReports');
    }
    public function CustomReports(Request $request)
    {
        $api = new NPMSController();
        $api->AddLog(auth()->user(),$request->ip(),1,0,1,1,"ایجاد گزارش");
        return view('Report.CustomReports');
    }
    public function CustomReportContextChanged(int $ContextId)
    {
        $result = new JsonResults();
        $result->HasValue = true;
        $inputs = $this->GetReportParameterInfos()->where('TypeId','=',$ContextId)->where('ParameterType','=',0);
        $outputs = $this->GetReportParameterInfos()->where('TypeId','=',$ContextId)->where('ParameterType','=',1);
        $result->Html = view('Report._CustomReportPartial',compact('inputs','outputs'))->render();
        return response()->json($result);
    }
    public function SubmitAddCustomReport(Request $report)//string $Name,int $ContextId,int $FieldId,array $Inputs,array $Outputs
    {
        $newReport = new Reports();
        $newReport->NidReport = Str::uuid();
        $newReport->ContextId = $report->ContextId;
        $newReport->FieldId = $report->FieldId;
        $newReport->ReportName = $report->Name;
        $api = new NPMSController();
        if($api->AddReport($newReport))
        {
            $inps = new Collection();
            foreach ($report->Inputs as $repInp) {
                $newIn = new ReportParameters();
                $newIn->IsDeleted = false;
                $newIn->NidParameter = Str::uuid();
                $newIn->ParameterKey = $repInp;
                $newIn->ReportId = $report->NidReport;
                $newIn->Type = 0;
                $inps->push($newIn);
            }
            $outs = new Collection();
            foreach ($report->Outputs as $repOut) {
                $newOut = new ReportParameters();
                $newOut->IsDeleted = false;
                $newOut->NidParameter = Str::uuid();
                $newOut->ParameterKey = $repOut;
                $newOut->ReportId = $report->NidReport;
                $newOut->Type = 1;
                $outs->push($newOut);
            }
            $api->AddReportParameters($outs);
            $api->AddReportParameters($inps);
            $result = new JsonResults();
            $result->HasValue = true;
            $result->Message = sprintf("گزارش با نام %s با موفقیت ایجاد گردید",$newReport->ReportName);
            $api->AddLog(auth()->user(),$report->ip(),25,0,3,2,$newReport->ReportName);
            return response()->json($result);
        }else
        {
            $result = new JsonResults();
            $result->HasValue = false;
            $result->Message = "خطا در سرور.لطفا مجددا امتحان نمایید";
            $api->AddLog(auth()->user(),$report->ip(),25,1,3,2,$newReport->ReportName);
            return response()->json($result);
        }
    }
    public function DeleteReport(string $NidReport,Request $request)
    {
        $api = new NPMSController();
        if($api->DeleteReport($NidReport))
        {
            $result = new JsonResults();
            $result->HasValue = true;
            $result->Message = "گزارش با موفقیت حذف گردید";
            $api->AddLog(auth()->user(),$request->ip(),26,0,3,2,$NidReport);
            return response()->json($result);
        }else
        {
            $result = new JsonResults();
            $result->HasValue = false;
            $api->AddLog(auth()->user(),$request->ip(),26,1,3,2,$NidReport);
            return response()->json($result);
        }
    }
}

class ReportParameterInfo
{
    public int $TypeId;
    public int $FieldId;
    public string $FieldName;
    public string $PersianName;
    public int $ParameterType;
    public function __construct($_typeId,$_fieldId,$_fieldname,$_parametertype,$_persianname)
    {
        $this->TypeId = $_typeId;
        $this->FieldId = $_fieldId;
        $this->FieldName = $_fieldname;
        $this->PersianName = $_persianname;
        $this->ParameterType = $_parametertype;
    }
}
