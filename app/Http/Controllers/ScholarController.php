<?php

namespace App\Http\Controllers;

use App\DTOs\DataMapper;
use App\Http\Controllers\Api\NPMSController;
use App\Http\Requests\ScholarRequest;
use App\Models\Scholars;
use Facade\FlareClient\Api;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use resources\ViewModels;
use Resources\ViewModels\ScholarViewModel;
use Illuminate\Support\Str;

class ScholarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('XSS');
    }
    private function CheckAuthority(bool $checkSub,int $sub,string $cookie,int $entity = 3)
    {
        $row = explode('#',$cookie);
        $AccessedEntities = new Collection();
        foreach ($row as $r)
        {
            $AccessedEntities->push(explode(',',$r)[0]);
        }
        if($checkSub)
        {
            $AccessedSub = new Collection();
            foreach ($row as $r)
            {
                $AccessedSub->push(["entity" => explode(',',$r)[0],"rowValue" => substr($r,2,strlen($r)-2)]);
            }
            if (in_array($entity, $AccessedEntities->toArray()))
            {
                if (explode(',', $AccessedSub->where('entity', '=', $entity)->pluck('rowValue')[0])[$sub] == 1)
                return true;
                else
                return false;
            }else
            return false;
        }else
        {
            if (in_array($entity, $AccessedEntities->toArray()))
            return true;
            else
            return false;
        }
    }
    public function AddScholar(Request $request)
    {
        if ($this->CheckAuthority(true,0,$request->cookie('NPMS_Permissions')))
        {
            $api = new NPMSController();
            $Majors = $api->GetMajors();
            $CollaborationTypes = $api->GetCollaborationTypes();
            $Grades = $api->GetGrades();
            $MillitaryStatuses = $api->GetMillitaryStatuses();
            $Colleges = $api->GetColleges();
            $api->AddLog(auth()->user(),$request->ip(),1,0,2,1,"ایجاد محقق");
            return view('Scholar.AddScholar',compact('Majors','CollaborationTypes','Grades','MillitaryStatuses','Colleges'));
        }else
        {
            return view('errors.503');
        }
    }
    public function MajorSelectChanged(string $NidMajor)
    {
        $api = new NPMSController();
        $Oreintations = $api->GetOreintationsByMajorId($NidMajor);
        $newValue = "<option value='0' selected>گرایش</option> ";
        foreach ($Oreintations as $orie) {
            $newValue = Str::of($newValue)->append("<option value='");
            $newValue = Str::of($newValue)->append($orie->NidOreintation);
            $newValue = Str::of($newValue)->append("'>");
            $newValue = Str::of($newValue)->append($orie->Title);
            $newValue = Str::of($newValue)->append("</option> ");
        }
        $result = new JsonResults();
        $result->Html = $newValue;
        return response()->json($result);
    }
    public function SubmitAddScholar(ScholarRequest $scholar)
    {
        $scholar->validated();
        $api = new NPMSController();
        $result = new JsonResults();
        if($api->AddScholar($scholar))
        {
            $tmpname = $scholar->FirstName;
            $tmpname = Str::of($tmpname)->append(" ");
            $tmpname = Str::of($tmpname)->append($scholar->LastName);
            $result->Message = $tmpname;
            $api->AddLog(auth()->user(),$scholar->ip(),7,0,3,1,"ایجاد محقق موفق");
        }
        return response()->json($result);
    }
    public function Scholars(Request $request)
    {
        if ($this->CheckAuthority(true,4,$request->cookie('NPMS_Permissions')))
        {
            $api = new NPMSController();
            $Scholar = $api->GetAllScholarLists(0);
            $api->AddLog(auth()->user(),$request->ip(),1,0,1,1,"مدیریت محققان");
            return view('Scholar.Scholars',compact('Scholar'));
        }else
        {
            return view('errors.503');
        }
    }
    public function ScholarDetail(string $NidScholar,Request $request)
    {
        if ($this->CheckAuthority(true,3,$request->cookie('NPMS_Permissions')))
        {
            $api = new NPMSController();
            $result = new JsonResults();
            $result->HasValue = true;
            $Scholar = $api->GetAllScholarDetails($NidScholar);
            $result->Html = view('Scholar._ScholarDetail',compact('Scholar'))->render();
            $api->AddLog(auth()->user(),$request->ip(),1,0,2,1,"ایجاد محقق");
            return response()->json($result);
        }else
        {
            return view('errors.503');
        }
    }
    public function EditScholar(string $NidScholar,Request $request)
    {
        if ($this->CheckAuthority(true,1,$request->cookie('NPMS_Permissions')))
        {
            $api = new NPMSController();
            $Majors = $api->GetMajors();
            $CollaborationTypes = $api->GetCollaborationTypes();
            $Grades = $api->GetGrades();
            $MillitaryStatuses = $api->GetMillitaryStatuses();
            $Colleges = $api->GetColleges();
            $Scholar = $api->GetScholarDTO($NidScholar);
            if(!is_null($Scholar))
            {
                $Oreintations = $api->GetOreintationsByMajorId($Scholar->MajorId);
            }else
            {
                $Oreintations = new Collection();
            }
            $api->AddLog(auth()->user(),$request->ip(),1,0,2,1,"ایجاد محقق");
            return view('Scholar.EditScholar',compact('Majors','CollaborationTypes','Grades','MillitaryStatuses','Colleges','Scholar','Oreintations'));
        }else
        {
            return view('errors.503');
        }
    }
    public function SubmitEditScholar(ScholarRequest $scholar) //ScholarDTO
    {
        $scholar->validated();
        $api = new NPMSController();
        $api->UpdateScholar($scholar);
        $api->AddLog(auth()->user(),$scholar->ip(),8,0,3,1,"ویرایش محقق موفق");
        return redirect('scholars');
    }
    public function UploadThisFile(Request $file)
    {
        switch ($file->fileType) {
            case '1':
                if(substr($file->profile->getMimeType(), 0, 5) == 'image')
                {
                    if(intval($file->profile->getsize()) < 1048576)
                    {
                    // $imageName = time().'.'.$file->image->extension();
                    // $file->ProfilePictureUpload->storeAs('Images', $imageName);
                    $filename = "File".'_'.time().'_'.$file->fileName;
                    $file->profile->storeAs('/public/Images/', $filename);
                    $result = new JsonResults();
                    $result->HasValue = true;
                    $result->Message = $filename;
                    return response()->json($result);
                    }else
                    {
                    $result = new JsonResults();
                    $result->HasValue = false;
                    // $result->Message = $filename;
                    $result->Message = "حجم فایل انتخاب شده بیشتر از یک مگابایت می باشد";
                    return response()->json($result);
                    }
                }else
                {
                    $result = new JsonResults();
                    $result->HasValue = false;
                    // $result->Message = $filename;
                    $result->Message = "نوع فایل انتخاب شده باید تصویر باشد";
                    return response()->json($result);
                }
                break;

            default:
                # code...
                break;
        }
    }
    public function DeleteScholar(string $NidScholar,Request $request)
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $state = 0;
        $Scholar = $api->DeleteScholar($NidScholar);
        if(json_decode($Scholar->getContent(),true)['Message'] == "-1")
        {
            $result->Message = "1";
            $result->Html = sprintf('محقق با نام %s با موفقیت حذف گردید',json_decode($Scholar->getContent(),true)['Html']);
            $api->AddLog(auth()->user(),$request->ip(),9,0,3,1,"حذف محقق موفق");
        }elseif(json_decode($Scholar->getContent(),true)['Message'] == "0")
        {
            $result->Message = "2";
            $result->Html = sprintf('خطا در انجام عملیات.لطفا مجددا امتحان کنید');
            $api->AddLog(auth()->user(),$request->ip(),9,1,3,1,"حذف محقق ناموفق");
        }else
        {
            $result->Message = "3";
            $result->Html = sprintf('محقق دارای %s طرح ثبت شده در سیستم می باشد.امکان حذف وجود ندارد',json_decode($Scholar->getContent(),true)['Message']);
            $api->AddLog(auth()->user(),$request->ip(),9,1,3,1,"حذف محقق ناموفق");
        }
        return response()->json($result);
    }
}
