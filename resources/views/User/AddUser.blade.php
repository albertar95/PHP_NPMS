@extends('Layouts.app')

@section('Content')

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">ایجاد کاربر</h1>
                        </div>
                        @if (in_array('3', $sharedData['UserAccessedEntities']))
                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 3)->pluck('rowValue')[0])[0] == 1)
                                <form class="user" id="AddUserForm">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="FirstName"
                                                name="FirstName" placeholder="نام">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-user" id="LastName"
                                                name="LastName" placeholder="نام خانوادگی">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="UserName"
                                                name="UserName" placeholder="نام کاربری">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control form-control-user" id="Password"
                                                name="Password" placeholder="کلمه عبور">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="file" accept="image/*" class="custom-file-input"
                                                onchange="UploadFile(1)" id="ProfilePictureUpload"
                                                name="ProfilePictureUpload">
                                            <input type="text" class="custom-file-input" id="ProfilePicture"
                                                name="ProfilePicture" hidden>
                                            <label class="custom-file-label" for="ProfilePictureUpload"
                                                data-browse="انتخاب فایل" style="width:75%;margin:0 auto;">
                                                انتخاب تصویر کاربر
                                            </label>
                                            <p id="UploadMessage" style="text-align:center;color:tomato;" hidden></p>
                                            <div class="frame" style="margin:.5rem;width:50%;margin-left:25%;"
                                                id="uploadedframe" hidden>
                                                <img src="" id="uploadedImage" style="width:100%;height:200px;" hidden />
                                            </div>
                                        </div>
                                        <div class="col-sm-6" style="display:flex;">
                                            {{-- <label>نقش کاربر : </label> --}}
                                            <select class="form-control allWidth" data-ng-style="btn-primary" id="RoleId" placeholder="نقش کاربر"
                                                name="RoleId" style="padding:0 0 0 .75rem;">
                                                <option value="0" selected>نقش کاربر</option>
                                                @foreach ($Roles as $rls)
                                                    <option value="{{ $rls->NidRole }}" data-tokens="{{ $rls->Title }}">{{ $rls->Title }}</option>
                                                @endforeach
                                            </select>
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
                                                <a href="{{ route('user.Users') }}" class="btn btn-outline-secondary btn-user btn-block">
                                                    لیست کاربران
                                                </a>
                                            @endif
                                        @endif
                                        </div>
                                        <div class="col-sm-3 col-md-3 col-lg-4 col-xl-4"></div>
                                    </div>
                                    <hr />
                                </form>
                            @endif
                        @endif
                        <div class="alert alert-success alert-dismissible" role="alert" id="successAlert" hidden>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <p style="text-align:right;" id="SuccessMessage"></p>
                        </div>
                        <div class="alert alert-warning alert-dismissible" role="alert" id="warningAlert" hidden>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <p style="text-align:right;" id="WarningMessage"></p>
                        </div>
                        <div class="alert alert-danger alert-dismissible" role="alert" id="errorAlert" hidden>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <p style="text-align:right;" id="ErrorMessage"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('styles')
<title>سامانه مدیریت تحقیقات - ایجاد کاربر</title>
@endsection
@section('scripts')
    <script type="text/javascript">
        var ValiditiyMessage = "";
        var upload = null;
        $(function() {
            $('#RoleId').selectize({
                sortField: 'value'
            });
            $("#FirstName").focus();
            $("#btnSubmit").click(function(e) {
                e.preventDefault();
                if (CheckInputValidity()) {
                    $.ajax({
                        url: '/submitadduser',
                        type: 'post',
                        datatype: 'json',
                        data: $("#AddUserForm").serialize(),
                        success: function(result) {
                            $("#SuccessMessage").text(' کاربر با نام ' + result.FirstName +
                                ' ' + result.LastName + ' با موفقیت ایجاد گردید ');
                            $("#successAlert").removeAttr('hidden');
                            $('#AddUserForm').each(function() {
                                this.reset();
                            });
                            // window.setTimeout(function() {
                            //     $("#successAlert").attr('hidden', 'hidden');
                            // }, 5000);
                            $("#uploadedframe").attr('hidden', 'hidden');
                            $("#uploadedImage").attr('hidden', 'hidden');
                            $("#uploadedImage").attr('src', '');
                            window.setTimeout(function() {
                                window.location.href = '/users';
                            }, 3000);
                        },
                        error: function(response) {
                            var message = 'خطا در انجام عملیات.لطفا مجددا امتحان کنید \n';
                            message += "<ul>";
                            jQuery.each(response.responseJSON.errors, function(i, val) {
                                message += "<li>";
                                message += val;
                                message += "</li>";
                            });
                            message += "</ul>";
                            $("#ErrorMessage").html(message)
                            // $("#ErrorMessage").text('خطا در انجام عملیات.لطفا مجددا امتحان کنید')
                            $("#errorAlert").removeAttr('hidden')
                            window.setTimeout(function() {
                                $("#errorAlert").attr('hidden', 'hidden');
                            }, 5000);
                        }
                    });
                } else {
                    $("#ErrorMessage").html(ValiditiyMessage)
                    $("#errorAlert").removeAttr('hidden')
                    window.setTimeout(function() {
                        $("#errorAlert").attr('hidden', 'hidden');
                    }, 5000);
                    ValiditiyMessage = "";
                }
            });
        });

        function CheckInputValidity() {
            var isValid = true;
            if (!$("#FirstName").val()) {
                ValiditiyMessage += '<li>';
                ValiditiyMessage += "نام محقق وارد نشده است";
                ValiditiyMessage += '</li>';
                isValid = false;
            }
            if (!$("#LastName").val()) {
                ValiditiyMessage += '<li>';
                ValiditiyMessage += "نام خانوادگی محقق وارد نشده است";
                ValiditiyMessage += '</li>';
                isValid = false;
            }
            if (!$("#UserName").val()) {
                ValiditiyMessage += '<li>';
                ValiditiyMessage += "نام کاربری وارد نشده است";
                ValiditiyMessage += '</li>';
                isValid = false;
            }
            if (!$("#Password").val()) {
                ValiditiyMessage += '<li>';
                ValiditiyMessage += "کلمه عبور وارد نشده است";
                ValiditiyMessage += '</li>';
                isValid = false;
            }
            if ($("#RoleId").val() == 0) {
                ValiditiyMessage += '<li>';
                ValiditiyMessage += "نقش کاربر انتخاب نشده است";
                ValiditiyMessage += '</li>';
                isValid = false;
            }
            ValiditiyMessage = "<ul>" + ValiditiyMessage + "</ul>";
            return isValid;
        }
    </script>
@endsection
@endsection
