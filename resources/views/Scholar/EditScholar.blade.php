@extends('Layouts.app')

@section('Content')

<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-12">
                {{-- @if (slvm1.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "Scholars").FirstOrDefault().Id))
                {
                    <div dir="ltr">
                        <a id="btnReturn" class="btn btn-outline-info btn-block" style="margin:1rem;width:25%;" href="@Url.Action("Scholars","Home")">&larr; بازگشت</a>
                    </div>
                } --}}
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">ویرایش اطلاعات محقق</h1>
                    </div>
                    <form class="user" id="EditScholarForm" method="POST" action="{{ route('scholar.SubmitEditScholar') }}">
                        @csrf
                        <input type="text" id="NidScholar" name="NidScholar" value="{{ $Scholar->NidScholar }}" hidden />
                        <input type="text" id="UserId" name="UserId" value="{{ $Scholar->UserId }}" hidden />
                        @if ($Scholar->IsDeleted)
                        <input type="checkbox" id="IsDeleted" name="IsDeleted" checked hidden/>
                        @else
                        <input type="checkbox" id="IsDeleted" name="IsDeleted" hidden/>
                        @endforelse
                        <input type="text" id="DeleteDate" name="DeleteDate" value="{{ $Scholar->DeleteDate }}" hidden />
                        <input type="text" id="DeleteUser" name="DeleteUser" value="{{ $Scholar->DeleteUser }}" hidden />
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user" id="FirstName" name="FirstName"
                                       placeholder="نام" value="{{ $Scholar->FirstName }}">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control form-control-user" id="LastName" name="LastName"
                                       placeholder="نام خانوادگی" value="{{ $Scholar->LastName }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user" id="FatherName" name="FatherName"
                                       placeholder="نام پدر" value="{{ $Scholar->FatherName }}">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control form-control-user" id="observer" name="BirthDate"
                                       placeholder="تاریخ تولد" value="{{ $Scholar->BirthDate }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="number" class="form-control form-control-user" id="NationalCode" name="NationalCode"
                                       placeholder="کد ملی" value="{{ $Scholar->NationalCode }}">
                            </div>
                            <div class="col-sm-6">
                                <input type="number" class="form-control form-control-user" id="Mobile" name="Mobile"
                                       placeholder="شماره همراه" value="{{ $Scholar->Mobile }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <select class="form-control allWidth" data-ng-style="btn-primary" name="GradeId" style="padding:0 .75rem;">
                                    <option value="0" disabled>مقطع تحصیلی</option>
                                    @foreach ($Grades->sortBy('SettingTitle') as $grd)
                                        @if ($grd->IsDeleted)
                                            @if ($grd->SettingValue == $Scholar->GradeId)
                                                <option value="{{ $Scholar->SettingValue }}" selected>{{ $Scholar->SettingTitle }}</option>
                                            @endif
                                        @else
                                            @if ($grd->SettingValue == $Scholar->GradeId)
                                                <option value="{{ $grd->SettingValue }}" selected>{{ $grd->SettingTitle }}</option>
                                            @else
                                                <option value="{{ $grd->SettingValue }}">{{ $grd->SettingTitle }}</option>
                                            @endforelse
                                        @endforelse
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <select class="form-control allWidth" data-ng-style="btn-primary" name="MillitaryStatus" style="padding:0 .75rem;">
                                    <option value="0" disabled>وضعیت خدمتی</option>
                                    @foreach ($MillitaryStatuses->sortBy('SettingTitle') as $mls)
                                        @if ($mls->IsDeleted)
                                            @if ($mls->SettingValue == $Scholar->MillitaryStatus)
                                                <option value="{{ $mls->SettingValue }}" selected>{{ $mls->SettingTitle }}</option>
                                            @endif
                                        @else
                                            @if ($grd->SettingValue == $Scholar->GradeId)
                                                <option value="{{ $mls->SettingValue }}" selected>{{ $mls->SettingTitle }}</option>
                                            @else
                                                <option value="{{ $mls->SettingValue }}">{{ $mls->SettingTitle }}</option>
                                            @endforelse
                                        @endforelse
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <select class="form-control allWidth" data-ng-style="btn-primary" name="MajorId" id="MajorSlt" style="padding:0 .75rem;">
                                    <option value="0" disabled>رشته تحصیلی</option>
                                    @foreach ($Majors->sortBy('Title') as $mjr)
                                    @if ($mjr->NidMajor == $Scholar->MajorId)
                                    <option value="{{ $mjr->NidMajor }}" selected>{{ $mjr->Title }}</option>
                                    @else
                                    <option value="{{ $mjr->NidMajor }}">{{ $mjr->Title }}</option>
                                    @endforelse
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <select class="form-control allWidth" data-ng-style="btn-primary" name="OreintationId" id="OrentationSlt" style="padding:0 .75rem;">
                                    <option value="0" disabled>گرایش</option>
                                    @foreach ($Oreintations->sortBy('Title') as $orn)
                                    @if ($orn->NidOreintation == $Scholar->OreintationId)
                                    <option value="{{ $orn->NidOreintation }}" selected>{{ $orn->Title }}</option>
                                    @else
                                    <option value="{{ $orn->NidOreintation }}">{{ $orn->Title }}</option>
                                    @endforelse
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <select class="form-control allWidth" data-ng-style="btn-primary" name="college" style="padding:0 .75rem;">
                                    <option value="0" disabled>محل تحصیل</option>
                                    @foreach ($Colleges->sortBy('SettingTitle') as $mls)
                                    @if ($mls->IsDeleted)
                                        @if ($mls->SettingValue == $Scholar->college)
                                            <option value="{{ $mls->SettingValue }}" selected>{{ $mls->SettingTitle }}</option>
                                            @endif
                                    @else
                                        @if ($mls->SettingValue == $Scholar->college)
                                            <option value="{{ $mls->SettingValue }}" selected>{{ $mls->SettingTitle }}</option>
                                        @else
                                            <option value="{{ $mls->SettingValue }}">{{ $mls->SettingTitle }}</option>
                                        @endforelse
                                        @endforelse
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <select class="form-control allWidth" data-ng-style="btn-primary" name="CollaborationType" style="padding:0 .75rem;">
                                    <option value="0" disabled>نوع همکاری</option>
                                    @foreach ($CollaborationTypes->sortBy('SettingTitle') as $typ)
                                    @if ($typ->IsDeleted)
                                        @if ($typ->SettingValue == $Scholar->CollaborationType)
                                            <option value="{{ $typ->SettingValue }}" selected>{{ $typ->SettingTitle }}</option>
                                            @endif
                                    @else
                                        @if ($mls->SettingValue == $Scholar->CollaborationType)
                                            <option value="{{ $typ->SettingValue }}" selected>{{ $typ->SettingTitle }}</option>
                                        @else
                                            <option value="{{ $typ->SettingValue }}">{{ $typ->SettingTitle }}</option>
                                        @endforelse
                                        @endforelse
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="file" accept="image/*" class="custom-file-input" onchange="UploadFile()" id="ProfilePictureUpload" name="ProfilePictureUpload">
                                <input type="text" class="custom-file-input" id="ProfilePicture" name="ProfilePicture" value="{{ $Scholar->ProfilePicture }}" hidden>
                                <label class="custom-file-label" for="ProfilePictureUpload" data-browse="انتخاب فایل" style="width:75%;margin:0 auto;">
                                    تغییر پروفایل کاربر
                                </label>
                                <p id="UploadMessage" style="text-align:center;color:tomato;" hidden></p>
                            </div>
                            <div class="col-sm-6" style="display:flex;">
                                @if (!empty($Scholar->ProfilePicture))
                                    {{-- var imgSrc = String.Format("data:image/jpg;base64,{0}", Model.Scholar.ProfilePicture); --}}
                                    <div class="frame" style="margin:.5rem;width:50%;margin-left:25%;" id="uploadedframe">
                                        <img src="@imgSrc" id="userImg" style="width:100%;height:200px;" />
                                    </div>
                                @else
                                    <div class="frame" style="margin:.5rem;width:50%;margin-left:25%;" id="uploadedframe" hidden>
                                        <img src="" id="userImg" style="width:100%;height:200px;" />
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <button type="submit" id="btnSubmit" class="btn btn-warning btn-user btn-block" style="width:25%;margin:auto;">
                            ویرایش اطلاعات
                        </button>
                        <hr>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('styles')
    <link href="{{ URL('Content/vendor/PersianDate/css/persian-datepicker.min.css') }}" rel="stylesheet" />
