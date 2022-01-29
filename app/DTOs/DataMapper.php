<?php

namespace App\DTOs;

use App\Domains\Repositories\ReportRawData;
use App\Models\Alarms;
use App\Models\Majors;
use App\Models\Messages;
use App\Models\Oreintations;
use App\Models\Projects;
use App\Models\ReportParameters;
use App\Models\Reports;
use App\Models\Resources;
use App\Models\RolePermissions;
use App\Models\Roles;
use App\Models\Scholars;
use App\Models\Settings;
use App\Models\UnitGroups;
use App\Models\Units;
use App\Models\User;
use App\Models\UserPermissions;
use App\Models\Users;
use Brick\Math\BigInteger;
use DateTime;
use Hekmatinasser\Verta\Facades\Verta;
use Hekmatinasser\Verta\Verta as VertaVerta;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Guid\Guid;

class DataMapper
{
    public static function MapToMajorDTO(Majors $major)
    {
        try
        {
            $result = new majorDTO();
            $result->NidMajor = $major->NidMajor;
            $result->Title = $major->Title;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToOreintationDTO(Oreintations $oreintation)
    {
        try
        {
            $result = new OrientationDTO();
            $result->NidOreintation = $oreintation->NidOreintation;
            $result->MajorId = $oreintation->MajorId;
            $result->Title = $oreintation->Title;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToProjectDTO(Projects $project)
    {
        try
        {
            $result = new projectDTO();
            $result->NidProject = $project->NidProject;
            $result->ProjectNumber = BigInteger::of($project->ProjectNumber);
            $result->Subject = $project->Subject;
            $result->ProjectStatus = $project->ProjectStatus;
            $result->ScholarId = $project->ScholarId;
            $result->UnitId = $project->UnitId;
            $result->GroupId = $project->GroupId;
            $result->Supervisor = $project->Supervisor ?? "";
            $result->SupervisorMobile = $project->SupervisorMobile ?? "";
            $result->Advisor = $project->Advisor ?? "";
            $result->AdvisorMobile = $project->AdvisorMobile ?? "";
            $result->Referee1 = $project->Referee1 ?? "";
            $result->Referee2 = $project->Referee2 ?? "";
            $result->Editor = $project->Editor ?? "";
            $result->CreateDate = $project->CreateDate;
            $result->PersianCreateDate = $project->PersianCreateDate;
            $result->TenPercentLetterDate = $project->TenPercentLetterDate ?? "";
            $result->PreImploymentLetterDate = $project->PreImploymentLetterDate ?? "";
            $result->ImploymentDate = $project->ImploymentDate ?? "";
            $result->SecurityLetterDate = $project->SecurityLetterDate ?? "";
            $result->ThesisDefenceDate = $project->ThesisDefenceDate ?? "";
            $result->ThesisDefenceLetterDate = $project->ThesisDefenceLetterDate ?? "";
            $result->ReducePeriod = $project->ReducePeriod ?? 0;
            $result->Commision = $project->Commision ?? "";
            $result->HasBookPublish = boolval($project->HasBookPublish) ?? false;
            $result->UserId = $project->UserId;
            $result->TitleApproved = boolval($project->TitleApproved) ?? false;
            $result->ThirtyPercentLetterDate = $project->ThirtyPercentLetterDate ?? "";
            $result->SixtyPercentLetterDate = $project->SixtyPercentLetterDate ?? "";
            $result->ATFLetterDate = $project->ATFLetterDate ?? "";
            $result->FinalApprove = boolval($project->FinalApprove) ?? false;
            $result->IsConfident = boolval($project->IsConfident) ?? false;
            $result->IsDisabled = boolval($project->IsDisabled) ?? false;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToProjectDetailDTO(Projects $project)
    {
        try
        {
            $result = new projectDetailDTO();
            $result->NidProject = $project->NidProject;
            $result->ProjectNumber = BigInteger::of($project->ProjectNumber);
            $result->Subject = $project->Subject;
            $result->ProjectStatus = $project->ProjectStatus;
            $result->ScholarId = $project->ScholarId;
            if(Scholars::all()->where('NidScholar','=',$project->ScholarId)->count() > 0)
            $result->ScholarTitle = Scholars::all()->where('NidScholar','=',$project->ScholarId)->firstOrFail()->FirstName.' '.Scholars::all()->where('NidScholar','=',$project->ScholarId)->firstOrFail()->LastName;
            else
            $result->ScholarTitle = "";
            $result->UnitId = $project->UnitId;
            if(Units::all()->where('NidUnit','=',$project->UnitId)->count() > 0)
            $result->UnitTitle = Units::all()->where('NidUnit','=',$project->UnitId)->firstOrFail()->Title;
            else
            $result->UnitTitle = "";//check
            $result->GroupId = $project->GroupId;
            if(UnitGroups::all()->where('NidGroup','=',$project->GroupId)->count() > 0)
            $result->GroupTitle = UnitGroups::all()->where('NidGroup','=',$project->GroupId)->firstOrFail()->Title;
            else
            $result->GroupTitle = "";//check
            $result->Supervisor = $project->Supervisor;
            $result->SupervisorMobile = $project->SupervisorMobile;
            $result->Advisor = $project->Advisor;
            $result->AdvisorMobile = $project->AdvisorMobile;
            $result->Referee1 = $project->Referee1 ?? "";
            $result->Referee2 = $project->Referee2 ?? "";
            $result->Editor = $project->Editor ?? "";
            $result->CreateDate = $project->CreateDate;
            $result->PersianCreateDate = $project->PersianCreateDate;
            $result->TenPercentLetterDate = $project->TenPercentLetterDate ?? "";
            $result->PreImploymentLetterDate = $project->PreImploymentLetterDate ?? "";
            $result->ImploymentDate = $project->ImploymentDate ?? "";
            $result->SecurityLetterDate = $project->SecurityLetterDate ?? "";
            $result->ThesisDefenceDate = $project->ThesisDefenceDate ?? "";
            $result->ThesisDefenceLetterDate = $project->ThesisDefenceLetterDate ?? "";
            $result->ReducePeriod = $project->ReducePeriod ?? 0;
            $result->Commision = $project->Commision ?? "";
            $result->HasBookPublish = boolval($project->HasBookPublish);
            $result->UserId = $project->UserId;
            if(User::all()->where('NidUser','=',$project->UserId)->count() > 0)
            $result->UserTitle = User::all()->where('NidUser','=',$project->UserId)->firstOrFail()->UserName;
            else
            $result->UserTitle = "";//check
            $result->TitleApproved = boolval($project->TitleApproved);
            $result->ThirtyPercentLetterDate = $project->ThirtyPercentLetterDate ?? "";
            $result->SixtyPercentLetterDate = $project->SixtyPercentLetterDate ?? "";
            $result->ATFLetterDate = $project->ATFLetterDate ?? "";
            $result->FinalApprove = boolval($project->FinalApprove)?? false;
            $result->IsConfident = boolval($project->IsConfident) ?? false;
            $result->IsDisabled = boolval($project->IsDisabled) ?? false;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToProjectInitialDTO(Projects $project)
    {
        try
        {
            $result = new projectInitialDTO();
            $result->NidProject = $project->NidProject;
            $result->ProjectNumber = BigInteger::of($project->ProjectNumber);
            $result->Subject = $project->Subject;
            $result->ProjectStatus = $project->ProjectStatus;
            $result->ScholarId = $project->ScholarId;
            if(Scholars::all()->where('NidScholar','=',$project->ScholarId)->count() > 0)
            $result->ScholarName = Scholars::all()->where('NidScholar','=',$project->ScholarId)->firstOrFail()->FirstName.' '.Scholars::all()->where('NidScholar','=',$project->ScholarId)->firstOrFail()->LastName;
            else
            $result->ScholarName = "";
            $result->UnitId = $project->UnitId;
            if(Units::all()->where('NidUnit','=',$project->UnitId)->count() > 0)
            $result->UnitName = Units::all()->where('NidUnit','=',$project->UnitId)->firstOrFail()->Title;
            else
            $result->UnitName = "";
            $result->GroupId = $project->GroupId;
            if(UnitGroups::all()->where('NidGroup','=',$project->GroupId)->count() > 0)
            $result->GroupName = UnitGroups::all()->where('NidGroup','=',$project->GroupId)->firstOrFail()->Title;
            else
            $result->GroupName = "";
            $result->Supervisor = $project->Supervisor ?? "";
            $result->SupervisorMobile = $project->SupervisorMobile ?? "";
            $result->Advisor = $project->Advisor ?? "";
            $result->AdvisorMobile = $project->AdvisorMobile ?? "";
            $result->CreateDate = new DateTime($project->CreateDate);
            $result->PersianCreateDate = $project->PersianCreateDate;
            $result->UserId = $project->UserId;
            $result->ATFLetterDate = $project->ATFLetterDate ?? "";
            $result->IsDisabled = boolval($project->IsDisabled) ?? false;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToProjectInitialDTOFromRequest(Request $project)
    {
        try
        {
            $result = new projectInitialDTO();
            $result->NidProject = $project->NidProject;
            $result->ProjectNumber = $project->ProjectNumber;
            $result->Subject = $project->Subject;
            $result->ProjectStatus = $project->ProjectStatus;
            $result->ScholarId = $project->ScholarId;
            $result->ScholarName = $project->Scholar->Title;//check
            $result->UnitId = $project->UnitId;
            $result->UnitName = $project->Unit->Title;//check
            $result->GroupId = $project->GroupId;
            $result->GroupName = $project->unit_group->Title;//check
            $result->Supervisor = $project->Supervisor;
            $result->SupervisorMobile = $project->SupervisorMobile;
            $result->Advisor = $project->Advisor;
            $result->AdvisorMobile = $project->AdvisorMobile;
            $result->CreateDate = $project->CreateDate;
            $result->PersianCreateDate = $project->PersianCreateDate;
            $result->UserId = $project->UserId;
            $result->ATFLetterDate = $project->ATFLetterDate;
            $result->IsDisabled = boolval($project->IsDisabled) ?? false;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToProjectFromProjectInitialDTO(ProjectInitialDTO $projectInitial)
    {
        try
        {
            $result = new Projects();
            $result->NidProject = $projectInitial->NidProject;
            $result->ProjectNumber = $projectInitial->ProjectNumber;
            $result->Subject = $projectInitial->Subject;
            $result->ProjectStatus = $projectInitial->ProjectStatus;
            $result->ScholarId = $projectInitial->ScholarId;
            $result->ScholarName = $projectInitial->Scholar->Title;//check
            $result->UnitId = $projectInitial->UnitId;
            $result->UnitName = $projectInitial->Unit->Title;//check
            $result->GroupId = $projectInitial->GroupId;
            $result->GroupName = $projectInitial->unit_group->Title;//check
            $result->Supervisor = $projectInitial->Supervisor;
            $result->SupervisorMobile = $projectInitial->SupervisorMobile;
            $result->Advisor = $projectInitial->Advisor;
            $result->AdvisorMobile = $projectInitial->AdvisorMobile;
            $result->CreateDate = $projectInitial->CreateDate;
            $result->PersianCreateDate = $projectInitial->PersianCreateDate;
            $result->UserId = $projectInitial->UserId;
            $result->ATFLetterDate = $projectInitial->ATFLetterDate;
            $result->IsDisabled = boolval($projectInitial->IsDisabled) ?? false;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToScholarDTO(Scholars $scholar)
    {
        try
        {
            $result = new scholarDTO();
            $result->NidScholar = $scholar->NidScholar;
            $result->FirstName = $scholar->FirstName;
            $result->LastName = $scholar->LastName;
            $result->NationalCode = $scholar->NationalCode;
            $result->BirthDate = $scholar->BirthDate;
            $result->FatherName = $scholar->FatherName;
            $result->Mobile = $scholar->Mobile;
            $result->MillitaryStatus = $scholar->MillitaryStatus;
            $result->GradeId = $scholar->GradeId;
            $result->MajorId = $scholar->MajorId;
            $result->OreintationId = $scholar->OreintationId;
            $result->college = $scholar->college;
            $result->CollaborationType = $scholar->CollaborationType;
            $result->ProfilePicture = $scholar->ProfilePicture ?? "";
            $result->UserId = $scholar->UserId;
            $result->IsDeleted = boolval($scholar->IsDeleted);
            $result->DeleteDate = $scholar->DeleteDate;
            $result->DeleteUser = $scholar->DeleteUser;
            $result->IsConfident = boolval($scholar->IsConfident);
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToScholarListDTO(Scholars $scholar)
    {
        try
        {
            $result = new scholarListDTO();
            $result->NidScholar = $scholar->NidScholar;
            $result->FirstName = $scholar->FirstName;
            $result->LastName = $scholar->LastName;
            $result->NationalCode = $scholar->NationalCode;
            if(Settings::all()->where('SettingKey','=','GradeId')->where('SettingValue','=',$scholar->GradeId)->count() > 0)
            $result->Grade = Settings::all()->where('SettingKey','=','GradeId')->where('SettingValue','=',$scholar->GradeId)->firstOrFail()->SettingTitle;//$scholar->GradeId ?? "";
            else
            $result->Grade = "";
            if(Majors::all()->where('NidMajor','=',$scholar->MajorId)->count() > 0)
            $result->MajorName = Majors::all()->where('NidMajor','=',$scholar->MajorId)->firstOrFail()->Title;//check
            else
            $result->MajorName = "";
            if(Oreintations::all()->where('NidOrientation','=',$scholar->OrientationId)->count() > 0)
            $result->OreintationName = Oreintations::all()->where('NidOrientation','=',$scholar->OrientationId)->firstOrFail()->Title;//check
            else
            $result->OreintationName = "";
            $result->collegeName = $scholar->college;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToScholarDetailDTO(Scholars $scholar)
    {
        try
        {
            $result = new scholarDetailDTO();
            $result->NidScholar = $scholar->NidScholar;
            $result->FirstName = $scholar->FirstName ?? "";
            $result->LastName = $scholar->LastName;
            $result->NationalCode = $scholar->NationalCode;
            $result->BirthDate = $scholar->BirthDate ?? "";
            $result->FatherName = $scholar->FatherName;
            $result->Mobile = $scholar->Mobile;
            $result->MillitaryStatusTitle = $scholar->MillitaryStatus;
            $result->GradeTitle = $scholar->GradeId;//check
            $result->Major = new majorDTO();//check
            $result->Oreintation = new OrientationDTO();//check
            $result->CollegeTitle = $scholar->college;
            $result->CollaborationTypeTitle = $scholar->CollaborationType;
            $result->ProfilePicture = $scholar->ProfilePicture ?? "";
            $result->IsConfident = boolval($scholar->IsConfident) ?? false;
            $result->Projects = new Collection();//check
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToUnitDTO(Units $unit)
    {
        try
        {
            $result = new unitDTO();
            $result->NidUnit = $unit->NidUnit;
            $result->Title = $unit->Title;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToUnitGroupDTO(UnitGroups $unitgroup)
    {
        try
        {
            $result = new unitGroupDTO();
            $result->NidGroup = $unitgroup->NidGroup;
            $result->UnitId = $unitgroup->UnitId;
            $result->Title = $unitgroup->Title;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToUserDTO(User $user)
    {
        $result = new userDTO();
        $result->NidUser = $user->NidUser;
        $result->Username = $user->UserName;
        $result->Password = $user->Password;
        $result->FirstName = $user->FirstName;
        $result->LastName = $user->LastName;
        $result->CreateDate = $user->CreateDate;
        $result->LastLoginDate = $user->LastLoginDate;
        $result->IncorrectPasswordCount = $user->IncorrectPasswordCount;
        $result->IsLockedOut = boolval($user->IsLockedOut);
        $result->IsDisabled = boolval($user->IsDisabled);
        $result->ProfilePicture = $user->ProfilePicture;
        $result->RoleTitle = Roles::all()->where('NidRole','=',$user->RoleId)->firstOrFail()->Title;
        $result->RoleId = $user->RoleId;
        return $result;
        try
        {
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToUserInPermissionDTO(User $user)
    {
        $result = new userInPermissionDTO();
        $result->NidUser = $user->NidUser;
        $result->Username = $user->UserName;
        $result->FirstName = $user->FirstName;
        $result->LastName = $user->LastName;
        $result->RoleTitle = Roles::all()->where('NidRole','=',$user->RoleId)->firstOrFail()->Title;
        return $result;
        try
        {
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToResourceDTO(Resources $resource)
    {
        try
        {
            $result = new resourceDTO();
            $result->NidResource = $resource->NidResource;
            $result->ResourceName = $resource->ResourceName;
            $result->ParentId = $resource->ParentId;
            $result->ClassLevel = $resource->ClassLevel;
            $result->SortNumber = $resource->SortNumber;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToUserPermissionDTO(UserPermissions $userpermission)
    {
        try
        {
            $result = new userPermissionDTO();
            $result->NidPermission = $userpermission->NidPermission;
            $result->UserId = $userpermission->UserId;
            $result->ResourceId = $userpermission->ResourceId;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToRolePermissionDTO(RolePermissions $rolepermission)
    {
        try
        {
            $result = new RolePermissionDTO();
            $result->NidPermission = $rolepermission->NidPermission;
            $result->RoleId = $rolepermission->RoleId;
            $result->EntityId = $rolepermission->EntityId;
            $result->Create = boolval($rolepermission->Create);
            $result->Edit = boolval($rolepermission->Edit);
            $result->Delete = boolval($rolepermission->Delete);
            $result->Detail = boolval($rolepermission->Detail);
            $result->Confident = boolval($rolepermission->Confident);
            $result->List = boolval($rolepermission->List);
            $result->Print = boolval($rolepermission->Print);
            $result->RoleTitle = Roles::all()->where('NidRole','=',$rolepermission->RoleId)->firstOrFail()->Title;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToMessageDTO(Messages $message)
    {
        try
        {
            $result = new messageDTO();
            $result->NidMessage = $message->NidMessage;
            $result->SenderId = $message->SenderId;
            $result->RecieverId = $message->RecieverId;
            $result->RelatedId = $message->RelatedId;
            $result->Title = $message->Title;
            $result->MessageContent = $message->MessageContent;
            $result->IsRead = $message->IsRead;
            $result->IsRecieved = $message->IsRecieved;
            $result->IsDeleted = $message->IsDeleted;
            $tmpSender = User::all()->where('NidUser','=',$message->SenderId)->firstOrFail();
            $result->SenderUsername = $tmpSender->UserName ?? "";
            $result->SenderName = $tmpSender->FirstName.' '.$tmpSender->LastName ?? "";
            $tmpReciever = User::all()->where('NidUser','=',$message->RecieverId)->firstOrFail();
            $result->RecieverUsername = $tmpReciever->UserName ?? "";
            $result->RecieverName = $tmpReciever->FirstName.' '.$tmpReciever->LastName ?? "";
            $result->CreateDate = $message->CreateDate;
            $result->PersianCreateDate = verta($message->CreateDate);
            $result->ReadDate = $message->ReadDate ?? "";
            $result->DeleteDate = $message->DeleteDate ?? "";
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToReportDTO(Reports $report)
    {
        try
        {
            $result = new reportDTO();
            $result->NidReport = $report->NidReport;
            $result->ReportName = $report->ReportName;
            $result->ContextId = $report->ContextId;
            $result->FieldId = $report->FieldId;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToReportParameterDTO(ReportParameters $reportParameter)
    {
        try
        {
            $result = new reportParameterDTO();
            $result->NidParameter = $reportParameter->NidParameter;
            $result->ReportId = $reportParameter->ReportId;
            $result->ParameterKey = $reportParameter->ParameterKey;
            $result->ParameterValue = $reportParameter->ParameterValue ?? "";
            $result->IsDeleted = boolval($reportParameter->IsDeleted);
            $result->Type = $reportParameter->Type;
            return $result;
        }
        catch (\Exception $e)
        {
            return null;
        }
    }
    public static function MapToAlarm(Request $alarm)
    {
        try
        {
            $result = new Alarms();
            $result->NidAlarm = $alarm->NidAlarm;
            $result->NidMaster = $alarm->NidMaster;
            $result->AlarmSubject = $alarm->AlarmSubject;
            $result->AlarmStatus = $alarm->AlarmStatus;
            $result->Description = $alarm->Description;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToMajor(Request $major)
    {
        try
        {
            $result = new Majors();
            $result->NidMajor = $major->NidMajor;
            $result->Title = $major->Title;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToMessage(Request $message)
    {
        try
        {
            $result = new Messages();
            $result->NidMessage = $message->NidMessage;
            $result->SenderId = $message->SenderId;
            $result->RecieverId = $message->RecieverId;
            $result->RelatedId = $message->RelatedId;
            $result->Title = $message->Title;
            $result->MessageContent = $message->MessageContent;
            $result->IsRead = $message->IsRead;
            $result->IsRecieved = $message->IsRecieved;
            $result->IsDeleted = $message->IsDeleted;
            $result->CreateDate = $message->CreateDate;
            $result->ReadDate = $message->ReadDate;
            $result->DeleteDate = $message->DeleteDate;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToOreintation(Request $Oreintation)
    {
        try
        {
            $result = new Oreintations();
            $result->NidOreintation = $Oreintation->NidOreintation;
            $result->MajorId = $Oreintation->MajorId;
            $result->Title = $Oreintation->Title;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToProject(Request $project)
    {
        try
        {
            $result = new Projects();
            $result->NidProject = $project->NidProject;
            $result->ProjectNumber = $project->ProjectNumber;
            $result->Subject = $project->Subject;
            $result->ProjectStatus = $project->ProjectStatus;
            $result->ScholarId = $project->ScholarId;
            $result->UnitId = $project->UnitId;
            $result->GroupId = $project->GroupId;
            $result->Supervisor = $project->Supervisor;
            $result->SupervisorMobile = $project->SupervisorMobile;
            $result->Advisor = $project->Advisor;
            $result->AdvisorMobile = $project->AdvisorMobile;
            $result->Referee1 = $project->Referee1;
            $result->Referee2 = $project->Referee1;
            $result->Editor = $project->Editor;
            $result->CreateDate = $project->CreateDate;
            $result->PersianCreateDate = $project->PersianCreateDate;
            $result->TenPercentLetterDate = $project->TenPercentLetterDate;
            $result->PreImploymentLetterDate = $project->PreImploymentLetterDate;
            $result->ImploymentDate = $project->ImploymentDate;
            $result->SecurityLetterDate = $project->SecurityLetterDate;
            $result->ThesisDefenceDate = $project->ThesisDefenceDate;
            $result->ThesisDefenceLetterDate = $project->ThesisDefenceLetterDate;
            if(!empty($project->ReducePeriod))
            $result->ReducePeriod = $project->ReducePeriod;
            else
            $result->ReducePeriod = 0;
            $result->Commision = $project->Commision;
            $result->HasBookPublish = boolval($project->HasBookPublish);
            $result->UserId = $project->UserId;
            $result->TitleApproved = boolval($project->TitleApproved);
            $result->ThirtyPercentLetterDate = $project->ThirtyPercentLetterDate;
            $result->SixtyPercentLetterDate = $project->SixtyPercentLetterDate;
            $result->ATFLetterDate = $project->ATFLetterDate;
            $result->FinalApprove = boolval($project->FinalApprove);
            $result->IsConfident = boolval($project->IsConfident);
            $result->IsDisabled = boolval($project->IsDisabled) ?? false;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToReportParameter(ReportParameters $reportparameter)
    {
        try
        {
            $result = new ReportParameters();
            $result->NidParameter = $reportparameter->NidParameter;
            $result->ReportId = $reportparameter->ReportId;
            $result->ParameterKey = $reportparameter->ParameterKey;
            $result->ParameterValue = $reportparameter->ParameterValue;
            $result->IsDeleted = $reportparameter->IsDeleted;
            $result->Type = $reportparameter->Type;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToReport(Request $report)
    {
        try
        {
            $result = new Reports();
            $result->NidReport = $report->NidReport;
            $result->ReportName = $report->ReportName;
            $result->ContextId = $report->ContextId;
            $result->FieldId = $report->FieldId;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToReportRawData(Request $rawdata)
    {
        try
        {
            $result = new ReportRawData();
            $result->NidReport = $rawdata->NidReport;
            $result->paramsKey = $rawdata->paramsKey;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToResource(Request $resource)
    {
        try
        {
            $result = new Resources();
            $result->NidResource = $resource->NidResource;
            $result->ResourceName = $resource->ResourceName;
            $result->ParentId = $resource->ParentId;
            $result->ClassLevel = $resource->ClassLevel;
            $result->SortNumber = $resource->SortNumber;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToScholar(Request $scholar)
    {
        try
        {
            $result = new Scholars();
            $result->NidScholar = $scholar->NidScholar;
            $result->FirstName = $scholar->FirstName;
            $result->LastName = $scholar->LastName;
            $result->NationalCode = $scholar->NationalCode;
            $result->BirthDate = $scholar->BirthDate;
            $result->FatherName = $scholar->FatherName;
            $result->Mobile = $scholar->Mobile;
            $result->MillitaryStatus = $scholar->MillitaryStatus;
            $result->GradeId = $scholar->GradeId;
            $result->MajorId = $scholar->MajorId;
            $result->OreintationId = $scholar->OreintationId;
            $result->college = $scholar->college;
            $result->CollaborationType = $scholar->CollaborationType;
            $result->ProfilePicture = $scholar->ProfilePicture;
            $result->UserId = $scholar->UserId;
            $result->IsDeleted = $scholar->IsDeleted;
            $result->DeleteDate = $scholar->DeleteDate;
            $result->DeleteUser = $scholar->DeleteUser;
            if($scholar->IsConfident)
            $result->IsConfident = 1;
            else
            $result->IsConfident = 0;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToScholarFromArray(array $scholar)
    {
        try
        {
            $result = new Scholars();
            $result->NidScholar = $scholar[0];
            $result->FirstName = $scholar[1];
            $result->LastName = $scholar[2];
            $result->NationalCode = $scholar[3];
            $result->BirthDate = $scholar[4];
            $result->FatherName = $scholar[5];
            $result->Mobile = $scholar[6];
            $result->MillitaryStatus = $scholar[7];
            $result->GradeId = $scholar[8];
            $result->MajorId = $scholar[9];
            $result->OreintationId = $scholar[10];
            $result->college = $scholar[11];
            $result->CollaborationType = $scholar[12];
            $result->ProfilePicture = $scholar[13];
            $result->UserId = $scholar[14];
            $result->IsDeleted = $scholar[15];
            $result->DeleteDate = $scholar[16];
            $result->DeleteUser = $scholar[17];
            $result->IsConfident = $scholar[18];
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToSetting(Request $setting)
    {
        try
        {
            $result = new Settings();
            $result->NidSetting = $setting->NidSetting;
            $result->SettingKey = $setting->SettingKey;
            $result->SettingValue = $setting->SettingValue;
            $result->SettingTitle = $setting->SettingTitle;
            $result->IsDeleted = boolval($setting->IsDeleted);
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToUnitGroup(Request $unitGroup)
    {
        try
        {
            $result = new UnitGroups();
            $result->NidGroup = $unitGroup->NidGroup;
            $result->UnitId = $unitGroup->UnitId;
            $result->Title = $unitGroup->Title;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToUnit(Request $unit)
    {
        try
        {
            $result = new Units();
            $result->NidUnit = $unit->NidUnit;
            $result->Title = $unit->Title;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToUserPermission(Request $userpermission)
    {
        try
        {
            $result = new UserPermissions();
            $result->NidPermission = $userpermission->NidPermission;
            $result->UserId = $userpermission->UserId;
            $result->ResourceId = $userpermission->ResourceId;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }
    public static function MapToUser(Request $user)
    {
        try
        {
            $result = new User();
            $result->NidUser = $user->NidUser;
            $result->UserName = $user->UserName;
            $result->Password = $user->Password;
            $result->FirstName = $user->FirstName;
            $result->LastName = $user->LastName;
            $result->CreateDate = $user->CreateDate;
            $result->LastLoginDate = $user->LastLoginDate;
            $result->IncorrectPasswordCount = $user->IncorrectPasswordCount;
            $result->IsLockedOut = $user->IsLockedOut;
            $result->IsDisabled = $user->IsDisabled;
            $result->ProfilePicture = $user->ProfilePicture;
            $result->RoleId = $user->RoleId;
            $result->LockoutDeadLine = $user->LockoutDeadLine;
            $result->LastPasswordChangeDate = $user->LastPasswordChangeDate;
            $result->last_seen = $user->last_seen;
            $result->Force_logout = $user->Force_logout;
            return $result;
        }
        catch (\Exception)
        {
            return null;
        }
    }

}
