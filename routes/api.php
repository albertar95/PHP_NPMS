<?php

use App\Http\Controllers\Api\NPMSController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//scholar routes
Route::post("scholar/addscholar",[NPMSController::class,"AddScholar"]);
Route::get("scholar/getcollaborationtypes",[NPMSController::class,"GetCollaborationTypes"]);
Route::get("scholar/getcolleges",[NPMSController::class,"GetColleges"]);
Route::get("scholar/getgrades",[NPMSController::class,"GetGrades"]);
Route::get("scholar/getmillitarystatuses",[NPMSController::class,"GetMillitaryStatuses"]);
Route::get("scholar/getmajors",[NPMSController::class,"GetMajors"]);
Route::get("scholar/getorientations",[NPMSController::class,"GetOrientations"]);
Route::get("scholar/getscholar",[NPMSController::class,"GetScholar"]);
Route::get("scholar/getscholardto",[NPMSController::class,"GetScholarDTO"]);
Route::get("scholar/getoreintationsbymajorid",[NPMSController::class,"GetOreintationsByMajorId"]);
Route::get("scholar/getallscholars",[NPMSController::class,"GetAllScholars"]);
Route::get("scholar/getallscholarlists",[NPMSController::class,"GetAllScholarLists"]);
Route::get("scholar/getallscholardetails",[NPMSController::class,"GetAllScholarDetails"]);
Route::post("scholar/updatescholar",[NPMSController::class,"UpdateScholar"]);
Route::get("scholar/deletescholar",[NPMSController::class,"DeleteScholar"]);
Route::get("scholar/getscholarlist",[NPMSController::class,"GetScholarList"]);

//user routes
Route::post("user/adduser",[NPMSController::class,"AddUser"]);
Route::get("user/getuserdtobyid",[NPMSController::class,"GetUserDTOById"]);
Route::get("user/getallusers",[NPMSController::class,"GetAllUsers"]);
Route::get("user/disableuserbyid",[NPMSController::class,"DisableUserById"]);
Route::post("user/updateuser",[NPMSController::class,"UpdateUser"]);
Route::get("user/getcustomusers",[NPMSController::class,"GetCustomUsers"]);
Route::get("user/resetpassword",[NPMSController::class,"ResetPassword"]);
Route::get("user/loginthisuser",[NPMSController::class,"LoginThisUser"]);

//user permission routes
Route::get("userpermision/getalluserpermissionusers",[NPMSController::class,"GetAllUserPermissionUsers"]);
Route::get("userpermision/getuserinpermissionbyid",[NPMSController::class,"GetUserInPermissionById"]);
Route::get("userpermision/getallresources",[NPMSController::class,"GetAllResources"]);
Route::get("userpermision/getalluserpermissions",[NPMSController::class,"GetAllUserPermissions"]);
Route::get("userpermision/updateuseruserpermissions",[NPMSController::class,"UpdateUserUserPermissions"]);

//project routes
Route::get("project/getallprojectinitials",[NPMSController::class,"GetAllProjectInitials"]);
Route::get("project/addprojectinitial",[NPMSController::class,"AddProjectInitial"]);
Route::post("project/projectprogress",[NPMSController::class,"ProjectProgress"]);
Route::get("project/getprojectdtobyid",[NPMSController::class,"GetProjectDTOById"]);
Route::get("project/getprojectdetaildtobyid",[NPMSController::class,"GetProjectDetailDTOById"]);
Route::get("project/getallunits",[NPMSController::class,"GetAllUnits"]);
Route::get("project/getallunitgroups",[NPMSController::class,"GetAllUnitGroups"]);
Route::get("project/getallprojectscholars",[NPMSController::class,"GetAllProjectScholars"]);
Route::post("project/addproject",[NPMSController::class,"AddProject"]);
Route::get("project/getprojectbyid",[NPMSController::class,"GetProjectById"]);

//base info routes
Route::post("baseinfo/addunit",[NPMSController::class,"AddUnit"]);
Route::post("baseinfo/updateunit",[NPMSController::class,"UpdateUnit"]);
Route::post("baseinfo/addunitgroup",[NPMSController::class,"AddUnitGroup"]);
Route::post("baseinfo/updateunitgroup",[NPMSController::class,"UpdateUnitGroup"]);
Route::post("baseinfo/addmajor",[NPMSController::class,"AddMajor"]);
Route::post("baseinfo/updatemajor",[NPMSController::class,"UpdateMajor"]);
Route::post("baseinfo/addoreintation",[NPMSController::class,"AddOreintation"]);
Route::post("baseinfo/updateoreintation",[NPMSController::class,"UpdateOreintation"]);
Route::post("baseinfo/addsetting",[NPMSController::class,"AddSetting"]);
Route::post("baseinfo/updatesetting",[NPMSController::class,"UpdateSetting"]);
Route::get("baseinfo/deleteunit",[NPMSController::class,"DeleteUnit"]);
Route::get("baseinfo/deleteunitgroup",[NPMSController::class,"DeleteUnitGroup"]);
Route::get("baseinfo/deletemajor",[NPMSController::class,"DeleteMajor"]);
Route::get("baseinfo/deleteoreintation",[NPMSController::class,"DeleteOreintation"]);
Route::get("baseinfo/deletesetting",[NPMSController::class,"DeleteSetting"]);
Route::get("baseinfo/generatesettingvalue",[NPMSController::class,"GenerateSettingValue"]);

//search routes
Route::get("search/advancedsearch",[NPMSController::class,"AdvancedSearch"]);
Route::get("search/complexsearch",[NPMSController::class,"ComplexSearch"]);

//alarm routes
Route::get("alarm/getfirstpagealarms",[NPMSController::class,"GetFirstPageAlarms"]);
Route::get("alarm/getallalarms",[NPMSController::class,"GetAllAlarms"]);

//message routes
Route::get("message/deletemessage",[NPMSController::class,"DeleteMessage"]);
Route::get("message/getallusersmessages",[NPMSController::class,"GetAllUsersMessages"]);
Route::get("message/getallUserssendmessages",[NPMSController::class,"GetAllUsersSendMessages"]);
Route::get("message/readmessage",[NPMSController::class,"ReadMessage"]);
Route::get("message/recievemessage",[NPMSController::class,"RecieveMessage"]);
Route::get("message/recievemessageneeded",[NPMSController::class,"RecieveMessageNeeded"]);
Route::get("message/getmessagedtobyid",[NPMSController::class,"GetMessageDTOById"]);
Route::get("message/getmessagehirarchybyid",[NPMSController::class,"GetMessageHirarchyById"]);
Route::post("message/sendmessage",[NPMSController::class,"SendMessage"]);

//report routes
Route::post("report/getstatisticsreport",[NPMSController::class,"GetStatisticsReport"]);
Route::post("report/addreport",[NPMSController::class,"AddReport"]);
Route::post("report/addreportparameters",[NPMSController::class,"AddReportParameters"]);
Route::get("report/getreportbyid",[NPMSController::class,"GetReportById"]);
Route::get("report/getstatisticsreports",[NPMSController::class,"GetStatisticsReports"]);
Route::get("report/getreportsinput",[NPMSController::class,"GetReportsInput"]);
Route::get("report/getreportsoutput",[NPMSController::class,"GetReportsOutput"]);
Route::get("report/deletereport",[NPMSController::class,"DeleteReport"]);
