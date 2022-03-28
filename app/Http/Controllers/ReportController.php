<?php

namespace App\Http\Controllers;

use App\Domains\Repositories\ReportRawData;
use App\Helpers\Casts;
use App\Http\Controllers\Api\NPMSController;
use App\Http\Requests\ReportRequest;
use App\Models\ReportParameters;
use App\Models\Reports;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('XSS');
    }
    private function CheckAuthority(bool $checkSub, int $sub, string $cookie, int $entity = 4)
    {
        try {
            $row = explode('#', $cookie);
            $AccessedEntities = new Collection();
            foreach ($row as $r) {
                $AccessedEntities->push(explode(',', $r)[0]);
            }
            if ($checkSub) {
                $AccessedSub = new Collection();
                foreach ($row as $r) {
                    $AccessedSub->push(["entity" => explode(',', $r)[0], "rowValue" => substr($r, 2, strlen($r) - 2)]);
                }
                if (in_array($entity, $AccessedEntities->toArray())) {
                    if (explode(',', $AccessedSub->where('entity', '=', $entity)->pluck('rowValue')[0])[$sub] == 1)
                        return true;
                    else
                        return false;
                } else
                    return false;
            } else {
                if (in_array($entity, $AccessedEntities->toArray()))
                    return true;
                else
                    return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function GetReportParameterInfos()
    {
        try {
            $infos = new Collection();
            //scholar inputs
            $tmpinfo = new ReportParameterInfo(1, 1, "BirthDate", 0, 'تاریخ تولد');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(1, 2, "GradeId", 0, 'مقطع تحصیلی');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(1, 3, "MajorId", 0, 'رشته تحصیلی');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(1, 4, "OreintationId", 0, 'گرایش');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(1, 5, "MillitaryStatus", 0, 'وضعیت خدمتی');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(1, 6, "NationalCode", 0, 'کد ملی');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(1, 7, "IsSecurityApproved", 0, 'تاییدیه حفاظت');
            $infos->push($tmpinfo);
            //project inputs
            $tmpinfo = new ReportParameterInfo(2, 1, "ProjectStatus", 0, 'وضعیت طرح');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 2, "UnitId", 0, 'یگان تخصصی');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 3, "GroupId", 0, 'گروه تخصصی');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 4, "Supervisor", 0, 'استاد راهنما');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 5, "Advisor", 0, 'استاد مشاور');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 6, "Referee", 0, 'داوران');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 7, "PersianCreateDate", 0, 'تاریخ ایجاد');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 8, "TenPercentLetterDate", 0, 'تاریخ نامه 10 درصد');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 9, "PreImploymentLetterDate", 0, 'تاریخ نامه روگرفت');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 10, "ImploymentDate", 0, 'تاریخ بکارگیری');
            $infos->push($tmpinfo);
            // $tmpinfo = new ReportParameterInfo(2, 11, "SecurityLetterDate", 0, 'تاریخ نامه حفاظت');
            // $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 12, "ThesisDefenceDate", 0, 'تاریخ دفاعیه');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 13, "ThesisDefenceLetterDate", 0, 'تاریخ نامه دفاعیه');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 14, "ReducePeriod", 0, 'مدت کسری');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 15, "UserId", 0, 'کاربر ایجاد کننده');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 16, "ThirtyPercentLetterDate", 0, 'تاریخ نامه 30 درصد');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 17, "SixtyPercentLetterDate", 0, 'تاریخ نامه 60 درصد');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 18, "ATFLetterDate", 0, 'تاریخ نامه عتف');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 19, "FinalApprove", 0, 'تایید نهایی');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 20, "IsConfident", 0, 'محرمانه');
            $infos->push($tmpinfo);
            //user inputs
            $tmpinfo = new ReportParameterInfo(4, 1, "RoleId", 0, 'نقش');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(4, 2, "IsLockedOut", 0, 'قفل');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(4, 3, "IsDisabled", 0, 'غیرفعال');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(4, 4, "LastLoginDate", 0, 'آخرین ورود');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(4, 5, "IncorrectPasswordCount", 0, 'تعداد کلمه عبور اشتباه');
            $infos->push($tmpinfo);
            //scholar outputs
            $tmpinfo = new ReportParameterInfo(1, 1, "FirstName", 1, 'نام');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(1, 2, "LastName", 1, 'نام خانوادگی');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(1, 3, "NationalCode", 1, 'کد ملی');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(1, 4, "BirthDate", 1, 'تاریخ تولد');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(1, 5, "FatherName", 1, 'نام پدر');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(1, 6, "Mobile", 1, 'شماره همراه');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(1, 7, "MillitaryStatus", 1, 'وضعیت خدمتی');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(1, 8, "MajorId", 1, 'رشته تحصیلی');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(1, 9, "OreintationId", 1, 'گرایش');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(1, 10, "college", 1, 'دانشکده');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(1, 11, "CollaborationType", 1, 'نوع همکاری');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(1, 13, "GradeId", 1, 'مقطع تحصیلی');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(1, 14, "IsSecurityApproved", 1, 'تاییدیه حفاظت');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(1, 15, "SecurityApproveDate", 1, 'تاریخ نامه حفاظت');
            $infos->push($tmpinfo);
            //project output
            $tmpinfo = new ReportParameterInfo(2, 1, "ProjectStatus", 1, 'وضعیت طرح'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 2, "UnitTitle", 1, 'یگان تخصصی'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 3, "GroupTitle", 1, 'گروه تخصصی'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 4, "Supervisor", 1, 'استاد راهنما'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 5, "Advisor", 1, 'استاد مشاور'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 6, "Referee", 1, 'داوران'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 7, "PersianCreateDate", 1, 'تاریخ ایجاد'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 8, "TenPercentLetterDate", 1, 'تاریخ نامه 10 درصد'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 9, "PreImploymentLetterDate", 1, 'تاریخ نامه روگرفت'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 11, "ImploymentDate", 1, 'تاریخ بکارگیری'); //
            $infos->push($tmpinfo);
            // $tmpinfo = new ReportParameterInfo(2, 11, "SecurityLetterDate", 1, 'تاریخ نامه حفاظت'); //
            // $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 12, "ThesisDefenceDate", 1, 'تاریخ دفاعیه'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 13, "ThesisDefenceLetterDate", 1, 'تاریخ نامه دفاعیه'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 14, "ReducePeriod", 1, 'مدت کسری'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 15, "UserTitle", 1, 'کاربر ایجاد کننده'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 16, "ThirtyPercentLetterDate", 1, 'تاریخ نامه 30 درصد'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 17, "SixtyPercentLetterDate", 1, 'تاریخ نامه 60 درصد'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 18, "ATFLetterDate", 1, 'تاریخ نامه عتف'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 19, "FinalApprove", 1, 'تایید نهایی'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 20, "IsConfident", 1, 'محرمانه'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 21, "ProjectNumber", 1, 'شماره پرونده'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 22, "Subject", 1, 'عنوان'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 23, "ScholarTitle", 1, 'نام محقق'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 24, "SupervisorMobile", 1, 'شماره همراه راهنما'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 25, "AdvisorMobile", 1, 'شماره همراه مشاور'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 26, "Editor", 1, 'ویراستار'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 27, "HasBookPublish", 1, 'چاپ کتاب'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(2, 28, "TitleApproved", 1, 'تایید عنوان'); //
            $infos->push($tmpinfo);
            //user output
            $tmpinfo = new ReportParameterInfo(4, 1, "RoleTitle", 1, 'نقش'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(4, 2, "IsLockedOut", 1, 'قفل شدن'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(4, 3, "IsDisabled", 1, 'غیرفعال شدن');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(4, 4, "LastLoginDate", 1, 'آخرین ورود');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(4, 5, "IncorrectPasswordCount", 1, 'تعداد کلمه عبور اشتباه');
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(4, 6, "Username", 1, 'نام کاربری'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(4, 7, "FirstName", 1, 'نام'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(4, 8, "LastName", 1, 'نام خانوادگی'); //
            $infos->push($tmpinfo);
            $tmpinfo = new ReportParameterInfo(4, 9, "ProfilePicture", 1, 'نمایه'); //
            $infos->push($tmpinfo);

            return $infos;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function StatisticReports(Request $request)
    {
        try {
            if ($this->CheckAuthority(true, 4, $request->cookie('NPMS_Permissions'))) {
                $api = new NPMSController();
                $Report = $api->GetStatisticsReports();
                $api->AddLog(auth()->user(), $request->ip(), 1, 0, 1, 1, "گزارشات آماری");
                return view('Report.StatisticReports', compact('Report'));
            } else {
                return view('errors.401');
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function UserLogReport(Request $request)
    {
        try {
            if ($this->CheckAuthority(false, 4, $request->cookie('NPMS_Permissions'))) {
                $api = new NPMSController();
                $LogActionTypes = $api->GetLogActionTypes(1000);
                $api->AddLog(auth()->user(), $request->ip(), 1, 0, 1, 1, "گزارش عملکرد کاربران");
                return view('Report.UserLogReport', compact('LogActionTypes'));
            } else {
                return view('errors.401');
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function PersianDateToGeorgian(string $Datee)
    {
        try {
            return Verta::getGregorian(intval(Casts::PersianToEnglishDigits(substr($Datee, 0, 8))), intval(Casts::PersianToEnglishDigits(substr(substr($Datee, 0, 13), -4))), intval(Casts::PersianToEnglishDigits(substr($Datee, -4))));
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function SubmitUserLogReport(Request $report) //string $FromDate,string $ToDate,int $LogActionId,string $UserName = "")
    {
        try {
            $api = new NPMSController();
            $result = new JsonResults();
            $logs = $api->GetUserLogReport($this->PersianDateToGeorgian($report->FromDate)[0] . '-' . sprintf("%02d", $this->PersianDateToGeorgian($report->FromDate)[1]) . '-' . sprintf("%02d", $this->PersianDateToGeorgian($report->FromDate)[2]), $this->PersianDateToGeorgian($report->ToDate)[0] . '-' . sprintf("%02d", $this->PersianDateToGeorgian($report->ToDate)[1]) . '-' . sprintf("%02d", $this->PersianDateToGeorgian($report->ToDate)[2]), $report->LogActionId, $report->UserName);
            $result->HasValue = true;
            $result->Html = view('Report._UserActivityReportResult', compact('logs'))->render();
            return response()->json($result);
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function ExecuteReport(string $NidReport, Request $request)
    {
        try {
            if ($this->CheckAuthority(false, 4, $request->cookie('NPMS_Permissions'))) {
                $api = new NPMSController();
                $report = $api->GetReportById($NidReport);
                $inputs = $api->GetReportsInput($NidReport);
                $outputs = $api->GetReportsOutput($NidReport);
                $inputHtml = "";
                $ReportType = $report->ContextId;
                if (!is_null($inputs)) {
                    $Grades = $api->GetGrades();
                    $Majors = $api->GetMajors();
                    $Orientations = $api->GetOrientations();
                    $MillitaryStatuses = $api->GetMillitaryStatuses();
                    $units = $api->GetAllUnits();
                    $unitgroups = $api->GetAllUnitGroups();
                    $users = $api->GetAllUsers();
                    $roles = $api->GetAllRoles();
                    for ($i = 0; $i <= $inputs->count() / 3; $i++) {
                        $inputHtml = $inputHtml . '<div class="form-group row" style="display:flex;">';
                        foreach ($inputs->sortBy('ParameterValue')->skip($i * 3)->take(3) as $inp) {
                            $inputHtml = $inputHtml . '<div class="col-sm-4" style="text-align:right;"> <div style="display:flex;">';
                            $tmpparam = $this->GetReportParameterInfos()->where('ParameterType', '=', 0)->where('TypeId', '=', $ReportType)->where('FieldName', '=', $inp->ParameterKey)->firstOrFail();
                            $tmpview = view('Report._ExecuteReportPartial', compact('tmpparam', 'ReportType', 'units', 'unitgroups', 'users', 'roles', 'Grades', 'Majors', 'Orientations', 'MillitaryStatuses'))->render();
                            $inputHtml = $inputHtml . $tmpview;
                            $inputHtml = $inputHtml . '</div></div>';
                        }
                        $inputHtml = $inputHtml . '</div>';
                    }
                }
                $outputHtml = "";
                foreach ($outputs->sortBy('ParameterValue') as $outy) {
                    if ($this->GetReportParameterInfos()->where('ParameterType', '=', 1)->where('FieldName', '=', $outy->ParameterKey)->count() > 0) {
                        $outputHtml = $outputHtml . '<div class="col-sm-4"><div class="row" style="display:flex;">';
                        $outputHtml = $outputHtml . sprintf("<input type=\"checkbox\" style=\"width:1rem;margin:unset !important;\" id=\"%s\" class=\"form-control checkbox\" alt=\"out\" checked />", $outy->ParameterKey);
                        $outputHtml = $outputHtml . sprintf("<label for=\"%s\" style=\"margin:.45rem .45rem 0 0\">%s</label>", $outy->ParameterKey, $this->GetReportParameterInfos()->where('ParameterType', '=', 1)->where('FieldName', '=', $outy->ParameterKey)->firstOrFail()->PersianName);
                        $outputHtml = $outputHtml . '</div></div>';
                    }
                }
                $api->AddLog(auth()->user(), $request->ip(), 1, 0, 1, 1, "گزارش آماری");
                return view('Report.ExecuteReport', compact('report', 'inputs', 'outputs', 'inputHtml', 'outputHtml'));
            } else {
                return view('errors.401');
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SubmitStatisticsReport(Request $report) //string $NidReport,array $PrameterKeys,array $ParameterValues,array $OutPutValues
    {
        try {
            $api = new NPMSController();
            $reportresult = $api->GetStatisticsReport($report->NidReport, $report->PrameterKeys, $report->ParameterValues);
            $OutputKey = collect($report->OutPutValues);
            $Scholars = $reportresult->Scholars;
            $Projects = $reportresult->Projects;
            $Users = $reportresult->Users;
            $ReportName = $reportresult->ReportName;
            $result = new JsonResults();
            $result->HasValue = true;
            $result->Html = view('Report._ReportResult', compact('Scholars', 'Projects', 'Users', 'OutputKey', 'ReportName'))->render();
            $api->AddLog(auth()->user(), $report->ip(), 24, 0, 2, 2, $ReportName);
            return response()->json($result);
            // return $reportresult;
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function DownloadStatisticsReport(Request $report) //string $NidReport,array $PrameterKeys,array $ParameterValues,array $OutPutValues
    {
        try {
            $api = new NPMSController();
            $reportresult = $api->GetStatisticsReport($report->NidReport, $report->PrameterKeys, $report->ParameterValues);
            $OutputKey = collect($report->OutPutValues);
            $Scholars = $reportresult->Scholars;
            $Projects = $reportresult->Projects;
            $Users = $reportresult->Users;
            $ReportName = $reportresult->ReportName;
            $ReportDate = substr(new Verta(Carbon::now()), 0, 10);
            $ReportTime = substr(new Verta(Carbon::now()), 10, 10);
            $ConfidentLevel = 0;
            if (($Scholars->count() + $Projects->count() + $Users->count()) > 2500) {
                try {
                    ini_set("pcre.backtrack_limit", "100000000");
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
            $pdf = PDF::loadView('Report._DownloadReportResult', compact('Scholars', 'Projects', 'Users', 'OutputKey', 'ReportName', 'ReportDate', 'ReportTime', 'ConfidentLevel'));
            $api->AddLog(auth()->user(), $report->ip(), 29, 0, 3, 2, $ReportName);
            return $pdf->stream($ReportName . '.pdf');
            // return view('Report._DownloadReportResult',compact('Scholars','Projects','Users','OutputKey','ReportName','ReportDate','ReportTime'));
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function PrintStatisticsReport(Request $report) //string $NidReport,array $PrameterKeys,array $ParameterValues,array $OutPutValues
    {
        try {
            $result = new JsonResults();
            if ($this->CheckAuthority(true, 5, $report->cookie('NPMS_Permissions')))
            {
                $api = new NPMSController();
                $reportresult = $api->GetStatisticsReport($report->NidReport, $report->PrameterKeys, $report->ParameterValues);
                $OutputKey = collect($report->OutPutValues);
                $Scholars = $reportresult->Scholars;
                $Projects = $reportresult->Projects;
                $Users = $reportresult->Users;
                $ReportName = $reportresult->ReportName;
                $ReportDate = substr(new Verta(Carbon::now()), 0, 10);
                $ReportTime = substr(new Verta(Carbon::now()), 10, 10);
                $ConfidentLevel = 0;
                // $pdf = PDF::loadView('Report._DownloadReportResult', compact('Scholars', 'Projects', 'Users', 'OutputKey', 'ReportName', 'ReportDate', 'ReportTime'));
                $result->Html = view('Report._DownloadReportResult', compact('Scholars', 'Projects', 'Users', 'OutputKey', 'ReportName', 'ReportDate', 'ReportTime', 'ConfidentLevel'))->render();
                $result->HasValue = true;
                $api->AddLog(auth()->user(), $report->ip(), 30, 0, 3, 2, $ReportName);
                return response()->json($result);
            }else
            {
                $result->HasValue = false;
                return response()->json($result);
            }
            // return $pdf->stream($ReportName.'.pdf');
            // return view('Report._DownloadReportResult',compact('Scholars','Projects','Users','OutputKey','ReportName','ReportDate','ReportTime'));
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function DownloadUserLogReport(Request $report) //string $NidReport,array $PrameterKeys,array $ParameterValues,array $OutPutValues
    {
        try {
            $api = new NPMSController();
            $logs = $api->GetUserLogReport($this->PersianDateToGeorgian($report->FromDate)[0] . '-' . sprintf("%02d", $this->PersianDateToGeorgian($report->FromDate)[1]) . '-' . sprintf("%02d", $this->PersianDateToGeorgian($report->FromDate)[2]), $this->PersianDateToGeorgian($report->ToDate)[0] . '-' . sprintf("%02d", $this->PersianDateToGeorgian($report->ToDate)[1]) . '-' . sprintf("%02d", $this->PersianDateToGeorgian($report->ToDate)[2]), $report->LogActionId, $report->UserName);
            $ReportDate = substr(new Verta(Carbon::now()), 0, 10);
            $ReportTime = substr(new Verta(Carbon::now()), 10, 10);
            $ConfidentLevel = 0;
            if ($logs->count() > 2500) {
                try {
                    ini_set("pcre.backtrack_limit", "100000000");
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
            $pdf = PDF::loadView('Report._DownloadActivityLogReport', compact('logs', 'ReportDate', 'ReportTime', 'ConfidentLevel'));
            $api->AddLog(auth()->user(), $report->ip(), 31, 0, 3, 2, '');
            return $pdf->stream('userActivityLog.pdf');
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function PrintUserLogReport(Request $report) //string $NidReport,array $PrameterKeys,array $ParameterValues,array $OutPutValues
    {
        try {
            $result = new JsonResults();
            if ($this->CheckAuthority(true, 5, $report->cookie('NPMS_Permissions')))
            {
                $api = new NPMSController();
                $logs = $api->GetUserLogReport($this->PersianDateToGeorgian($report->FromDate)[0] . '-' . sprintf("%02d", $this->PersianDateToGeorgian($report->FromDate)[1]) . '-' . sprintf("%02d", $this->PersianDateToGeorgian($report->FromDate)[2]), $this->PersianDateToGeorgian($report->ToDate)[0] . '-' . sprintf("%02d", $this->PersianDateToGeorgian($report->ToDate)[1]) . '-' . sprintf("%02d", $this->PersianDateToGeorgian($report->ToDate)[2]), $report->LogActionId, $report->UserName);
                $ReportDate = substr(new Verta(Carbon::now()), 0, 10);
                $ReportTime = substr(new Verta(Carbon::now()), 10, 10);
                $ConfidentLevel = 0;
                $result->HasValue = true;
                $result->Html = view('Report._DownloadActivityLogReport', compact('logs', 'ReportDate', 'ReportTime', 'ConfidentLevel'))->render();
                $api->AddLog(auth()->user(), $report->ip(), 32, 0, 3, 2, '');
                return response()->json($result);
            }else
            {
                $result->HasValue = false;
                return response()->json($result);
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function ChartReports(Request $request)
    {
        try {
            $api = new NPMSController();
            $api->AddLog(auth()->user(), $request->ip(), 1, 0, 1, 1, "گزارش نموداری");
            return view('Report.ChartReports');
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function CustomReports(Request $request)
    {
        try {
            if ($this->CheckAuthority(true, 0, $request->cookie('NPMS_Permissions')))
            {
                $api = new NPMSController();
                $api->AddLog(auth()->user(), $request->ip(), 1, 0, 1, 1, "ایجاد گزارش");
                return view('Report.CustomReports');
            }else
            {
                return view('errors.401');
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function CustomReportContextChanged(int $ContextId)
    {
        try {
            $result = new JsonResults();
            $result->HasValue = true;
            $inputs = $this->GetReportParameterInfos()->where('TypeId', '=', $ContextId)->where('ParameterType', '=', 0);
            $outputs = $this->GetReportParameterInfos()->where('TypeId', '=', $ContextId)->where('ParameterType', '=', 1);
            $result->Html = view('Report._CustomReportPartial', compact('inputs', 'outputs'))->render();
            return response()->json($result);
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SubmitAddCustomReport(ReportRequest $report) //string $Name,int $ContextId,int $FieldId,array $Inputs,array $Outputs
    {
        try {
            $report->validated();
            $newReport = new Reports();
            $newReport->NidReport = Str::uuid();
            $newReport->ContextId = $report->ContextId;
            $newReport->FieldId = $report->FieldId;
            $newReport->ReportName = $report->ReportName;
            $api = new NPMSController();
            if ($api->AddReport($newReport)) {
                $inps = new Collection();
                foreach ($report->Inputs as $repInp) {
                    $newIn = new ReportParameters();
                    $newIn->IsDeleted = false;
                    $newIn->NidParameter = Str::uuid();
                    $newIn->ParameterKey = $repInp;
                    $newIn->ParameterValue = $this->GetReportParameterInfos()->where('ParameterType', '=', 0)->where('TypeId', '=', $report->ContextId)->where('FieldName', '=', $repInp)->firstOrFail()->FieldId;
                    $newIn->ReportId = $newReport->NidReport;
                    $newIn->Type = 0;
                    $inps->push($newIn);
                }
                $outs = new Collection();
                foreach ($report->Outputs as $repOut) {
                    $newOut = new ReportParameters();
                    $newOut->IsDeleted = false;
                    $newOut->NidParameter = Str::uuid();
                    $newOut->ParameterKey = $repOut;
                    $newOut->ParameterValue = $this->GetReportParameterInfos()->where('ParameterType', '=', 1)->where('TypeId', '=', $report->ContextId)->where('FieldName', '=', $repOut)->firstOrFail()->FieldId;
                    $newOut->ReportId = $newReport->NidReport;
                    $newOut->Type = 1;
                    $outs->push($newOut);
                }
                $api->AddReportParameters($outs);
                $api->AddReportParameters($inps);
                $result = new JsonResults();
                $result->HasValue = true;
                $result->Message = sprintf("گزارش با نام %s با موفقیت ایجاد گردید", $newReport->ReportName);
                $api->AddLog(auth()->user(), $report->ip(), 25, 0, 3, 2, $newReport->ReportName);
                return response()->json($result);
            } else {
                $result = new JsonResults();
                $result->HasValue = false;
                $result->Message = "خطا در سرور.لطفا مجددا امتحان نمایید";
                $api->AddLog(auth()->user(), $report->ip(), 25, 1, 3, 2, $newReport->ReportName);
                return response()->json($result);
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function DeleteReport(string $NidReport, Request $request)
    {
        try {
            if ($this->CheckAuthority(true, 2, $request->cookie('NPMS_Permissions')))
            {
                $api = new NPMSController();
                if ($api->DeleteReport($NidReport)) {
                    $result = new JsonResults();
                    $result->HasValue = true;
                    $result->Message = "گزارش با موفقیت حذف گردید";
                    $api->AddLog(auth()->user(), $request->ip(), 26, 0, 3, 2, $NidReport);
                    return response()->json($result);
                } else {
                    $result = new JsonResults();
                    $result->HasValue = false;
                    $api->AddLog(auth()->user(), $request->ip(), 26, 1, 3, 2, $NidReport);
                    return response()->json($result);
                }
            }else
            {
                $result = new JsonResults();
                $result->HasValue = false;
                return response()->json($result);
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
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
    public function __construct($_typeId, $_fieldId, $_fieldname, $_parametertype, $_persianname)
    {
        $this->TypeId = $_typeId;
        $this->FieldId = $_fieldId;
        $this->FieldName = $_fieldname;
        $this->PersianName = $_persianname;
        $this->ParameterType = $_parametertype;
    }
}
