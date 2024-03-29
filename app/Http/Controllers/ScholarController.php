<?php

namespace App\Http\Controllers;

use App\DTOs\DataMapper;
use App\Http\Controllers\Api\NPMSController;
use App\Http\Requests\ScholarRequest;
use App\Models\DataFiles;
use App\Models\Scholars;
use Carbon\Carbon;
use Facade\FlareClient\Api;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
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
    private function CheckAuthority(bool $checkSub, int $sub, string $cookie, int $entity = 1)
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
    public function AddScholar(Request $request)
    {
        try {
            if ($this->CheckAuthority(true, 0, $request->cookie('NPMS_Permissions'))) {
                $api = new NPMSController();
                $Majors = $api->GetMajors();
                $CollaborationTypes = $api->GetCollaborationTypes();
                $Grades = $api->GetGrades();
                $MillitaryStatuses = $api->GetMillitaryStatuses();
                $Colleges = $api->GetColleges();
                $api->AddLog(auth()->user(), $request->ip(), 1, 0, 2, 1, "ایجاد محقق");
                return view('Scholar.AddScholar', compact('Majors', 'CollaborationTypes', 'Grades', 'MillitaryStatuses', 'Colleges'));
            } else {
                return view('errors.401');
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function MajorSelectChanged(string $NidMajor)
    {
        try {
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
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function SubmitAddScholar(ScholarRequest $scholar)
    {
        try {
            $scholar->validated();
            $api = new NPMSController();
            $result = new JsonResults();
            if ($api->AddScholar($scholar)) {
                $tmpname = $scholar->FirstName;
                $tmpname = Str::of($tmpname)->append(" ");
                $tmpname = Str::of($tmpname)->append($scholar->LastName);
                $result->Message = $tmpname;
                $api->AddLog(auth()->user(), $scholar->ip(), 7, 0, 3, 1, sprintf("ایجاد محقق موفق.نام محقق %s", $tmpname));
            }
            return response()->json($result);
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function Scholars(Request $request)
    {
        try {
            if ($this->CheckAuthority(true, 4, $request->cookie('NPMS_Permissions'))) {
                $api = new NPMSController();
                if ($this->CheckAuthority(true, 6, $request->cookie('NPMS_Permissions'))) {
                    $Scholar = $api->GetAllScholarLists(200);
                } else {
                    $Scholar = $api->GetAllScholarLists(200, false);
                }
                $api->AddLog(auth()->user(), $request->ip(), 1, 0, 1, 1, "مدیریت محققان");
                return view('Scholar.Scholars', compact('Scholar'));
            } else {
                return view('errors.401');
            }
        } catch (\Exception $e) {
            // throw new \App\Exceptions\LogExecptions($e);
            return view('errors.401');
        }
    }
    public function ScholarDetail(string $NidScholar, Request $request)
    {
        try {
            if ($this->CheckAuthority(true, 3, $request->cookie('NPMS_Permissions'))) {
                $api = new NPMSController();
                $result = new JsonResults();
                $result->HasValue = true;
                $Scholar = $api->GetAllScholarDetails($NidScholar);
                $datafiles = $api->GetScholarFiles($NidScholar);
                if ($Scholar->IsConfident) {
                    if ($this->CheckAuthority(true, 6, $request->cookie('NPMS_Permissions'))) {
                        $result->Html = view('Scholar._ScholarDetail', compact('Scholar','datafiles'))->render();
                    } else {
                        $result->Html = "";
                    }
                } else {
                    $result->Html = view('Scholar._ScholarDetail', compact('Scholar','datafiles'))->render();
                }
                $api->AddLog(auth()->user(), $request->ip(), 1, 0, 2, 1, sprintf("جزییات محقق.نام محقق : %s", $Scholar->FirstName . ' ' . $Scholar->LastName));
                return response()->json($result);
            } else {
                return view('errors.401');
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function EditScholar(string $NidScholar, Request $request)
    {
        try {
            if ($this->CheckAuthority(true, 1, $request->cookie('NPMS_Permissions'))) {
                $api = new NPMSController();
                $Scholar = $api->GetScholarDTO($NidScholar);
                if ($Scholar->IsConfident) {
                    if (!$this->CheckAuthority(true, 6, $request->cookie('NPMS_Permissions'))) {
                        return view('errors.401');
                    }
                }
                $Majors = $api->GetMajors();
                $CollaborationTypes = $api->GetCollaborationTypes();
                $Grades = $api->GetGrades();
                $MillitaryStatuses = $api->GetMillitaryStatuses();
                $Colleges = $api->GetColleges();
                $datafiles = $api->GetScholarFiles($NidScholar);
                if (!is_null($Scholar)) {
                    $Oreintations = $api->GetOreintationsByMajorId($Scholar->MajorId);
                } else {
                    $Oreintations = new Collection();
                }
                $api->AddLog(auth()->user(), $request->ip(), 1, 0, 2, 1, "ویرایش محقق");
                return view('Scholar.EditScholar', compact('Majors', 'CollaborationTypes', 'Grades', 'MillitaryStatuses', 'Colleges', 'Scholar', 'Oreintations','datafiles'));
            } else {
                return view('errors.401');
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function SubmitEditScholar(ScholarRequest $scholar) //ScholarDTO
    {
        try {
            $scholar->validated();
            $api = new NPMSController();
            $api->UpdateScholar($scholar);
            $api->AddLog(auth()->user(), $scholar->ip(), 8, 0, 3, 1, sprintf("ویرایش محقق موفق.نام محقق : %s", $scholar->FirstName . ' ' . $scholar->LastName));
            return redirect('scholars');
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function UploadThisFile(Request $file)
    {
        try {
            switch ($file->fileType) {
                case '1':
                    if (substr($file->profile->getMimeType(), 0, 5) == 'image') {
                        if (intval($file->profile->getsize()) < 1048576) {
                            // $imageName = time().'.'.$file->image->extension();
                            // $file->ProfilePictureUpload->storeAs('Images', $imageName);
                            $filename = "File" . '_' . time() . '_' . $file->fileName;
                            $file->profile->storeAs('/public/Images/', $filename);
                            $result = new JsonResults();
                            $result->HasValue = true;
                            $result->Message = $filename;
                            return response()->json($result);
                        } else {
                            $result = new JsonResults();
                            $result->HasValue = false;
                            // $result->Message = $filename;
                            $result->Message = "حجم فایل انتخاب شده بیشتر از یک مگابایت می باشد";
                            return response()->json($result);
                        }
                    } else {
                        $result = new JsonResults();
                        $result->HasValue = false;
                        // $result->Message = $filename;
                        $result->Message = "نوع فایل انتخاب شده باید تصویر باشد";
                        return response()->json($result);
                    }
                    break;
                case '2':
                    // $validatedData = $request->validate([
                    //     'files' => 'required',
                    //     'files.*' => 'mimes:csv,txt,xlx,xls,pdf'
                    // ]);
                    $result = new JsonResults();
                    $api = new NPMSController();
                    $uploadeds = new Collection();
                    $Ids = new Collection();
                    $filenames = new Collection();
                    $Dpath = '/public/FileUpload/Project/' . time();
                    File::makeDirectory($Dpath, $mode = 0777, true, true);
                    if ($file->TotalFiles > 0) {
                        for ($x = 0; $x < $file->TotalFiles; $x++) {
                            if ($file->hasFile('files' . $x)) {
                                $f    = $file->file('files' . $x);
                                $name = $f->getClientOriginalName();
                                $path = $f->storeAs($Dpath, $name);
                                $currentFile = new DataFiles();
                                $currentFile->NidFile = Str::uuid();
                                $currentFile->MasterType = 1; //project
                                $currentFile->FilePath = 'storage/' . substr($path, 7, strlen($path) - 7);
                                $currentFile->FileName = $name;
                                $currentFile->FileExtension = $f->getClientOriginalExtension();
                                $currentFile->IsDeleted = 0;
                                $currentFile->CreateDate = Carbon::now();
                                $uploadeds->push($currentFile);
                                $Ids->push($currentFile->NidFile);
                                $filenames->push('<div class="image-area"><a class="remove-image removeFile" href="#" onclick="btnRemoveFile' . "(event)" . '" id="' . $currentFile->NidFile . '" style="display: inline;">&#215;</a> <a href="' . URL($currentFile->FilePath) . '" target="_blank" style="padding:25px;">' . $name . '</a> </div>');
                            }
                        }
                    }
                    if ($api->AddDataFiles($uploadeds))
                        $result->HasValue = true;
                    else
                        $result->HasValue = false;
                    $result->Message = join(',', $Ids->toArray());
                    $result->AltProp = join(',', $filenames->toArray());
                    return response()->json($result);
                    break;
                case '3':
                    // $validatedData = $request->validate([
                    //     'files' => 'required',
                    //     'files.*' => 'mimes:csv,txt,xlx,xls,pdf'
                    // ]);
                    $result = new JsonResults();
                    $api = new NPMSController();
                    $uploadeds = new Collection();
                    $Ids = new Collection();
                    $filenames = new Collection();
                    $Dpath = '/public/FileUpload/Scholar/' . time();
                    File::makeDirectory($Dpath, $mode = 0777, true, true);
                    if ($file->TotalFiles > 0) {
                        for ($x = 0; $x < $file->TotalFiles; $x++) {
                            if ($file->hasFile('files' . $x)) {
                                $f    = $file->file('files' . $x);
                                $name = $f->getClientOriginalName();
                                $path = $f->storeAs($Dpath, $name);
                                $currentFile = new DataFiles();
                                $currentFile->NidFile = Str::uuid();
                                $currentFile->MasterType = 2; //scholar
                                $currentFile->FilePath = 'storage/' . substr($path, 7, strlen($path) - 7);
                                $currentFile->FileName = $name;
                                $currentFile->FileExtension = $f->getClientOriginalExtension();
                                $currentFile->IsDeleted = 0;
                                $currentFile->CreateDate = Carbon::now();
                                $uploadeds->push($currentFile);
                                $Ids->push($currentFile->NidFile);
                                $filenames->push('<div class="image-area"><a class="remove-image removeFile" href="#" onclick="btnRemoveFile' . "(event)" . '" id="' . $currentFile->NidFile . '" style="display: inline;">&#215;</a> <a href="' . URL($currentFile->FilePath) . '" target="_blank" style="padding:25px;">' . $name . '</a> </div>');
                            }
                        }
                    }
                    if ($api->AddDataFiles($uploadeds))
                        $result->HasValue = true;
                    else
                        $result->HasValue = false;
                    $result->Message = join(',', $Ids->toArray());
                    $result->AltProp = join(',', $filenames->toArray());
                    return response()->json($result);
                    break;
                default:
                    # code...
                    break;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function DeleteThisFile(string $NidFile)
    {
        $result = new JsonResults();
        try {
            $api = new NPMSController();
            $file = $api->GetDataFileById($NidFile);
            File::delete(public_path($file->FilePath));
            $api->DeleteFile($NidFile);
            $result->HasValue = true;
            return response()->json($result);
        } catch (\Throwable $th) {
            $result->HasValue = false;
            return response()->json($result);
        }
    }
    public function DeleteUploadedImage(string $FileName)
    {
        try {
            $result = new JsonResults();
            $result->Message = public_path();
            if (File::exists(public_path('storage/Images/' . $FileName)))
                $result->HasValue = File::delete(public_path('storage/Images/' . $FileName));
            else
                $result->HasValue = false;
            return response()->json($result);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function DeleteScholar(string $NidScholar, Request $request)
    {
        try {
            $api = new NPMSController();
            $result = new JsonResults();
            $state = 0;
            $Scholar = $api->DeleteScholar($NidScholar);
            if (json_decode($Scholar->getContent(), true)['Message'] == "-1") {
                $files = $api->GetScholarFiles($NidScholar);
                foreach ($files as $file) {
                    File::delete(public_path($file->FilePath));
                    $api->DeleteFile($file->NidFile);
                }
                $result->Message = "1";
                $result->Html = sprintf('محقق با نام %s با موفقیت حذف گردید', json_decode($Scholar->getContent(), true)['Html']);
                $api->AddLog(auth()->user(), $request->ip(), 9, 0, 3, 1, sprintf("حذف محقق موفق.نام محقق : %s", json_decode($Scholar->getContent(), true)['Html']));
            } elseif (json_decode($Scholar->getContent(), true)['Message'] == "0") {
                $result->Message = "2";
                $result->Html = sprintf('خطا در انجام عملیات.لطفا مجددا امتحان کنید');
                $api->AddLog(auth()->user(), $request->ip(), 9, 1, 3, 1, "حذف محقق ناموفق");
            } else {
                $result->Message = "3";
                $result->Html = sprintf('محقق دارای %s طرح ثبت شده در سیستم می باشد.امکان حذف وجود ندارد', json_decode($Scholar->getContent(), true)['Message']);
                $api->AddLog(auth()->user(), $request->ip(), 9, 1, 3, 1, sprintf("حذف محقق ناموفق.نام محقق : %s", json_decode($Scholar->getContent(), true)['Html']));
            }
            return response()->json($result);
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
    public function DeleteScholarProfile(string $NidScholar)
    {
        try {
            $api = new NPMSController();
            $result = new JsonResults();
            $api->DeleteProfile($NidScholar, 2);
            $result->HasValue = true;
            // $api->AddLog(auth()->user(), $request->ip(), 39, 0, 3, 3, "حذف دسترسی کاربر موفق");
            return response()->json($result);
        } catch (\Exception $e) {
            throw new \App\Exceptions\LogExecptions($e);
        }
    }
}
