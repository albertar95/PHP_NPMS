<?php

namespace resources\ViewModels;

use App\Http\Controllers\Api\NPMSController;
use Illuminate\Support\Collection;

class SharedLayoutViewModel
{
    public array $encData;
    public string $UserInfo;
    public string $UserLevel;
    public string $NidUser;
    public bool $HasProfile;
    public Collection $UserPermissions;
    public static Collection $ResourceIds;
    function __construct(array $_encData,int $PageLevel = 0)
    {
        if(!is_null($_encData))
        {
            $this->encData = $_encData;
            if ($PageLevel == 0)
            {
                $this->GetUserInfo($_encData);
                $this->GetUserLevel($_encData);
                $this->GetNidUser($_encData);
                $this->GetUserImage($_encData);
            }
            else
            {
                $this->GetUserPermissions($_encData);
            }
        }
    }
    public function GetUserInfo($encData)
    {
        $Name = "";
        $Name = $encData->skip(0)->take(1)->firstOrFail();
        $this->UserInfo = $Name;
    }
    public function GetUserLevel($encData)
    {
        $userlevel = "";
        $userlevel = $encData->skip(1)->take(1)->firstOrFail();
        $this->UserLevel = $userlevel;
    }
    public function GetUserPermissions($encData)
    {
        $Permissions = new Collection();
        foreach ($encData->firstOrFail()->split('#') as $per)
        {
            if (!isEmptyOrNullString($per))
            {
                $Permissions->push($per);
            }
        }
        $this->UserPermissions = $Permissions;
    }
    public function GetNidUser($encData)
    {
        $guid = "";
        $guid = $encData->skip(2)->take(1)->firstOrFail();
        $this->NidUser = $guid;
    }
    public function GetUserImage($encData)
    {
        $result = false;
        $ImageState = $encData->skip(3)->take(1)->firstOrFail();
        if ($ImageState == "true")
            $result = true;

        $this->HasProfile = $result;
    }
    public function GetGrades()
    {
        $api = new NPMSController();
        return $api->GetGrades();
    }
    public function GetMajors()
    {
        $api = new NPMSController();
        return $api->GetMajors();
    }
    public function GetOrientations()
    {
        $api = new NPMSController();
        return $api->GetOrientations();
    }
    public function GetCollaborationTypes()
    {
        $api = new NPMSController();
        return $api->GetCollaborationTypes();
    }
    public function GetMillitaryStatuses()
    {
        $api = new NPMSController();
        return $api->GetMillitaryStatuses();
    }
    public function GetColleges()
    {
        $api = new NPMSController();
        return $api->GetColleges();
    }
}
class ResourceList
{
    public string $Title;
    public string $Id;
    public string $PersianTitle;
}
class ReportParametersInfo
{
    public int $TypeId;
    public int $FieldId;
    public string $FieldName;
    public string $PersianName;
    public int $ParameterType;
}
