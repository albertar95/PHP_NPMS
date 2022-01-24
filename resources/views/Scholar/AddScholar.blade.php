@extends('Layouts.app')

@section('Content')

<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4" style="text-align:center;">اطلاعات محقق</h1>
                    </div>
                    <form class="user" id="AddScholarForm">
                        @csrf
                        <input type="text" id="UserId" name="UserId" value="{{ auth()->user()->NidUser }}" hidden />
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
                                <input type="text" class="form-control form-control-user" id="FatherName" name="FatherName"
                                       placeholder="نام پدر">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control form-control-user" id="observer" name="BirthDate"
                                       placeholder="تاریخ تولد">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="number" class="form-control form-control-user" id="NationalCode" name="NationalCode"
                                       placeholder="کد ملی">
                                <p id="NationalcodeError" style="font-size:.75rem;text-align:center;color:tomato;" hidden></p>
                            </div>
                            <div class="col-sm-6">
                                <input type="number" class="form-control form-control-user" id="Mobile" name="Mobile"
                                       placeholder="شماره همراه">
                                <p id="MobileError" style="font-size:.75rem;text-align:center;color:tomato;" hidden></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <select class="form-control allWidth" data-ng-style="btn-primary" name="GradeId" id="GradeSlt" style="padding:0 .75rem;">
                                    <option value="0" selected>مقطع تحصیلی</option>
                                    @foreach ($Grades->sortBy('SettingTitle') as $grd)
                                        <option value="{{ $grd->SettingValue }}">{{ $grd->SettingTitle }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <select class="form-control allWidth" data-ng-style="btn-primary" name="MillitaryStatus" id="MillitaryStatusSlt" style="padding:0 .75rem;">
                                    <option value="0" selected>وضعیت خدمتی</option>
                                    @foreach ($MillitaryStatuses->sortBy('SettingTitle') as $mls)
                                        <option value="{{ $mls->SettingValue }}">{{ $mls->SettingTitle }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <select class="form-control allWidth" data-ng-style="btn-primary" name="MajorId" id="MajorSlt" style="padding:0 .75rem;">
                                    <option value="0" selected>رشته تحصیلی</option>
                                    @foreach ($Majors->sortBy('Title') as $mjr)
                                        <option value="{{ $mjr->NidMajor }}">{{ $mjr->Title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <select class="form-control allWidth" data-ng-style="btn-primary" name="OreintationId" id="OrentationSlt" style="padding:0 .75rem;">
                                    <option value="0" selected>گرایش</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <select class="form-control allWidth" data-ng-style="btn-primary" name="college" id="collegeSlt" style="padding:0 .75rem;">
                                    <option value="0" selected>محل تحصیل</option>
                                    @foreach ($Colleges->sortBy('SettingTitle') as $col)
                                    <option value="{{ $col->SettingValue }}">{{ $col->SettingTitle }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <select class="form-control allWidth" data-ng-style="btn-primary" name="CollaborationType" id="CollaborationTypeSlt" style="padding:0 .75rem;">
                                    <option value="0" selected>نوع همکاری</option>
                                    @foreach ($CollaborationTypes->sortBy('SettingTitle') as $typ)
                                    <option value="{{ $typ->SettingValue }}">{{ $typ->SettingTitle }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="file" accept="image/*" class="custom-file-input" onchange="UploadFile(1)" id="ProfilePictureUpload" name="ProfilePictureUpload">
                                <input type="text" class="custom-file-input" id="ProfilePicture" name="ProfilePicture" hidden>
                                <label class="custom-file-label" for="ProfilePictureUpload" data-browse="انتخاب فایل" style="width:75%;margin:0 auto;">
                                    تصویر پروفایل محقق
                                </label>
                                <p id="UploadMessage" style="text-align:center;color:tomato;" hidden></p>
                                <div class="frame" style="margin:.5rem;width:50%;margin-left:25%;" id="uploadedframe" hidden>
                                    <img src="" id="uploadedImage" style="width:100%;height:200px;" hidden />
                                </div>
                            </div>
                            <div class="col-sm-6" style="display:flex;padding-right:10%;">
                                <input type="checkbox" style="width:1rem;margin:unset !important;" id="IsConfident" name="IsConfident" class="form-control" onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                <label for="IsConfident" style="margin:.25rem .25rem 0 0">آیا اطلاعات محرمانه است ؟</label>
                            </div>
                        </div>
                        <button type="submit" id="btnSubmit" class="btn btn-primary btn-user btn-block" style="width:25%;margin:auto;">
                            ذخیره اطلاعات
                        </button>
                        <hr>
                    </form>
                    {{-- @if (slvm.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "Scholars").FirstOrDefault().Id))
                    {
                        <a href="{{ URL('scholar.Scholars') }}" class="btn btn-outline-secondary btn-user btn-block" style="width:25%;margin:auto;">
                            لیست محققان
                        </a>
                    } --}}
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

    @section ('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ URL('Content/vendor/PersianDate/css/persian-datepicker.min.css') }}" rel="stylesheet" />
    @endsection
    @section ('scripts')
        <script src="{{ URL('Content/vendor/PersianDate/js/persian-date.min.js') }}"></script>
        <script src="{{ URL('Content/vendor/PersianDate/js/persian-datepicker.min.js') }}"></script>
        <script type="text/javascript">
        var ValiditiyMessage = "";
            var upload = "";
            $(function () {
                var isValidNational = false;
                var isValidTel = false;
                $("#FirstName").focus();
                $("#observer").persianDatepicker({
                    altField: '#observer',
                    altFormat: "YYYY/MM/DD",
                    observer: true,
                    format: 'YYYY/MM/DD',
                    timePicker: {
                        enabled: false
                    },
                    initialValue: false,
                    autoClose: true,
                    responsive: true,
                    maxDate: new persianDate()
                });
                $("#observer").on('change', function ()
                {
                    if(!/^[1-4]\d{3}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/.test($("#observer").val()))
                    {
                        $("#observer").val('');
                    }
                });
                $("#NationalCode").change(function () {
                    if($("#NationalCode").val() == '')
                    {
                        isValidNational = false;
                        $("#NationalcodeError").attr('hidden', 'hidden');
                    } else
                    {
                        if (!isValidNationalCode($("#NationalCode").val())) {
                            $("#NationalcodeError").text('کد ملی وارد شده صحیح نمی باشد');
                            $("#NationalcodeError").removeAttr('hidden');
                            isValidNational = false;
                        } else {
                            isValidNational = true;
                            $("#NationalcodeError").attr('hidden', 'hidden');
                        }
                    }
                });
                $("#Mobile").change(function () {
                    if ($("#Mobile").val() == '')
                    {
                        isValidTel = false;
                        $("#MobileError").attr('hidden', 'hidden');
                    } else
                    {
                        if (!isValidMobile($("#Mobile").val())) {
                            $("#MobileError").text('شماره همراه وارد شده صحیح نمی باشد');
                            $("#MobileError").removeAttr('hidden');
                            isValidTel = false;
                        } else {
                            isValidTel = true;
                            $("#MobileError").attr('hidden', 'hidden');
                        }
                    }
                });
                $("#btnSubmit").click(function (e) {
                    e.preventDefault();
                    if(CheckInputValidity())
                    {
                        var data = $("#AddScholarForm").serializeArray();
                    // for (var item in data) {
                    //     if (data[item].name == 'ProfilePicture') {
                    //         data[item].value = upload;
                    //     }
                    // }
                    $.ajax(
                        {
                            url: '/submitaddscholar',
                            type: 'post',
                            datatype: 'json',
                            data: $("#AddScholarForm").serialize(),
                            success: function (result) {
                                $("#SuccessMessage").text(' محقق با نام ' + result.Message + ' با موفقیت ایجاد گردید ')
                                $("#successAlert").removeAttr('hidden')
                                $('#AddScholarForm').each(function () { this.reset(); });
                                window.setTimeout(function () { $("#successAlert").attr('hidden', 'hidden'); }, 5000);
                                $("#uploadedframe").attr('hidden', 'hidden');
                                $("#uploadedImage").attr('hidden', 'hidden');
                                $("#uploadedImage").attr('src', '');
                            },
                            error: function (response) {
                                var message = "<ul>";
                                jQuery.each( response.responseJSON.errors, function( i, val ) {
                                    message += "<li>";
                                    message += val;
                                    message += "</li>";
                                });
                                message += "</ul>";
                                $("#ErrorMessage").html(message)
                                // $("#ErrorMessage").text('خطا در انجام عملیات.لطفا مجددا امتحان کنید')
                                $("#errorAlert").removeAttr('hidden')
                                window.setTimeout(function () { $("#errorAlert").attr('hidden', 'hidden'); }, 5000);
                            }
                        });
                    }else
                    {
                        $("#ErrorMessage").html(ValiditiyMessage)
                        $("#errorAlert").removeAttr('hidden')
                        window.setTimeout(function () { $("#errorAlert").attr('hidden', 'hidden'); }, 5000);
                        ValiditiyMessage = "";
                    }
                });
                $("#MajorSlt").on('change', function () {
                    $("#OrentationSlt").html('')
                    $.ajax(
                        {
                            url: '/majorselectchanged/' + this.value,
                            type: 'get',
                            datatype: 'json',
                            success: function (result) {
                                // var newValue = "<option value='0' disabled selected>گرایش</option> "
                                // $.each(result, function (i, item) {
                                //     newValue += "<option value='" + item.NidOreintation + "'>" + item.Title + "</option> "
                                // });
                                $("#OrentationSlt").html(result.Html)
                            },
                            error: function () {
                                $("#OrentationSlt").html('<option value="0" selected>گرایش</option> ')
                            }
                        });
                });
            });
            function isValidNationalCode(input) {
                if (!/^\d{10}$/.test(input)) return false;
                const check = +input[9];
                const sum = input.split('').slice(0, 9).map((x, i) => +x * (10 - i)).reduce((x, y) => x + y) % 11;
                return sum < 2 ? check == sum : check + sum == 11;
            }
            function isValidMobile(input)
            {
                return /((\+|00)98|0)9\d{9}/.test(input);
            }
            function CheckInputValidity()
            {
            var isValid = true;
            if(!$("#FirstName").val())
            {
                ValiditiyMessage += '<li>';
                ValiditiyMessage += "نام محقق وارد نشده است";
                ValiditiyMessage += '</li>';
                isValid = false;
            }
            if(!$("#LastName").val())
            {
                ValiditiyMessage += '<li>';
                ValiditiyMessage += "نام خانوادگی محقق وارد نشده است";
                ValiditiyMessage += '</li>';
                isValid = false;
            }
            if(!$("#observer").val())
            {
                ValiditiyMessage += '<li>';
                ValiditiyMessage += "کد ملی وارد نشده است";
                ValiditiyMessage += '</li>';
                isValid = false;
            }
            if($("#MajorSlt").val() == 0)
            {
                ValiditiyMessage += '<li>';
                ValiditiyMessage += "رشته تحصیلی انتخاب نشده است";
                ValiditiyMessage += '</li>';
                isValid = false;
            }
            if($("#GradeSlt").val() == 0)
            {
                ValiditiyMessage += '<li>';
                ValiditiyMessage += "مقطع تحصیلی انتخاب نشده است";
                ValiditiyMessage += '</li>';
                isValid = false;
            }
            if($("#OrentationSlt").val() == 0)
            {
                ValiditiyMessage += '<li>';
                ValiditiyMessage += "گرایش انتخاب نشده است";
                ValiditiyMessage += '</li>';
                isValid = false;
            }
            if($("#CollaborationTypeSlt").val() == 0)
            {
                ValiditiyMessage += '<li>';
                ValiditiyMessage += "نوع همکاری انتخاب نشده است";
                ValiditiyMessage += '</li>';
                isValid = false;
            }
            ValiditiyMessage = "<ul>" + ValiditiyMessage + "</ul>";
            return isValid;
            }
            // function UploadFile() {
            //     AdvanceInProgressBar(0);
            //     $("#UploadMessage").attr('hidden','hidden');
            //     $("#UploadModal").modal('show');
            //     AdvanceInProgressBar(10);
            //     $.ajaxSetup({
            //     headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            //     });
            //     var formData = new FormData();
            //     formData.append('profile', document.getElementById("ProfilePictureUpload").files[0]);
            //     formData.append('fileName', document.getElementById("ProfilePictureUpload").files[0].name);
            //     $.ajax(
            //         {
            //             url: '/uploadthisfile',
            //             type: 'post',
            //             datatype: 'json',
            //             data: formData,
            //             contentType: false,
            //             processData: false,
            //             success: function (result) {
            //                 if (result.HasValue)
            //                 {
            //                     window.setTimeout(function () { AdvanceInProgressBar(100); }, 1000);
            //                     $("#ProfilePicture").val(result.Message);
            //                     window.setTimeout(function () {
            //                         $("#uploadedImage").attr('src', '/storage/images/' + result.Message);
            //                         $("#uploadedframe").removeAttr('hidden');
            //                         $("#uploadedImage").removeAttr('hidden');
            //                     }, 3000);
            //                 } else
            //                 {
            //                     window.setTimeout(function () {
            //                         $("#UploadMessage").removeAttr('hidden');
            //                         $("#UploadMessage").text('خطا در بارگذاری.حجم فایل بیشتر از یک مگابایت می باشد');
            //                     }, 3000);
            //                 }
            //             },
            //             error: function ()
            //             {
            //                 window.setTimeout(function () {
            //                     $("#UploadMessage").removeAttr('hidden');
            //                     $("#UploadMessage").text('خطا در بارگذاری.لطفا مجدد امتحان کنید');},3000);
            //             }
            //         });
            //     window.setTimeout(function () { $("#UploadModal").modal('hide'); }, 3000);
            // }
        </script>
    @endsection


@endsection