@endsection
@section('scripts')
    <script src="{{ URL('Content/vendor/PersianDate/js/persian-date.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/PersianDate/js/persian-datepicker.min.js') }}"></script>
    <script type="text/javascript">
            $(function () {
                $("#observer").persianDatepicker({
                    altField: '#observer',
                    altFormat: "YYYY/MM/DD",
                    observer: true,
                    format: 'YYYY/MM/DD',
                    timePicker: {
                        enabled: true
                    },
                    initialValue: false,
                    autoClose: true,
                    responsive: true,
                    maxDate: new persianDate()
                });
                $("#MajorSlt").on('change', function () {
                    $("#OrentationSlt").html('')
                    $.ajax(
                        {
                            url: '@NPMS_WebUI.Controllers.HomeController.ApiBaseAddress' + 'scholar/GetOreintationsByMajorId?MajorId=' + this.value,
                            type: 'get',
                            datatype: 'json',
                            success: function (result) {
                                var newValue = "<option value='0' disabled selected>گرایش</option> "
                                $.each(result, function (i, item) {
                                    newValue += "<option value='" + item.NidOreintation + "'>" + item.Title + "</option> "
                                });
                                $("#OrentationSlt").html(newValue)
                            },
                            error: function () {
                                $("#OrentationSlt").html('<option value="0" disabled selected>گرایش</option> ')
                            }
                        });
                });
            });
        function UploadFile() {
            AdvanceInProgressBar(0);
            $("#UploadMessage").attr('hidden', 'hidden');
            $("#UploadModal").modal('show');
            AdvanceInProgressBar(10);
            var formData = new FormData();
            formData.append('profile', document.getElementById("ProfilePictureUpload").files[0]);
            $.ajax(
                {
                    url: '@Url.Action("UploadThisFile","Home")',
                    type: 'post',
                    datatype: 'json',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result.HasValue)
                        {
                            window.setTimeout(function () { AdvanceInProgressBar(100); }, 1000);
                            window.setTimeout(function () {
                                $("#ProfilePicture").val(result.Html);
                                $("#userImg").attr('src', 'data:image/jpg;base64,' + result.Html);
                                $("#uploadedframe").removeAttr('hidden');
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
