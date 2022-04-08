<?php

namespace App\Http\Controllers;

use App\DTOs\DataMapper;
use App\Http\Controllers\Api\NPMSController;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\TitleRequest;
use App\Models\Projects;
use App\Models\Scholars;
use Carbon\Carbon;
use Dotenv\Util\Str;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use resources\ViewModels\ManageBaseInfoViewModel;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('XSS');
    }
    private function CheckAuthority(bool $checkSub, int $sub, string $cookie, int $entity = 2)
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
    public function Projects(Request $request)
    {
        try {
            if ($this->CheckAuthority(true, 4, $request->cookie('NPMS_Permissions'))) {
                $api = new NPMSController();
                if ($this->CheckAuthority(true, 6, $request->cookie('NPMS_Permissions'))) {
                    $Projects = $api->GetAllProjectInitials(200);
                } else {
                    $Projects = $api->GetAllProjectInitials(200, false);
                }
                $api->AddLog(auth()->user(), $request->ip(), 1, 0, 1, 1, "مدیریت طرح ها");
                return view('Project.Projects', compact('Projects'));
            } else {
                return view('errors.401');
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function Pagination(int $TypeId, int $LoadCount, bool $includeConfident = true)
    {
        try {
            $api = new NPMSController();
            $result = new JsonResults();
            $txtLoadCount = $LoadCount + 1;
            switch ($TypeId) {
                case 1:
                    $Projects = $api->GetAllProjectInitials(200 * ($LoadCount + 1), $includeConfident);
                    if ($Projects->count() / 200 < $LoadCount)
                        $result->HasValue = false;
                    else {
                        $result->HasValue = true;
                        $result->Html = view('Project._ProjectTable', compact('Projects', 'txtLoadCount'))->render();
                    }
                    break;
                case 2:
                    $Scholar = $api->GetAllScholarLists(200 * ($LoadCount + 1), $includeConfident);
                    if ($Scholar->count() / 200 < $LoadCount)
                        $result->HasValue = false;
                    else {
                        $result->HasValue = true;
                        $result->Html = view('Scholar._ScholarTable', compact('Scholar', 'txtLoadCount'))->render();
                    }
                    break;
                case 3:
                    $messages = $api->GetAllUsersSendMessages(auth()->user()->NidUser, 200 * ($LoadCount + 1));
                    if ($messages->count() / 200 < $LoadCount)
                        $result->HasValue = false;
                    else {
                        $result->HasValue = true;
                        $result->Html = view('Message._MessageTable', compact('messages', 'txtLoadCount'))->render();
                    }
                    break;
                case 4:
                    $messages = $api->GetAllUsersMessages(auth()->user()->NidUser, true, 200 * ($LoadCount + 1)); //$api->GetAllUsersSendMessages(auth()->user()->NidUser, 200 * ($LoadCount + 1));
                    if ($messages->count() / 200 < $LoadCount)
                        $result->HasValue = false;
                    else {
                        $result->HasValue = true;
                        $result->Html = view('Message._MessageTable2', compact('messages', 'txtLoadCount'))->render();
                    }
                    break;
                case 5:
                    $api = new NPMSController();
                    $logs = $api->GetCurrentUserLogReport(auth()->user()->NidUser, 200 * ($LoadCount + 1));
                    if ($logs->count() / 200 < $LoadCount)
                        $result->HasValue = false;
                    else {
                        $result->HasValue = true;
                        $result->Html = view('User._ProfileUserActivityReportTable', compact('logs', 'txtLoadCount'))->render();
                    }
                    break;
                default:
                    # code...
                    break;
            }
            return response()->json($result);
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function AddProject(Request $request)
    {
        try {
            if ($this->CheckAuthority(true, 0, $request->cookie('NPMS_Permissions'))) {
                $api = new NPMSController();
                $Scholars = $api->GetAllProjectScholars();
                $UnitGroups = $api->GetAllUnitGroups();
                $Units = $api->GetAllUnits();
                $api->AddLog(auth()->user(), $request->ip(), 1, 0, 2, 1, "ایجاد طرح");
                return view('Project.AddProject', compact('Scholars', 'UnitGroups', 'Units'));
            } else {
                return view('errors.401');
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SubmitAddProject(ProjectRequest $Project)
    {
        try {
            $Project->validated();
            $api = new NPMSController();
            $result = new JsonResults();
            if ($api->AddProject($Project)) {
                $result->HasValue = true;
                $api->AddLog(auth()->user(), $Project->ip(), 2, 0, 3, 1, sprintf("ایجاد طرح موفق.نام طرح : %s", $Project->Subject));
                return response()->json($result);
            } else {
                $result->HasValue = false;
                $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
                $api->AddLog(auth()->user(), $Project->ip(), 2, 1, 3, 1, "ایجاد طرح ناموفق");
                return response()->json($result);
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function ProjectDetail(string $NidProject, Request $request)
    {
        try {
            if ($this->CheckAuthority(true, 3, $request->cookie('NPMS_Permissions'))) {
                $api = new NPMSController();
                $Project = $api->GetProjectDetailDTOById($NidProject);
                if ($Project->IsConfident) {
                    if (!$this->CheckAuthority(true, 6, $request->cookie('NPMS_Permissions'))) {
                        return view('errors.401');
                    }
                }
                $Scholar = $api->GetAllScholarDetails($Project->ScholarId);
                $datafiles = $api->GetProjectFiles($NidProject);
                $api->AddLog(auth()->user(), $request->ip(), 1, 0, 2, 1, sprintf("جزییات طرح %s", $Project->Subject));
                return view('Project.ProjectDetail', compact('Project', 'Scholar','datafiles'));
            } else {
                return view('errors.401');
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function PrintProjectDetail(string $NidProject, Request $request)
    {
        try {
            $result = new JsonResults();
            if ($this->CheckAuthority(true, 3, $request->cookie('NPMS_Permissions'))) {
                $api = new NPMSController();
                $Project = $api->GetProjectDetailDTOById($NidProject);
                $Scholar = $api->GetAllScholarDetails($Project->ScholarId);
                $ReportDate = substr(new Verta(Carbon::now()), 0, 10);
                $ReportTime = substr(new Verta(Carbon::now()), 10, 10);
                $ConfidentLevel = $Project->IsConfident;
                $api->AddLog(auth()->user(), $request->ip(), 40, 0, 2, 1, sprintf("جزییات طرح %s", $Project->Subject));
                $result->Html = view('Project.PrintProjectDetail', compact('Project', 'Scholar', 'ReportDate', 'ReportTime', 'ConfidentLevel'))->render();
                $result->HasValue = true;
                return response()->json($result);
            } else {
                $result->HasValue = false;
                return response()->json($result);
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function ProjectProgress(string $NidProject, Request $request)
    {
        try {
            if ($this->CheckAuthority(true, 1, $request->cookie('NPMS_Permissions'))) {
                $api = new NPMSController();
                $Project = $api->GetProjectDTOById($NidProject);
                if ($Project->IsConfident) {
                    if (!$this->CheckAuthority(true, 6, $request->cookie('NPMS_Permissions'))) {
                        return view('errors.401');
                    }
                }
                $Scholars = $api->GetAllProjectScholars();
                $UnitGroups = $api->GetAllUnitGroups();
                $Units = $api->GetAllUnits();
                $datafiles = $api->GetProjectFiles($NidProject);
                $api->AddLog(auth()->user(), $request->ip(), 1, 0, 2, 1, "پیشرفت طرح");
                return view('Project.ProjectProgress', compact('Scholars', 'UnitGroups', 'Units', 'Project','datafiles'));
            } else {
                return view('errors.401');
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function UpdateProject(ProjectRequest $Project)
    {
        $Project->validated();
        $api = new NPMSController();
        $result = new JsonResults();
        if ($api->ProjectProgress($Project)) {
            $result->HasValue = true;
            $result->Message = "طرح با موفقیت ویرایش گردید";
            $api->AddLog(auth()->user(), $Project->ip(), 3, 0, 3, 1, sprintf("پیشرفت طرح موفق.نام طرح : %s", $Project->Subject));
            return response()->json($result);
        } else {
            $result->HasValue = false;
            $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
            $api->AddLog(auth()->user(), $Project->ip(), 3, 1, 3, 1, "پیشرفت طرح ناموفق");
            return response()->json($result);
        }
        try {

        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
        // return $Project;
    }
    public function DeleteProject(string $NidProject)
    {
        try {
            $api = new NPMSController();
            $result = new JsonResults();
            $result->HasValue = $api->DeleteProject($NidProject);
            $files = $api->GetProjectFiles($NidProject);
            foreach ($files as $file) {
                File::delete(public_path($file->FilePath));
                $api->DeleteFile($file->NidFile);
            }
            return response()->json($result);
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function ManageBaseInfo(Request $request)
    {
        try {
            if ($this->CheckAuthority(false, 1, $request->cookie('NPMS_Permissions'), 6)) {
                $api = new NPMSController();
                $UnitGroups = $api->GetAllUnitGroups();
                $Units = $api->GetAllUnits();
                $Majors = $api->GetMajors();
                $CollaborationTypes = $api->GetCollaborationTypes();
                $MillitaryStatuses = $api->GetMillitaryStatuses();
                $Oreintations = $api->GetOrientations();
                $Colleges = $api->GetColleges();
                $Grades = $api->GetGrades();
                $api->AddLog(auth()->user(), $request->ip(), 1, 0, 1, 1, "مدیریت اطلاعات پایه");
                return view('Project.ManageBaseInfo', compact('UnitGroups', 'Units', 'Majors', 'CollaborationTypes', 'MillitaryStatuses', 'Oreintations', 'Colleges', 'Grades'));
            } else {
                return view('errors.401');
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SubmitUnitForm(TitleRequest $unit)
    {
        try {
            $unit->validated();
            $api = new NPMSController();
            $result = new JsonResults();
            if (empty($unit->NidUnit)) {
                $unitname = $api->AddUnit($unit);
                $api->AddLog(auth()->user(), $unit->ip(), 4, 0, 3, 1, sprintf("ایجاد یگان موفق.نام یگان : %s", $unit->Title));
                $result->Message = sprintf("یگان با نام %s با موفقیت ایجاد گردید", $unit->Title);
            } else {
                $unitname = $api->UpdateUnit($unit);
                $api->AddLog(auth()->user(), $unit->ip(), 5, 0, 3, 1, sprintf("ویرایش یگان موفق.نام یگان : %s", $unit->Title));
                $result->Message = sprintf("یگان با نام %s با موفقیت ویرایش گردید", $unit->Title);
            }
            $TblId = 1;
            $Units = $api->GetAllUnits();
            $result->Html = view('Project._BaseInfoTables', compact('TblId', 'Units'))->render();
            $result->HasValue = true;
            $result->AltProp = $unit->NidUnit;
            return response()->json($result);
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SubmitUnitGroupForm(TitleRequest $unitGroup)
    {
        try {
            $unitGroup->validated();
            $api = new NPMSController();
            $result = new JsonResults();
            if (empty($unitGroup->NidGroup)) {
                $unitgroupname = $api->AddUnitGroup($unitGroup);
                $api->AddLog(auth()->user(), $unitGroup->ip(), 4, 0, 3, 1, sprintf("ایجاد گروه موفق.نام گروه : %s", $unitGroup->Title));
                $result->Message = sprintf("گروه با نام %s با موفقیت ایجاد گردید", $unitGroup->Title);
            } else {
                $unitgroupname = $api->UpdateUnitGroup($unitGroup);
                $api->AddLog(auth()->user(), $unitGroup->ip(), 5, 0, 3, 1, sprintf("ویرایش گروه موفق.نام گروه : %s", $unitGroup->Title));
                $result->Message = sprintf("گروه با نام %s با موفقیت ویرایش گردید", $unitGroup->Title);
            }
            $TblId = 2;
            $Units = $api->GetAllUnits();
            $UnitGroups = $api->GetAllUnitGroups();
            $result->Html = view('Project._BaseInfoTables', compact('TblId', 'Units', 'UnitGroups'))->render();
            $result->HasValue = true;
            // $result->AltProp = $unit->NidUnit;
            return response()->json($result);
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SubmitGradeForm(Request $grade)
    {
        try {
            $api = new NPMSController();
            $result = new JsonResults();
            if (empty($grade->NidSetting)) {
                $grade->SettingValue = $api->GenerateSettingValue(1);
                if ($api->AddSetting($grade)) {
                    $result->Message = sprintf("مقطع تحصیلی با نام %s با موفقیت ایجاد گردید", $grade->SettingTitle);
                    $api->AddLog(auth()->user(), $grade->ip(), 4, 0, 3, 1, sprintf("ایجاد مقطع تحصیلی موفق.نام مقطع : %s", $grade->SettingTitle));
                } else {
                    $result->HasValue = false;
                    $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
                    $api->AddLog(auth()->user(), $grade->ip(), 4, 1, 3, 1, "ایجاد مقطع تحصیلی ناموفق");
                    return response()->json($result);
                }
            } else {
                $grade->IsDeleted = false;
                if ($api->UpdateSetting($grade)) {
                    $result->Message = sprintf("مقطع تحصیلی با نام %s با موفقیت ویرایش گردید", $grade->SettingTitle);
                    $api->AddLog(auth()->user(), $grade->ip(), 5, 0, 3, 1, "ویرایش مقطع تحصیلی موفق");
                } else {
                    $result->HasValue = false;
                    $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
                    $api->AddLog(auth()->user(), $grade->ip(), 5, 1, 3, 1, sprintf("ویرایش مقطع تحصیلی موفق.نام مقطع : %s", $grade->SettingTitle));
                    return response()->json($result);
                }
            }
            $TblId = 3;
            $Grades = $api->GetGrades();
            $result->Html = view('Project._BaseInfoTables', compact('TblId', 'Grades'))->render();
            $result->HasValue = true;
            return response()->json($result);
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SubmitMajorForm(TitleRequest $major)
    {
        try {
            $major->validated();
            $api = new NPMSController();
            $result = new JsonResults();
            if (empty($major->NidMajor)) {
                $api->AddMajor($major);
                $result->Message = sprintf("رشته تحصیلی با نام %s با موفقیت ایجاد گردید", $major->Title);
                $api->AddLog(auth()->user(), $major->ip(), 4, 0, 3, 1, sprintf("ایجاد رشته تحصیلی موفق.نام رشته : %s", $major->Title));
            } else {
                $api->UpdateMajor($major);
                $result->Message = sprintf("رشته تحصیلی با نام %s با موفقیت ویرایش گردید", $major->Title);
                $api->AddLog(auth()->user(), $major->ip(), 5, 0, 3, 1, sprintf("ویرایش رشته تحصیلی موفق.نام رشته : %s", $major->Title));
            }
            $TblId = 4;
            $Majors = $api->GetMajors();
            $result->Html = view('Project._BaseInfoTables', compact('TblId', 'Majors'))->render();
            $result->HasValue = true;
            $result->AltProp = $major->NidMajor;
            return response()->json($result);
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SubmitOreintationForm(TitleRequest $oreintation)
    {
        try {
            $oreintation->validated();
            $api = new NPMSController();
            $result = new JsonResults();
            if (empty($oreintation->NidOreintation)) {
                $api->AddOreintation($oreintation);
                $result->Message = sprintf("گرایش با نام %s با موفقیت ایجاد گردید", $oreintation->Title);
                $api->AddLog(auth()->user(), $oreintation->ip(), 4, 0, 3, 1, sprintf("ایجاد گرایش موفق.نام گرایش : %s", $oreintation->Title));
            } else {
                $api->UpdateOreintation($oreintation);
                $result->Message = sprintf("گرایش با نام %s با موفقیت ویرایش گردید", $oreintation->Title);
                $api->AddLog(auth()->user(), $oreintation->ip(), 5, 0, 3, 1, sprintf("ویرایش گرایش موفق.نام گرایش : %s", $oreintation->Title));
            }
            $TblId = 5;
            $Majors = $api->GetMajors();
            $Oreintations = $api->GetOrientations();
            $result->Html = view('Project._BaseInfoTables', compact('TblId', 'Majors', 'Oreintations'))->render();
            $result->HasValue = true;
            return response()->json($result);
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SubmitCollegeForm(Request $college)
    {
        try {
            $api = new NPMSController();
            $result = new JsonResults();
            if (empty($college->NidSetting)) {
                $college->SettingValue = $api->GenerateSettingValue(2);
                if ($api->AddSetting($college)) {
                    $result->Message = sprintf("دانشکده با نام %s با موفقیت ایجاد گردید", $college->SettingTitle);
                    $api->AddLog(auth()->user(), $college->ip(), 4, 0, 3, 1, sprintf("ایجاد دانشکده موفق.نام دانشکده : %s", $college->SettingTitle));
                } else {
                    $result->HasValue = false;
                    $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
                    $api->AddLog(auth()->user(), $college->ip(), 4, 1, 3, 1, "ایجاد دانشکده ناموفق");
                    return response()->json($result);
                }
            } else {
                $college->IsDeleted = false;
                if ($api->UpdateSetting($college)) {
                    $result->Message = sprintf("دانشکده با نام %s با موفقیت ویرایش گردید", $college->SettingTitle);
                    $api->AddLog(auth()->user(), $college->ip(), 5, 0, 3, 1, sprintf("ویرایش دانشکده موفق.نام دانشکده : %s", $college->SettingTitle));
                } else {
                    $result->HasValue = false;
                    $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
                    $api->AddLog(auth()->user(), $college->ip(), 5, 1, 3, 1, "ویرایش دانشکده ناموفق");
                    return response()->json($result);
                }
            }
            $TblId = 6;
            $Colleges = $api->GetColleges();
            $result->Html = view('Project._BaseInfoTables', compact('TblId', 'Colleges'))->render();
            $result->HasValue = true;
            return response()->json($result);
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SubmitMillitForm(Request $millit)
    {
        try {
            $api = new NPMSController();
            $result = new JsonResults();
            if (empty($millit->NidSetting)) {
                $millit->SettingValue = $api->GenerateSettingValue(3);
                if ($api->AddSetting($millit)) {
                    $result->Message = sprintf("وضعیت خدمت با نام %s با موفقیت ایجاد گردید", $millit->SettingTitle);
                    $api->AddLog(auth()->user(), $millit->ip(), 4, 0, 3, 1, sprintf("ایجاد وضعیت خدمت موفق.نام وضعیت خدمت : %s", $millit->SettingTitle));
                } else {
                    $result->HasValue = false;
                    $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
                    $api->AddLog(auth()->user(), $millit->ip(), 4, 1, 3, 1, "ایجاد وضعیت خدمت ناموفق");
                    return response()->json($result);
                }
            } else {
                $millit->IsDeleted = false;
                if ($api->UpdateSetting($millit)) {
                    $result->Message = sprintf("وضعیت خدمت با نام %s با موفقیت ویرایش گردید", $millit->SettingTitle);
                    $api->AddLog(auth()->user(), $millit->ip(), 5, 0, 3, 1, sprintf("ویرایش وضعیت خدمت موفق.نام وضعیت خدمت : %s", $millit->SettingTitle));
                } else {
                    $result->HasValue = false;
                    $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
                    $api->AddLog(auth()->user(), $millit->ip(), 5, 1, 3, 1, "ویرایش وضعیت خدمت ناموفق");
                    return response()->json($result);
                }
            }
            $TblId = 7;
            $MillitaryStatuses = $api->GetMillitaryStatuses();
            $result->Html = view('Project._BaseInfoTables', compact('TblId', 'MillitaryStatuses'))->render();
            $result->HasValue = true;
            return response()->json($result);
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SubmitCollabForm(Request $collab)
    {
        try {
            $api = new NPMSController();
            $result = new JsonResults();
            if (empty($collab->NidSetting)) {
                $collab->SettingValue = $api->GenerateSettingValue(4);
                if ($api->AddSetting($collab)) {
                    $result->Message = sprintf("نوع همکاری با نام %s با موفقیت ایجاد گردید", $collab->SettingTitle);
                    $api->AddLog(auth()->user(), $collab->ip(), 4, 0, 3, 1, sprintf("ایجاد نوع همکاری موفق.نام نوع همکاری : %s", $collab->SettingTitle));
                } else {
                    $result->HasValue = false;
                    $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
                    $api->AddLog(auth()->user(), $collab->ip(), 4, 1, 3, 1, "ایجاد نوع همکاری ناموفق");
                    return response()->json($result);
                }
            } else {
                $collab->IsDeleted = false;
                if ($api->UpdateSetting($collab)) {
                    $result->Message = sprintf("نوع همکاری با نام %s با موفقیت ویرایش گردید", $collab->SettingTitle);
                    $api->AddLog(auth()->user(), $collab->ip(), 5, 0, 3, 1, sprintf("ویرایش نوع همکاری موفق.نام نوع همکاری : %s", $collab->SettingTitle));
                } else {
                    $result->HasValue = false;
                    $result->Message = "خطا در انجام عملیات.لطفا مجدد امتحان کنید";
                    $api->AddLog(auth()->user(), $collab->ip(), 5, 1, 3, 1, "ویرایش نوع همکاری ناموفق");
                    return response()->json($result);
                }
            }
            $TblId = 8;
            $CollaborationTypes = $api->GetCollaborationTypes();
            $result->Html = view('Project._BaseInfoTables', compact('TblId', 'CollaborationTypes'))->render();
            $result->HasValue = true;
            return response()->json($result);
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SubmitDeleteUnit(string $NidUnit, Request $request)
    {
        try {
            $api = new NPMSController();
            $result = new JsonResults();
            $tmp = $api->GetAllUnits()->where('NidUnit', '=', $NidUnit)->firstOrFail();
            $tmpResult = $api->DeleteUnit($NidUnit);
            $tmpstatus = json_decode($tmpResult->getContent(), true)['Message'];
            $result->HasValue = false;
            switch ($tmpstatus) {
                case "1":
                    $result->Message = "یگان مورد نظر دارای گروه می باشد.امکان حذف وجود ندارد";
                    $api->AddLog(auth()->user(), $request->ip(), 6, 1, 3, 1, sprintf("حذف یگان ناموفق.نام یگان : %s", $tmp->Title));
                    return response()->json($result);
                    break;
                case "2":
                    $result->HasValue = true;
                    $result->Message = "یگان با موفقیت حذف گردید";
                    $api->AddLog(auth()->user(), $request->ip(), 6, 0, 3, 1, sprintf("حذف یگان موفق.نام یگان : %s", $tmp->Title));
                    $TblId = 1;
                    $Units = $api->GetAllUnits();
                    $result->Html = view('Project._BaseInfoTables', compact('TblId', 'Units'))->render();
                    return response()->json($result);
                    break;
                case "3":
                    $result->Message = "خطا در سرور لطفا مجددا امتحان کنید";
                    $api->AddLog(auth()->user(), $request->ip(), 6, 1, 3, 1, sprintf("حذف یگان ناموفق.نام یگان : %s", $tmp->Title));
                    return response()->json($result);
                    break;
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SubmitDeleteUnitGroup(string $NidUnitGroup, Request $request)
    {
        try {
            $api = new NPMSController();
            $result = new JsonResults();
            $result->HasValue = false;
            $tmp = $api->GetAllUnitGroups()->where('NidGroup', '=', $NidUnitGroup)->firstOrFail();
            $tmpResult = $api->DeleteUnitGroup($NidUnitGroup);
            if (json_decode($tmpResult->getContent(), true)['HasValue']) {
                $result->HasValue = true;
                $result->Message = "گروه با موفقیت حذف گردید";
                $api->AddLog(auth()->user(), $request->ip(), 6, 0, 3, 1, sprintf("حذف گروه موفق.نام گروه : %s", $tmp->Title));
                $TblId = 2;
                $Units = $api->GetAllUnits();
                $UnitGroups = $api->GetAllUnitGroups();
                $result->Html = view('Project._BaseInfoTables', compact('TblId', 'Units', 'UnitGroups'))->render();
                return response()->json($result);
            } else {
                $result->Message = "خطا در سرور لطفا مجددا امتحان کنید";
                $api->AddLog(auth()->user(), $request->ip(), 6, 1, 3, 1, sprintf("حذف گروه ناموفق.نام گروه : %s", $tmp->Title));
                return response()->json($result);
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SubmitDeleteGrade(string $NidGrade, Request $request)
    {
        try {
            $api = new NPMSController();
            $result = new JsonResults();
            $result->HasValue = false;
            $tmp = $api->GetGrades()->where('NidSetting', '=', $NidGrade)->firstOrFail();
            $tmpResult = $api->DeleteSetting($NidGrade);
            if (json_decode($tmpResult->getContent(), true)['HasValue']) {
                $result->HasValue = true;
                $result->Message = "مقطع تحصیلی با موفقیت حذف گردید";
                $api->AddLog(auth()->user(), $request->ip(), 6, 0, 3, 1, sprintf("حذف مقطع تحصیلی موفق.نام مقطع : %s", $tmp->Title));
                $TblId = 3;
                $Grades = $api->GetGrades();
                $result->Html = view('Project._BaseInfoTables', compact('TblId', 'Grades'))->render();
                return response()->json($result);
            } else {
                $result->Message = "خطا در سرور لطفا مجددا امتحان کنید";
                $api->AddLog(auth()->user(), $request->ip(), 6, 1, 3, 1, sprintf("حذف مقطع تحصیلی ناموفق.نام مقطع : %s", $tmp->Title));
                return response()->json($result);
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SubmitDeleteMajor(string $NidMajor, Request $request)
    {
        try {
            $api = new NPMSController();
            $result = new JsonResults();
            $tmp = $api->GetMajors()->where('NidMajor', '=', $NidMajor)->firstOrFail();
            $tmpResult = $api->DeleteMajor($NidMajor);
            $tmpstatus = json_decode($tmpResult->getContent(), true)['Message'];
            $result->HasValue = false;
            switch ($tmpstatus) {
                case "1":
                    $result->Message = "رشته تحصیلی مورد نظر دارای گرایش می باشد.امکان حذف وجود ندارد";
                    $api->AddLog(auth()->user(), $request->ip(), 6, 0, 3, 1, sprintf("حذف رشته تحصیلی ناموفق.نام رشته : %s", $tmp->Title));
                    return response()->json($result);
                    break;
                case "2":
                    $result->HasValue = true;
                    $result->Message = "رشته تحصیلی با موفقیت حذف گردید";
                    $TblId = 4;
                    $Majors = $api->GetMajors();
                    $result->Html = view('Project._BaseInfoTables', compact('TblId', 'Majors'))->render();
                    $api->AddLog(auth()->user(), $request->ip(), 6, 0, 3, 1, sprintf("حذف رشته تحصیلی موفق.نام رشته : %s", $tmp->Title));
                    return response()->json($result);
                    break;
                case "3":
                    $result->Message = "خطا در سرور لطفا مجددا امتحان کنید";
                    $api->AddLog(auth()->user(), $request->ip(), 6, 0, 3, 1, sprintf("حذف رشته تحصیلی ناموفق.نام رشته تحصیلی : %s", $tmp->Title));
                    return response()->json($result);
                    break;
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SubmitDeleteOreintation(string $NidOreintation, Request $request)
    {
        try {
            $api = new NPMSController();
            $result = new JsonResults();
            $result->HasValue = false;
            $tmp = $api->GetOrientations()->where('NidOreintation', '=', $NidOreintation)->firstOrFail();
            $tmpResult = $api->DeleteOreintation($NidOreintation);
            if (json_decode($tmpResult->getContent(), true)['HasValue']) {
                $result->HasValue = true;
                $result->Message = "گرایش با موفقیت حذف گردید";
                $api->AddLog(auth()->user(), $request->ip(), 6, 0, 3, 1, sprintf("حذف گرایش موفق.نام گرایش : %s", $tmp->Title));
                $TblId = 5;
                $Majors = $api->GetMajors();
                $Oreintations = $api->GetOrientations();
                $result->Html = view('Project._BaseInfoTables', compact('TblId', 'Majors', 'Oreintations'))->render();
                return response()->json($result);
            } else {
                $result->Message = "خطا در سرور لطفا مجددا امتحان کنید";
                $api->AddLog(auth()->user(), $request->ip(), 6, 1, 3, 1, sprintf("حذف گرایش ناموفق.نام گرایش : %s", $tmp->Title));
                return response()->json($result);
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SubmitDeleteCollege(string $NidCollege, Request $request)
    {
        try {
            $api = new NPMSController();
            $result = new JsonResults();
            $result->HasValue = false;
            $tmp = $api->GetColleges()->where('NidSetting', '=', $NidCollege)->firstOrFail();
            $tmpResult = $api->DeleteSetting($NidCollege);
            if (json_decode($tmpResult->getContent(), true)['HasValue']) {
                $result->HasValue = true;
                $result->Message = "دانشکده با موفقیت حذف گردید";
                $api->AddLog(auth()->user(), $request->ip(), 6, 0, 3, 1, sprintf("حذف دانشکده موفق.نام دانشکده : %s", $tmp->Title));
                $TblId = 6;
                $Colleges = $api->GetColleges();
                $result->Html = view('Project._BaseInfoTables', compact('TblId', 'Colleges'))->render();
                return response()->json($result);
            } else {
                $result->Message = "خطا در سرور لطفا مجددا امتحان کنید";
                $api->AddLog(auth()->user(), $request->ip(), 6, 1, 3, 1, sprintf("حذف دانشکده ناموفق.نام دانشکده : %s", $tmp->Title));
                return response()->json($result);
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SubmitDeleteMillit(string $NidMillit, Request $request)
    {
        try {
            $api = new NPMSController();
            $result = new JsonResults();
            $result->HasValue = false;
            $tmp = $api->GetMillitaryStatuses()->where('NidSetting', '=', $NidMillit)->firstOrFail();
            $tmpResult = $api->DeleteSetting($NidMillit);
            if (json_decode($tmpResult->getContent(), true)['HasValue']) {
                $result->HasValue = true;
                $result->Message = "وضعیت خدمت با موفقیت حذف گردید";
                $api->AddLog(auth()->user(), $request->ip(), 6, 0, 3, 1, sprintf("حذف وضعیت خدمت موفق.نام وضعیت خدمت : %s", $tmp->Title));
                $TblId = 7;
                $MillitaryStatuses = $api->GetMillitaryStatuses();
                $result->Html = view('Project._BaseInfoTables', compact('TblId', 'MillitaryStatuses'))->render();
                return response()->json($result);
            } else {
                $result->Message = "خطا در سرور لطفا مجددا امتحان کنید";
                $api->AddLog(auth()->user(), $request->ip(), 6, 1, 3, 1, sprintf("حذف وضعیت خدمت ناموفق.نام وضعیت خدمت : %s", $tmp->Title));
                return response()->json($result);
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SubmitDeleteCollab(string $NidCollab, Request $request)
    {
        try {
            $api = new NPMSController();
            $result = new JsonResults();
            $result->HasValue = false;
            $tmp = $api->GetCollaborationTypes()->where('NidSetting', '=', $NidCollab)->firstOrFail();
            $tmpResult = $api->DeleteSetting($NidCollab);
            if (json_decode($tmpResult->getContent(), true)['HasValue']) {
                $result->HasValue = true;
                $result->Message = "نوع همکاری با موفقیت حذف گردید";
                $api->AddLog(auth()->user(), $request->ip(), 6, 0, 3, 1, sprintf("حذف نوع همکاری موفق.نام نوع همکاری : %s", $tmp->Title));
                $TblId = 8;
                $CollaborationTypes = $api->GetCollaborationTypes();
                $result->Html = view('Project._BaseInfoTables', compact('TblId', 'CollaborationTypes'))->render();
                return response()->json($result);
            } else {
                $result->Message = "خطا در سرور لطفا مجددا امتحان کنید";
                $api->AddLog(auth()->user(), $request->ip(), 6, 1, 3, 1, sprintf("حذف نوع همکاری ناموفق.نام نوع همکاری : %s", $tmp->Title));
                return response()->json($result);
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
}
