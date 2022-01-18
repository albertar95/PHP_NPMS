<?php

use App\Http\Controllers\AlarmController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ScholarController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Mime\MessageConverter;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::post('/', function () {
//     return view('General.Index');
// })->middleware('auth')->name('index');
Route::get("/",[UserController::class,"Index"])->name('index');


//alarm routes
Route::get("getalarms",[AlarmController::class,"GetAlarms"])->name('alarm.GetAlarms');
Route::get("alarms/{type}",[AlarmController::class,"Alarms"])->name('alarm.Alarms');

//message routes
Route::get("getmessages/{NidUser}",[MessageController::class,"GetMessages"])->name('message.GetMessages');
Route::get("messages/{NidUser}",[MessageController::class,"Messages"])->name('message.Messages');
Route::get("getsendmessages",[MessageController::class,"GetSendMessages"])->name('message.GetSendMessages');
Route::get("getrecievemessageneeded/{NidUser}",[MessageController::class,"GetRecieveMessageNeeded"])->name('message.GetRecieveMessageNeeded');
Route::get("singlemessage/{NidMessage}/{ReadBy}",[MessageController::class,"SingleMessage"])->name('message.SingleMessage');
Route::post("submitsendmessage",[MessageController::class,"SubmitSendMessage"])->name('message.SubmitSendMessage');
Route::post("submitreplymessage",[MessageController::class,"SubmitReplyMessage"])->name('message.SubmitReplyMessage');
Route::get("readmessage",[MessageController::class,"ReadMessage"])->name('message.ReadMessage');

//project routes
Route::get("projects",[ProjectController::class,"Projects"])->name('project.Projects');
Route::get("addproject",[ProjectController::class,"AddProject"])->name('project.AddProject');
Route::post("submitaddproject",[ProjectController::class,"SubmitAddProject"])->name('project.SubmitAddProject');
Route::get("projectdetail/{NidProject}",[ProjectController::class,"ProjectDetail"])->name('project.ProjectDetail');
Route::get("projectprogress/{NidProject}",[ProjectController::class,"ProjectProgress"])->name('project.ProjectProgress');
Route::post("updateproject",[ProjectController::class,"UpdateProject"])->name('project.UpdateProject');
Route::get("managebaseinfo",[ProjectController::class,"ManageBaseInfo"])->name('project.ManageBaseInfo');
Route::post("submitunitform",[ProjectController::class,"SubmitUnitForm"])->name('project.SubmitUnitForm');
Route::post("submitunitgroupform",[ProjectController::class,"SubmitUnitGroupForm"])->name('project.SubmitUnitGroupForm');
Route::post("submitgradeform",[ProjectController::class,"SubmitGradeForm"])->name('project.SubmitGradeForm');
Route::post("submitmajorform",[ProjectController::class,"SubmitMajorForm"])->name('project.SubmitMajorForm');
Route::post("submitoreintationform",[ProjectController::class,"SubmitOreintationForm"])->name('project.SubmitOreintationForm');
Route::post("submitcollegeform",[ProjectController::class,"SubmitCollegeForm"])->name('project.SubmitCollegeForm');
Route::post("submitmillitform",[ProjectController::class,"SubmitMillitForm"])->name('project.SubmitMillitForm');
Route::post("submitcollabform",[ProjectController::class,"SubmitCollabForm"])->name('project.SubmitCollabForm');
Route::post("submitdeleteunit/{NidUnit}",[ProjectController::class,"SubmitDeleteUnit"])->name('project.SubmitDeleteUnit');
Route::post("submitdeleteunitgroup/{NidUnitGroup}",[ProjectController::class,"SubmitDeleteUnitGroup"])->name('project.SubmitDeleteUnitGroup');
Route::post("submitdeletegrade/{NidGrade}",[ProjectController::class,"SubmitDeleteGrade"])->name('project.SubmitDeleteGrade');
Route::post("submitdeletemajor/{NidMajor}",[ProjectController::class,"SubmitDeleteMajor"])->name('project.SubmitDeleteMajor');
Route::post("submitdeleteoreintation/{NidOreintation}",[ProjectController::class,"SubmitDeleteOreintation"])->name('project.SubmitDeleteOreintation');
Route::post("submitdeletecollege/{NidCollege}",[ProjectController::class,"SubmitDeleteCollege"])->name('project.SubmitDeleteCollege');
Route::post("submitdeletemillit/{NidMillit}",[ProjectController::class,"SubmitDeleteMillit"])->name('project.SubmitDeleteMillit');
Route::post("submitdeletecollab/{NidCollab}",[ProjectController::class,"SubmitDeleteCollab"])->name('project.SubmitDeleteCollab');

//report routes
Route::get("statisticreports",[ReportController::class,"StatisticReports"])->name('report.StatisticReports');
Route::get("userlogreport",[ReportController::class,"UserLogReport"])->name('report.UserLogReport');
Route::post("submituserlogreport",[ReportController::class,"SubmitUserLogReport"])->name('report.SubmitUserLogReport');
Route::get("executereport/{NidReport}",[ReportController::class,"ExecuteReport"])->name('report.ExecuteReport');
Route::post("submitstatisticsreport",[ReportController::class,"SubmitStatisticsReport"])->name('report.SubmitStatisticsReport');
Route::post("downloadstatisticsreport",[ReportController::class,"DownloadStatisticsReport"])->name('report.DownloadStatisticsReport');
Route::get("chartreports",[ReportController::class,"ChartReports"])->name('report.ChartReports');
Route::get("customreports",[ReportController::class,"CustomReports"])->name('report.CustomReports');
Route::post("customreportcontextchanged/{ContextId}",[ReportController::class,"CustomReportContextChanged"])->name('report.CustomReportContextChanged');
Route::post("submitaddcustomreport",[ReportController::class,"SubmitAddCustomReport"])->name('report.SubmitAddCustomReport');
Route::post("deletereport/{NidReport}",[ReportController::class,"DeleteReport"])->name('report.DeleteReport');

//scholar routes
Route::get("addscholar",[ScholarController::class,"AddScholar"])->name('scholar.AddScholar');
Route::get("scholars",[ScholarController::class,"Scholars"])->name('scholar.Scholars');
Route::get("scholardetail/{NidScholar}",[ScholarController::class,"ScholarDetail"])->name('scholar.ScholarDetail');
Route::get("editscholar/{NidScholar}",[ScholarController::class,"EditScholar"])->name('scholar.EditScholar');
Route::post("submiteditscholar",[ScholarController::class,"SubmitEditScholar"])->name('scholar.SubmitEditScholar');
Route::get("deletescholar/{NidScholar}",[ScholarController::class,"DeleteScholar"])->name('scholar.DeleteScholar');
Route::get("majorselectchanged/{NidMajor}",[ScholarController::class,"MajorSelectChanged"])->name('scholar.MajorSelectChanged');
Route::post("submitaddscholar",[ScholarController::class,"SubmitAddScholar"])->name('scholar.SubmitAddScholar');
Route::post("uploadthisfile",[ScholarController::class,"UploadThisFile"])->name('scholar.UploadThisFile');

//search routes
Route::get("advancesearch",[SearchController::class,"AdvanceSearch"])->name('search.AdvanceSearch');
Route::get("searchsectionchange",[SearchController::class,"SearchSectionChange"])->name('search.SearchSectionChange');
Route::get("submitadvancesearch/{SearchInputs}",[SearchController::class,"SubmitAdvanceSearch"])->name('search.SubmitAdvanceSearch');
Route::get("complexsearch/{Text}",[SearchController::class,"ComplexSearch"])->name('search.ComplexSearch');

//user routes
Route::get("adduser",[UserController::class,"AddUser"])->name('user.AddUser');
Route::post("submitadduser",[UserController::class,"SubmitAddUser"])->name('user.SubmitAddUser');
Route::get("users",[UserController::class,"Users"])->name('user.Users');
Route::get("userdetail/{NidUser}",[UserController::class,"UserDetail"])->name('user.UserDetail');
Route::get("uploadthisfile",[UserController::class,"UploadThisFile"])->name('user.UploadThisFile');
Route::get("disableuser/{NidUser}",[UserController::class,"DisableUser"])->name('user.DisableUser');
Route::get("logoutuser/{NidUser}",[UserController::class,"LogoutUser"])->name('user.LogoutUser');
Route::get("edituser/{NidUser}",[UserController::class,"EditUser"])->name('user.EditUser');
Route::post("submitedituser",[UserController::class,"SubmitEditUser"])->name('user.SubmitEditUser');
Route::get("usersourcechange/{SourceId}",[UserController::class,"UserSourceChange"])->name('user.UserSourceChange');
Route::get("userpermissions",[UserController::class,"UserPermissions"])->name('user.UserPermissions');
Route::get("userpermissiondetail/{NidUser}",[UserController::class,"UserPermissionDetail"])->name('user.UserPermissionDetail');
Route::get("managepermission/{NidUser}",[UserController::class,"ManagePermission"])->name('user.ManagePermission');
Route::get("edituserpermission",[UserController::class,"EditUserPermission"])->name('user.EditUserPermission');
Route::get("login",[UserController::class,"Login"])->name('login');
Route::get("loadingpage",[UserController::class,"LoadingPage"])->name('user.LoadingPage');
Route::post("submitlogin",[UserController::class,"SubmitLogin"])->name('user.SubmitLogin');
Route::get("setlogindata/{Niduser}",[UserController::class,"SetLoginData"])->name('user.SetLoginData');
Route::post("logout",[UserController::class,"Logout"])->name('user.Logout');
Route::get("passwordpolicy",[UserController::class,"PasswordPolicy"])->name('user.PasswordPolicy');
Route::get("manageroles",[UserController::class,"ManageRoles"])->name('user.ManageRoles');
Route::post("submitpasswordpolicy",[UserController::class,"SubmitPasswordPolicy"])->name('user.SubmitPasswordPolicy');
Route::post("submitroleform",[UserController::class,"SubmitRoleForm"])->name('user.SubmitRoleForm');
Route::post("submitdeleterole/{NidRole}",[UserController::class,"SubmitDeleteRole"])->name('user.SubmitDeleteRole');
Route::get("changepassword/{Niduser}",[UserController::class,"ChangePassword"])->name('user.ChangePassword');
Route::get("getuserspasscode/{Niduser}/{CurrentPassword}",[UserController::class,"getUsersPassCode"])->name('user.getUsersPassCode');
Route::get("managerolepermissions",[UserController::class,"ManageRolePermissions"])->name('user.ManageRolePermissions');
Route::get("addrolepermission",[UserController::class,"AddRolePermission"])->name('user.AddRolePermission');
Route::get("profile",[UserController::class,"Profile"])->name('user.Profile');
Route::get("managesessions",[UserController::class,"ManageSessions"])->name('user.ManageSessions');
Route::post("submitsessionsetting",[UserController::class,"SubmitSessionSetting"])->name('user.SubmitSessionSetting');
Route::post("submitaddrolepermission",[UserController::class,"SubmitAddRolePermission"])->name('user.SubmitAddRolePermission');
Route::get("editrolepermission/{NidPermission}",[UserController::class,"EditRolePermission"])->name('user.EditRolePermission');
Route::post("submiteditrolepermission",[UserController::class,"SubmitEditRolePermission"])->name('user.SubmitEditRolePermission');
Route::post("deleterolepermission/{NidPermission}",[UserController::class,"DeleteRolePermission"])->name('user.DeleteRolePermission');
Route::post("submitchangepassword/{NidUser}/{NewPassword}",[UserController::class,"SubmitChangePassword"])->name('user.SubmitChangePassword');
