@extends('Layouts.app')

@section('Content')
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="row" style="direction: ltr;margin: 10px;">
                        @if (in_array('3', $sharedData['UserAccessedEntities']))
                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 3)->pluck('rowValue')[0])[4] == 1)
                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">
                                    <a id="btnReturn" class="btn btn-outline-info btn-block"
                                        href="{{ route('user.Users') }}">&larr; بازگشت</a>
                                </div>
                            @endif
                        @endif
                    </div>
                    <div class="alert alert-success alert-dismissible" role="alert" id="successAlert" hidden>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <p style="text-align:right;" id="SuccessMessage"></p>
                    </div>
                    <div class="alert alert-danger alert-dismissible" role="alert" id="errorAlert" hidden>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <p style="text-align:right;" id="ErrorMessage">
                        </p>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible" role="alert" id="errorAlert2">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <p style="text-align:right;" id="ErrorMessage2">
                            <div class="m-auto text-center">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </div>
                            </p>
                        </div>
                    @endif
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">ویرایش کاربر</h1>
                        </div>
                        @if (in_array('3', $sharedData['UserAccessedEntities']))
                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 3)->pluck('rowValue')[0])[1] == 1)
                                <form class="user" action="{{ route('user.SubmitEditUser') }}" id="EditUserForm"
                                    method="POST">
                                    @csrf
                                    <input id="CreateDate" value="{{ $User->CreateDate }}" name="CreateDate" type="text"
                                        hidden>
                                    <input id="LastLoginDate" value="{{ $User->LastLoginDate }}" name="LastLoginDate"
                                        type="datetime" hidden>
                                    <input id="IncorrectPasswordCount" value="{{ $User->IncorrectPasswordCount ?? 0 }}"
                                        name="IncorrectPasswordCount" type="text" hidden>
                                    <input id="IsDisabled" name="IsDisabled" value="{{ $User->IsDisabled }}" type="text"
                                        hidden>
                                    <input id="IsLockedOut" name="IsLockedOut" value="{{ $User->IsLockedOut }}"
                                        type="text" hidden>
                                    <input id="LockoutDeadLine" name="LockoutDeadLine"
                                        value="{{ $User->LockoutDeadLine }}" type="datetime" hidden>
                                    <input id="LastPasswordChangeDate" name="LastPasswordChangeDate"
                                        value="{{ $User->LastPasswordChangeDate }}" type="datetime" hidden>
                                    <input id="last_seen" name="last_seen" value="{{ $User->last_seen }}" type="datetime"
                                        hidden>
                                    <input id="Force_logout" name="Force_logout" value="{{ $User->Force_logout }}"
                                        type="number" hidden>
                                    <input id="NidUser" name="NidUser" value="{{ $User->NidUser }}" type="text" hidden>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="FirstName"
                                                name="FirstName" placeholder="نام" value="{{ $User->FirstName }}">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-user" id="LastName"
                                                name="LastName" placeholder="نام خانوادگی" value="{{ $User->LastName }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="UserName"
                                                name="UserName" placeholder="نام کاربری" value="{{ $User->UserName }}"
                                                readonly>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control form-control-user" id="Password"
                                                name="Password" placeholder="کلمه عبور" value="{{ $User->Password }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="file" accept="image/*" class="custom-file-input"
                                                onchange="UploadFile(1)" id="ProfilePictureUpload"
                                                name="ProfilePictureUpload">
                                            <input type="text" class="custom-file-input" id="ProfilePicture"
                                                name="ProfilePicture" value="{{ $User->ProfilePicture }}" hidden>
                                            <label class="custom-file-label" for="ProfilePictureUpload"
                                                data-browse="انتخاب فایل" style="width:75%;margin:0 auto;">
                                                تغییر پروفایل کاربر
                                            </label>
                                            <p id="UploadMessage" style="text-align:center;color:tomato;" hidden></p>
                                        </div>
                                        <div class="col-sm-6" style="display:flex;">
                                            @if (!empty($User->ProfilePicture))
                                                <div class="frame" style="margin:.5rem;width:50%;margin-left:25%;"
                                                    id="uploadedframe">
                                                    <img src="/storage/images/{{ $User->ProfilePicture }}"
                                                        id="uploadedImage" style="width:100%;height:200px;" />
                                                </div>
                                            @else
                                                <div class="frame" style="margin:.5rem;width:50%;margin-left:25%;"
                                                    id="uploadedframe" hidden>
                                                    <img src="" id="uploadedImage" style="width:100%;height:200px;" />
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <select class="form-control allWidth" data-ng-style="btn-primary" id="RoleId"
                                                placeholder="نقش" name="RoleId" style="padding:0 .75rem;">
                                                <option value="0" disabled>نقش</option>
                                                @foreach ($Roles as $rls)
                                                    @if ($rls->NidRole == $User->RoleId)
                                                        <option value="{{ $rls->NidRole }}" selected
                                                            data-tokens="{{ $rls->Title }}">{{ $rls->Title }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $rls->NidRole }}"
                                                            data-tokens="{{ $rls->Title }}">{{ $rls->Title }}</option>
                                                    @endforelse
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6" style="display:flex;">
                                            <a data-toggle="modal" data-target="#UserPasswordModal"
                                                class="btn btn-outline-primary btn-block" style="margin-right: 2rem;margin-left: 2rem;"
                                                href="#"><i class="fa fa-lock"></i> تغییر کلمه عبور</a>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-md-3 col-lg-4 col-xl-4"></div>
                                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                                            <button type="submit" id="btnSubmit" class="btn btn-primary btn-user btn-block">
                                                ذخیره اطلاعات
                                            </button>
                                        </div>
                                        <div class="col-sm-3 col-md-3 col-lg-4 col-xl-4"></div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-md-3 col-lg-4 col-xl-4"></div>
                                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                                            @if (in_array('3', $sharedData['UserAccessedEntities']))
                                                @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 3)->pluck('rowValue')[0])[4] == 1)
                                                    <a href="{{ route('user.Users') }}"
                                                        class="btn btn-outline-secondary btn-user btn-block">
                                                        لیست کاربران
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-sm-3 col-md-3 col-lg-4 col-xl-4"></div>
                                    </div>
                                </form>
                            @endif
                        @endif
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
                <p id="Question" style="margin:0 auto;font-size:xx-large;font-weight:bolder;">آیا برای تغییر کلمه عبور
                    اطمینان دارید؟</p>
                <div class="modal-footer">
                    <div class="col-lg-12">
                        <button class="btn btn-success" type="button" style="margin:0 auto;width:15%;"
                            onclick="ChangePassword()" id="btnOk">بلی</button>
                        <button class="btn btn-danger" type="button" style="margin:0 0 0 35%;width:15%;"
                            data-dismiss="modal" id="btnCancel">خیر</button>
                    </div>
                </div>
                <div class="alert alert-warning alert-dismissible" role="alert" id="warningAlert" hidden>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <p style="text-align:right;" id="WarningMessage"></p>
                </div>
            </div>
        </div>
    </div>
@section('styles')
<title>سامانه مدیریت تحقیقات - ویرایش کاربر</title>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(function() {
            $('#RoleId').selectize({
                sortField: 'value'
            });
            window.setTimeout(function() {
                $("#errorAlert2").attr('hidden', 'hidden')
            }, 10000);
        });

        function ChangePassword() {
            if ($("#NewPassword").val() != '' && $("#RepeatNewPassword").val() != '') {
                if ($("#NewPassword").val() == $("#RepeatNewPassword").val()) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '/submitchangepassword/' + $("#NidUser").val() + '/' + $("#NewPassword").val(),
                        type: 'post',
                        datatype: 'json',
                        success: function(result) {
                            if (result.HasValue) {
                                $("#Password").val(result.Message);
                                $("#SuccessMessage").text('کلمه عبور با موفقیت بروزرسانی گردید');
                                $("#successAlert").removeAttr('hidden');
                                window.setTimeout(function() {
                                    $("#successAlert").attr('hidden', 'hidden')
                                }, 10000);
                            } else {
                                if(result.AltProp == "1")
                                {
                                $("#ErrorMessage").text('کلمه عبور جدید قبلا استفاده شده است.لطفا کلمه عبور دیگری انتخاب نمایید');
                                $("#errorAlert").removeAttr('hidden');
                                window.setTimeout(function () { $("#errorAlert").attr('hidden', 'hidden') }, 10000);
                                }else if(result.AltProp == "3")
                                {
                                $("#ErrorMessage").text('کلمه عبور جدید با خط مشی تعریف شده در سامانه مطابقت ندارد.لطفا کلمه عبور قوی تر وارد نمایید');
                                $("#errorAlert").removeAttr('hidden');
                                window.setTimeout(function () { $("#errorAlert").attr('hidden', 'hidden') }, 10000);
                                }else
                                {
                                $("#ErrorMessage").text('خطا در سرور.لطفا مجدد امتحان کنید');
                                $("#errorAlert").removeAttr('hidden');
                                window.setTimeout(function () { $("#errorAlert").attr('hidden', 'hidden') }, 10000);
                                }
                            }
                        },
                        error: function() {
                            $("#ErrorMessage").text('خطا در تغییر کلمه عبور.لطفا مجدد امتحان کنید');
                            $("#errorAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#errorAlert").attr('hidden', 'hidden')
                            }, 10000);
                        }
                    });
                    $("#UserPasswordModal").modal('hide');
                } else {
                    $("#WarningMessage").text('کلمه عبور و تکرار کلمه عبور می بایست برابر باشند');
                    $("#warningAlert").removeAttr('hidden');
                    window.setTimeout(function() {
                        $("#warningAlert").attr('hidden', 'hidden')
                    }, 5000);
                }
            } else {
                $("#WarningMessage").text('کلمه عبور و تکرار کلمه عبور را وارد نمایید');
                $("#warningAlert").removeAttr('hidden');
                window.setTimeout(function() {
                    $("#warningAlert").attr('hidden', 'hidden')
                }, 5000);
            }
        }
    </script>
@endsection

@endsection
