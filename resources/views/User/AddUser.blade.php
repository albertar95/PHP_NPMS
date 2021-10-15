@extends('Layouts.app')

@section('Content')

<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">اطلاعات کاربر</h1>
                    </div>
                    <form class="user" id="AddUserForm">
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user" id="FirstName" name="FirstName"
                                       placeholder="نام">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control form-control-user" id="LastName" name="LastName"
                                       placeholder="نام خانوادگی">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user" id="Username" name="Username"
                                       placeholder="نام کاربری">
                            </div>
                            <div class="col-sm-6">
                                <input type="password" class="form-control form-control-user" id="Password" name="Password"
                                       placeholder="کلمه عبور">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="file" accept="image/*" class="custom-file-input" onchange="UploadFile()" id="ProfilePictureUpload" name="ProfilePictureUpload">
                                <input type="text" class="custom-file-input" id="ProfilePicture" name="ProfilePicture" hidden>
                                <label class="custom-file-label" for="ProfilePictureUpload" data-browse="انتخاب فایل" style="width:75%;margin:0 auto;">
                                    انتخاب تصویر کاربر
                                </label>
                                <p id="UploadMessage" style="text-align:center;color:tomato;" hidden></p>
                                <div class="frame" style="margin:.5rem;width:50%;margin-left:25%;" id="uploadedframe" hidden>
                                    <img src="" id="uploadedImage" style="width:100%;height:200px;" hidden />
                                </div>
                            </div>
                            <div class="col-sm-6" style="display:flex;padding-right:10%;">
                                <label>نقش کاربر : </label>
                                <select class="form-control allWidth" data-ng-style="btn-primary" id="RoleId"
                                name="RoleId" style="padding:0 0 0 .75rem;">
                                <option value="0" disabled selected>نقش کاربر</option>
                                @foreach ($Roles as $rls)
                                    <option value="{{ $rls->NidRole }}">{{ $rls->Title }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                        <button type="submit" id="btnSubmit" class="btn btn-primary btn-user btn-block" style="width:25%;margin:auto;">
                            ذخیره اطلاعات
                        </button>
                        <hr />
                    </form>
                    @if(in_array('3',$sharedData['UserAccessedEntities']))
                        @if(explode(',',$sharedData['UserAccessedSub']->where('entity','=',3)->pluck('rowValue')[0])[4] == 1)
                        <a href="{{ route('user.Users') }}" class="btn btn-outline-secondary btn-user btn-block" style="width:25%;margin:auto;">
                        لیست کاربران
                        </a>
                        @endif
                    @endif
                    <div class="alert alert-success alert-dismissible" role="alert" id="successAlert" hidden>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <p style="text-align:right;" id="SuccessMessage"></p>
                    </div>
                    <div class="alert alert-warning alert-dismissible" role="alert" id="warningAlert" hidden>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <p style="text-align:right;" id="WarningMessage"></p>
                    </div>
                    <div class="alert alert-danger alert-dismissible" role="alert" id="errorAlert" hidden>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <p style="text-align:right;" id="ErrorMessage"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts')
    <script type="text/javascript">
        var upload = null;
            $(function () {
                $("#btnSubmit").click(function (e) {
                    e.preventDefault();
                    $.ajax(
                        {
                            url: '/submitadduser',
                            type: 'post',
                            datatype: 'json',
                            data: $("#AddUserForm").serialize(),
                            success: function (result) {
                                $("#SuccessMessage").text(' کاربر با نام ' + result.FirstName + ' ' + result.LastName + ' با موفقیت ایجاد گردید ');
                                $("#successAlert").removeAttr('hidden');
                                $('#AddUserForm').each(function () { this.reset(); });
                                window.setTimeout(function () { $("#successAlert").attr('hidden', 'hidden'); }, 5000);
                                $("#uploadedframe").attr('hidden','hidden');
                                $("#uploadedImage").attr('hidden', 'hidden');
                                $("#uploadedImage").attr('src', '');
                            },
                            error: function () {
                                $("#ErrorMessage").text('خطا در انجام عملیات.لطفا مجددا امتحان کنید')
                                $("#errorAlert").removeAttr('hidden')
                                window.setTimeout(function () { $("#errorAlert").attr('hidden', 'hidden'); }, 5000);
                            }
                        });
                });
            });
    </script>
@endsection
@endsection
