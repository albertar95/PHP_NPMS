@extends('Layouts.app')

@section('Content')
{{-- @model DataAccessLibrary.DTOs.UserDTO
@{
    ViewBag.Title = "ویرایش کاربر";
    Layout = "~/Views/Shared/_Layout.cshtml";
    NPMS_WebUI.ViewModels.SharedLayoutViewModel slvm1 = null;
    if (HttpContext.Current.Request.Cookies.AllKeys.Contains("NPMS_Permissions"))
    {
        var ticket = FormsAuthentication.Decrypt(HttpContext.Current.Request.Cookies["NPMS_Permissions"].Value);
        slvm1 = new NPMS_WebUI.ViewModels.SharedLayoutViewModel(new string[] { ticket.UserData }, 1);
    }
    else
    {
        slvm1.UserPermissions = new List<Guid>();
    }
} --}}

<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-12">
                {{-- @if (slvm1.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "Users").FirstOrDefault().Id))
                {
                    <div dir="ltr">
                        <a id="btnReturn" class="btn btn-outline-info btn-block" style="margin:1rem;width:25%;" href="@Url.Action("Users","Home")">&larr; بازگشت</a>
                    </div>
                } --}}
                <div class="alert alert-success alert-dismissible" role="alert" id="successAlert" hidden>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <p style="text-align:right;" id="SuccessMessage"></p>
                </div>
                <div class="alert alert-danger alert-dismissible" role="alert" id="errorAlert" hidden>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <p style="text-align:right;" id="ErrorMessage"></p>
                </div>
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">اطلاعات کاربر</h1>
                    </div>
                    <form class="user" action="{{ route('user.SubmitEditUser') }}" id="EditUserForm" method="POST">
                        @csrf
                        <input id="CreateDate" value="{{ $User->CreateDate }}" name="CreateDate" type="text" hidden >
                        <input id="LastLoginDate" value="{{ $User->LastLoginDate }}" name="LastLoginDate" type="text" hidden >
                        <input id="IncorrectPasswordCount" value="{{ $User->IncorrectPasswordCount }}" name="IncorrectPasswordCount" type="text" hidden >
                        <input id="IsDisabled" name="IsDisabled" value="{{ $User->IsDisabled }}" type="text" hidden >
                        <input id="IsLockedOut" name="IsLockedOut" value="{{ $User->IsLockedOut }}" type="text" hidden >
                        <input id="LastLoginDate" name="LastLoginDate" value="{{ $User->LastLoginDate }}" type="text" hidden >
                        <input id="NidUser" name="NidUser" value="{{ $User->NidUser }}" type="text" hidden >
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user" id="FirstName" name="FirstName"
                                       placeholder="نام" value="{{ $User->FirstName }}">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control form-control-user" id="LastName" name="LastName"
                                       placeholder="نام خانوادگی" value="{{ $User->LastName }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user" id="Username" name="Username"
                                       placeholder="نام کاربری" value="{{ $User->Username }}" readonly>
                            </div>
                            <div class="col-sm-6">
                                <input type="password" class="form-control form-control-user" id="Password" name="Password"
                                       placeholder="کلمه عبور" value="{{ $User->Password }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="file" accept="image/*" class="custom-file-input" onchange="UploadFile()" id="ProfilePictureUpload" name="ProfilePictureUpload">
                                <input type="text" class="custom-file-input" id="ProfilePicture" name="ProfilePicture" value="{{ $User->ProfilePicture }}" hidden>
                                <label class="custom-file-label" for="ProfilePictureUpload" data-browse="انتخاب فایل" style="width:75%;margin:0 auto;">
                                    تغییر پروفایل کاربر
                                </label>
                                <p id="UploadMessage" style="text-align:center;color:tomato;" hidden></p>
                            </div>
                            <div class="col-sm-6" style="display:flex;">
                                @if (!empty($User->ProfilePicture))
                                    {{ $imgSrc = string.spintf("data:image/jpg;base64,%s", $User->ProfilePicture); }}
                                    <div class="frame" style="margin:.5rem;width:50%;margin-left:25%;" id="uploadedframe">
                                        <img src="{{ $imgSrc }}" id="userImg" style="width:100%;height:200px;" />
                                    </div>
                                @else
                                    <div class="frame" style="margin:.5rem;width:50%;margin-left:25%;" id="uploadedframe" hidden>
                                        <img src="" id="userImg" style="width:100%;height:200px;" />
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                @if ($User->IsAdmin)
                                    <input class="form-check-input" type="checkbox" style="margin-right:1.2rem;" onclick="$(this).attr('value', this.checked ? 'true' : 'false')" id="IsAdmin" name="IsAdmin" value="true" checked>
                                @else
                                    <input class="form-check-input" type="checkbox" style="margin-right:1.2rem;" onclick="$(this).attr('value', this.checked ? 'true' : 'false')" id="IsAdmin" name="IsAdmin" value="false">
                                @endforelse
                                <label class="form-check-label" for="IsAdmin" style="margin-right:2.4rem;">
                                    کاربر ادمین باشد؟
                                </label>
                            </div>
                            <div class="col-sm-6" style="display:flex;">
                                <a data-toggle="modal" data-target="#UserPasswordModal" class="btn btn-outline-primary btn-block" style="margin:1rem;width:25%;" href="#"><i class="fa fa-lock"></i> تغییر کلمه عبور</a>
                            </div>
                        </div>

                        <button type="submit" id="btnSubmit" class="btn btn-primary btn-user btn-block" style="width:25%;margin:auto;">
                            ذخیره اطلاعات
                        </button>
                    </form>
                    <hr />
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="UserPasswordModal" tabindex="-1" role="dialog" aria-labelledby="UserPasswordModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="UserPasswordModalLabel">تغییر کلمه عبور</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="UserPasswordModalBody">
                <div class="form-group row">
                    <div class="col-sm-8">
                        <input type="password" class="form-control form-control-user" id="NewPassword"
                               placeholder="کلمه عبور جدید">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-8">
                        <input type="password" class="form-control form-control-user" id="RepeatNewPassword"
                               placeholder="تکرار کلمه عبور جدید">
                    </div>
                </div>
            </div>
            <p id="Question" style="margin:0 auto;font-size:xx-large;font-weight:bolder;">آیا برای تغییر کلمه عبور اطمینان دارید؟</p>
            <div class="modal-footer">
                <div class="col-lg-12">
                    <button class="btn btn-success" type="button" style="margin:0 auto;width:15%;" onclick="ChangePassword()" id="btnOk">بلی</button>
                    <button class="btn btn-danger" type="button" style="margin:0 0 0 35%;width:15%;" data-dismiss="modal" id="btnCancel">خیر</button>
                </div>
            </div>
            <div class="alert alert-warning alert-dismissible" role="alert" id="warningAlert" hidden>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <p style="text-align:right;" id="WarningMessage"></p>
            </div>
        </div>
    </div>
</div>

@section ('scripts')
    <script type="text/javascript">
        function ChangePassword()
        {
            if($("#NewPassword").val() != '' && $("#RepeatNewPassword").val() != '')
            {
                if ($("#NewPassword").val() == $("#RepeatNewPassword").val())
                {
                    $.ajax(
                        {
                            url: '@NPMS_WebUI.Controllers.HomeController.ApiBaseAddress' + 'user/ResetPassword?NidUser=' + '@Model.NidUser' + '&NewPassword=' + $("#NewPassword").val(),
                            type: 'post',
                            datatype: 'json',
                            success: function (result) {
                                if (result.HasValue)
                                {
                                    $("#Password").val(result.Message);
                                    $("#SuccessMessage").text('کلمه عبور با موفقیت بروزرسانی گردید');
                                    $("#successAlert").removeAttr('hidden');
                                    window.setTimeout(function () { $("#successAlert").attr('hidden', 'hidden') }, 10000);
                                } else
                                {
                                    $("#ErrorMessage").text('خطا در تغییر کلمه عبور.لطفا مجدد امتحان کنید');
                                    $("#errorAlert").removeAttr('hidden');
                                    window.setTimeout(function () { $("#errorAlert").attr('hidden', 'hidden') }, 10000);
                                }
                            },
                            error: function ()
                            {
                                $("#ErrorMessage").text('خطا در تغییر کلمه عبور.لطفا مجدد امتحان کنید');
                                $("#errorAlert").removeAttr('hidden');
                                window.setTimeout(function () { $("#errorAlert").attr('hidden', 'hidden') }, 10000);
                            }
                        });
                    $("#UserPasswordModal").modal('hide');
                } else
                {
                    $("#WarningMessage").text('کلمه عبور و تکرار کلمه عبور می بایست برابر باشند');
                    $("#warningAlert").removeAttr('hidden');
                    window.setTimeout(function () { $("#warningAlert").attr('hidden', 'hidden') }, 5000);
                }
            } else
            {
                $("#WarningMessage").text('کلمه عبور و تکرار کلمه عبور را وارد نمایید');
                $("#warningAlert").removeAttr('hidden');
                window.setTimeout(function () { $("#warningAlert").attr('hidden', 'hidden') }, 5000);
            }
        }
        function UploadFile()
        {
            AdvanceInProgressBar(0);
            $("#UploadModal").modal('show');
            $("#UploadMessage").attr('hidden', 'hidden');
            AdvanceInProgressBar(10);
            var formData = new FormData();
            formData.append('profile',document.getElementById("ProfilePictureUpload").files[0]);
            $.ajax(
                {
                    url: '@Url.Action("UploadThisFile","Home")',
                    type: 'post',
                    datatype: 'json',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (result)
                    {
                        if (result.HasValue)
                        {
                            window.setTimeout(function () { AdvanceInProgressBar(100); }, 1000);
                            window.setTimeout(function () {
                                $("#ProfilePicture").val(result.Html);
                                $("#userImg").attr('src', 'data:image/jpg;base64,' + result.Html);
                            }, 3000);
                        } else {
                            window.setTimeout(function () {
                                $("#UploadMessage").removeAttr('hidden');
                                $("#UploadMessage").text('خطا در بارگذاری.حجم فایل بیشتر از یک مگابایت می باشد');
                            }, 3000);
                        }
                    },
                    error: function ()
                    {
                        window.setTimeout(function () {
                            $("#UploadMessage").removeAttr('hidden');
                            $("#UploadMessage").text('خطا در بارگذاری.لطفا مجدد امتحان کنید');
                        }, 3000);
                    }
                });
            window.setTimeout(function () { $("#UploadModal").modal('hide'); }, 3000);
        }
    </script>
@endsection

@endsection
