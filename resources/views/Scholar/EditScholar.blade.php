@extends('Layouts.app')

@section('Content')

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="row" style="direction: ltr;margin: 10px;">
                        @if (in_array('1', $sharedData['UserAccessedEntities']))
                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 1)->pluck('rowValue')[0])[4] == 1)
                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">
                                    <a id="btnReturn" class="btn btn-outline-info btn-block"
                                        href="{{ route('scholar.Scholars') }}">&larr; بازگشت</a>
                                </div>
                            @endif
                        @endif
                    </div>
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">ویرایش اطلاعات محقق</h1>
                        </div>
                        @if (in_array('1', $sharedData['UserAccessedEntities']))
                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 1)->pluck('rowValue')[0])[1] == 1)
                                <form class="user" id="EditScholarForm" method="POST"
                                    action="{{ route('scholar.SubmitEditScholar') }}">
                                    @csrf
                                    <input type="text" id="txtCollab" value="{{ $Scholar->CollaborationType }}" hidden>
                                    <input type="text" id="txtMillit" value="{{ $Scholar->MillitaryStatus }}" hidden>
                                    <input type="text" id="txtGrade" value="{{ $Scholar->GradeId }}" hidden>
                                    <input type="text" id="txtMajor" value="{{ $Scholar->MajorId }}" hidden>
                                    <input type="text" id="txtcollege" value="{{ $Scholar->college }}" hidden>
                                    <input type="text" id="NidScholar" name="NidScholar"
                                        value="{{ $Scholar->NidScholar }}" hidden />
                                    <input type="text" id="UserId" name="UserId" value="{{ $Scholar->UserId }}" hidden />
                                    @if ($Scholar->IsDeleted)
                                        <input type="checkbox" id="IsDeleted" name="IsDeleted" value="true" checked
                                            hidden />
                                    @else
                                        <input type="checkbox" id="IsDeleted" name="IsDeleted" value="false" hidden />
                                    @endforelse
                                    <input type="text" id="DeleteDate" name="DeleteDate"
                                        value="{{ $Scholar->DeleteDate }}" hidden />
                                    <input type="text" id="DeleteUser" name="DeleteUser"
                                        value="{{ $Scholar->DeleteUser }}" hidden />
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="FirstName"
                                                name="FirstName" placeholder="نام" value="{{ $Scholar->FirstName }}">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-user" id="LastName"
                                                name="LastName" placeholder="نام خانوادگی"
                                                value="{{ $Scholar->LastName }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="FatherName"
                                                name="FatherName" placeholder="نام پدر"
                                                value="{{ $Scholar->FatherName }}">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-user" id="observer"
                                                name="BirthDate" placeholder="تاریخ تولد"
                                                value="{{ $Scholar->BirthDate }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="number" class="form-control form-control-user" id="NationalCode"
                                                name="NationalCode" placeholder="کد ملی"
                                                value="{{ $Scholar->NationalCode }}">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="number" class="form-control form-control-user" id="Mobile"
                                                name="Mobile" placeholder="شماره همراه" value="{{ $Scholar->Mobile }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <select class="form-control allWidth" data-ng-style="btn-primary" name="GradeId"
                                                placeholder="مقطع تحصیلی" id="GradeSlt" style="padding:0 .75rem;">
                                                <option value="0" disabled>مقطع تحصیلی</option>
                                                @foreach ($Grades->sortBy('SettingTitle') as $grd)
                                                    @if ($grd->IsDeleted)
                                                        @if ($grd->SettingValue == $Scholar->GradeId)
                                                            <option value="{{ $Scholar->SettingValue }}" selected
                                                                data-tokens="{{ $Scholar->SettingTitle }}">
                                                                {{ $Scholar->SettingTitle }}</option>
                                                        @endif
                                                    @else
                                                        @if ($grd->SettingValue == $Scholar->GradeId)
                                                            <option value="{{ $grd->SettingValue }}" selected
                                                                data-tokens="{{ $Scholar->SettingTitle }}">
                                                                {{ $grd->SettingTitle }}</option>
                                                        @else
                                                            <option value="{{ $grd->SettingValue }}"
                                                                data-tokens="{{ $Scholar->SettingTitle }}">
                                                                {{ $grd->SettingTitle }}
                                                            </option>
                                                        @endforelse
                                                    @endforelse
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <select class="form-control allWidth" data-ng-style="btn-primary"
                                                placeholder="وضعیت خدمتی" id="MillitaryStatusSlt" name="MillitaryStatus"
                                                style="padding:0 .75rem;">
                                                <option value="0" disabled>وضعیت خدمتی</option>
                                                @foreach ($MillitaryStatuses->sortBy('SettingTitle') as $mls)
                                                    @if ($mls->IsDeleted)
                                                        @if ($mls->SettingValue == $Scholar->MillitaryStatus)
                                                            <option value="{{ $mls->SettingValue }}" selected
                                                                data-tokens="{{ $mls->SettingTitle }}">
                                                                {{ $mls->SettingTitle }}</option>
                                                        @endif
                                                    @else
                                                        @if ($grd->SettingValue == $Scholar->GradeId)
                                                            <option value="{{ $mls->SettingValue }}" selected
                                                                data-tokens="{{ $mls->SettingTitle }}">
                                                                {{ $mls->SettingTitle }}</option>
                                                        @else
                                                            <option value="{{ $mls->SettingValue }}"
                                                                data-tokens="{{ $mls->SettingTitle }}">
                                                                {{ $mls->SettingTitle }}
                                                            </option>
                                                        @endforelse
                                                    @endforelse
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <select class="form-control allWidth" data-ng-style="btn-primary" name="MajorId"
                                                placeholder="رشته تحصیلی" id="MajorSlt" id="MajorSlt"
                                                style="padding:0 .75rem;">
                                                <option value="0" disabled>رشته تحصیلی</option>
                                                @foreach ($Majors->sortBy('Title') as $mjr)
                                                    @if ($mjr->NidMajor == $Scholar->MajorId)
                                                        <option value="{{ $mjr->NidMajor }}" selected
                                                            data-tokens="{{ $mjr->Title }}">
                                                            {{ $mjr->Title }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $mjr->NidMajor }}"
                                                            data-tokens="{{ $mjr->Title }}">{{ $mjr->Title }}
                                                        </option>
                                                    @endforelse
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <select class="form-control allWidth" data-ng-style="btn-primary"
                                                placeholder="گرایش" name="OreintationId" id="OrentationSlt"
                                                style="padding:0 .75rem;">
                                                <option value="0" disabled>گرایش</option>
                                                @foreach ($Oreintations->sortBy('Title') as $orn)
                                                    @if ($orn->NidOreintation == $Scholar->OreintationId)
                                                        <option value="{{ $orn->NidOreintation }}" selected
                                                            data-tokens="{{ $orn->Title }}">
                                                            {{ $orn->Title }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $orn->NidOreintation }}"
                                                            data-tokens="{{ $orn->Title }}">{{ $orn->Title }}
                                                        </option>
                                                    @endforelse
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <select class="form-control allWidth" data-ng-style="btn-primary" name="college"
                                                placeholder="محل تحصیل" id="collegeSlt" style="padding:0 .75rem;">
                                                <option value="0" disabled>محل تحصیل</option>
                                                @foreach ($Colleges->sortBy('SettingTitle') as $mls)
                                                    @if ($mls->IsDeleted)
                                                        @if ($mls->SettingValue == $Scholar->college)
                                                            <option value="{{ $mls->SettingValue }}" selected
                                                                data-tokens="{{ $mls->SettingTitle }}">
                                                                {{ $mls->SettingTitle }}</option>
                                                        @endif
                                                    @else
                                                        @if ($mls->SettingValue == $Scholar->college)
                                                            <option value="{{ $mls->SettingValue }}" selected
                                                                data-tokens="{{ $mls->SettingTitle }}">
                                                                {{ $mls->SettingTitle }}</option>
                                                        @else
                                                            <option value="{{ $mls->SettingValue }}"
                                                                data-tokens="{{ $mls->SettingTitle }}">
                                                                {{ $mls->SettingTitle }}
                                                            </option>
                                                        @endforelse
                                                    @endforelse
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <select class="form-control allWidth" data-ng-style="btn-primary"
                                                palceholder="نوع همکاری" id="CollaborationTypeSlt" name="CollaborationType"
                                                style="padding:0 .75rem;">
                                                <option value="0" disabled>نوع همکاری</option>
                                                @foreach ($CollaborationTypes->sortBy('SettingTitle') as $typ)
                                                    @if ($typ->IsDeleted)
                                                        @if ($typ->SettingValue == $Scholar->CollaborationType)
                                                            <option value="{{ $typ->SettingValue }}" selected
                                                                data-tokens="{{ $typ->SettingTitle }}">
                                                                {{ $typ->SettingTitle }}</option>
                                                        @endif
                                                    @else
                                                        @if ($mls->SettingValue == $Scholar->CollaborationType)
                                                            <option value="{{ $typ->SettingValue }}" selected
                                                                data-tokens="{{ $typ->SettingTitle }}">
                                                                {{ $typ->SettingTitle }}</option>
                                                        @else
                                                            <option value="{{ $typ->SettingValue }}"
                                                                data-tokens="{{ $typ->SettingTitle }}">
                                                                {{ $typ->SettingTitle }}
                                                            </option>
                                                        @endforelse
                                                    @endforelse
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="file" accept="image/*" class="custom-file-input"
                                                onchange="UploadFile(1)" id="ProfilePictureUpload"
                                                name="ProfilePictureUpload">
                                            <input type="text" class="custom-file-input" id="ProfilePicture"
                                                name="ProfilePicture" value="{{ $Scholar->ProfilePicture }}" hidden>
                                            <label class="custom-file-label" for="ProfilePictureUpload"
                                                data-browse="انتخاب فایل" style="width:75%;margin:0 auto;">
                                                تغییر پروفایل کاربر
                                            </label>
                                            <p id="UploadMessage" style="text-align:center;color:tomato;" hidden></p>
                                        </div>
                                        <div class="col-sm-6" style="display:flex;">
                                            @if (!empty($Scholar->ProfilePicture))
                                                <div class="image-area" style="margin:.5rem;margin-right:25%;"
                                                    id="uploadedframe">
                                                    <a class="remove-image" id="btnDeleteImage" href="#"
                                                        style="display: inline;">&#215;</a>
                                                    <img src="{{ sprintf('/storage/images/%s', $Scholar->ProfilePicture) }}"
                                                        id="uploadedImage" />
                                                </div>
                                            @else
                                                <div class="image-area" style="margin:.5rem;margin-right:25%;"
                                                    id="uploadedframe" hidden>
                                                    <a class="remove-image" id="btnDeleteImage" href="#"
                                                        style="display: inline;">&#215;</a>
                                                    <img src="" id="uploadedImage" />
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0" style="display:flex;padding-right:10%;">
                                            @if (!is_null($Scholar->IsSecurityApproved) && $Scholar->IsSecurityApproved == 1)
                                                <input type="checkbox" style="width:1rem;margin:unset !important;"
                                                    id="IsSecurityApproved" name="IsSecurityApproved" class="form-control"
                                                    value="true" checked onclick="SecurityApproveChanged(this)" />
                                                <label for="IsSecurityApproved" style="margin:.25rem .25rem 0 0">تاییدیه
                                                    حفاظت دارد؟</label>
                                            @elseif(!is_null($Scholar->IsSecurityApproved) && $Scholar->IsSecurityApproved == 0)
                                                <input type="checkbox" style="width:1rem;margin:unset !important;"
                                                    id="IsSecurityApproved" name="IsSecurityApproved" class="form-control"
                                                    value="false" onclick="SecurityApproveChanged(this)" />
                                                <label for="IsSecurityApproved" style="margin:.25rem .25rem 0 0">تاییدیه
                                                    حفاظت دارد؟</label>
                                            @else
                                                <input type="checkbox" style="width:1rem;margin:unset !important;"
                                                    id="IsSecurityApproved" name="IsSecurityApproved" class="form-control"
                                                    onclick="SecurityApproveChanged(this)" />
                                                <label for="IsSecurityApproved" style="margin:.25rem .25rem 0 0">تاییدیه
                                                    حفاظت دارد؟</label>
                                            @endforelse
                                        </div>
                                        <div class="col-sm-6">
                                            @if (!is_null($Scholar->IsSecurityApproved) && $Scholar->IsSecurityApproved == 1)
                                                <input type="text" class="form-control form-control-user"
                                                    id="SecurityApproveDate" name="SecurityApproveDate"
                                                    placeholder="تاریخ نامه حفاظت"
                                                    value="{{ $Scholar->SecurityApproveDate }}">
                                            @elseif(!is_null($Scholar->IsSecurityApproved) && $Scholar->IsSecurityApproved == 0)
                                                <input type="text" class="form-control form-control-user"
                                                    id="SecurityApproveDate" name="SecurityApproveDate"
                                                    placeholder="تاریخ نامه حفاظت" disabled>
                                            @else
                                                <input type="text" class="form-control form-control-user"
                                                    id="SecurityApproveDate" name="SecurityApproveDate"
                                                    placeholder="تاریخ نامه حفاظت" disabled>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0" style="display:flex;padding-right:10%;">
                                            @if (!is_null($Scholar->IsConfident) && $Scholar->IsConfident == 1)
                                                <input type="checkbox" style="width:1rem;margin:unset !important;"
                                                    id="IsConfident" name="IsConfident" class="form-control" value="true"
                                                    checked
                                                    onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                <label for="IsConfident" style="margin:.25rem .25rem 0 0">آیا اطلاعات
                                                    محرمانه است
                                                    ؟</label>
                                            @elseif(!is_null($Scholar->IsConfident) && $Scholar->IsConfident == 0)
                                                <input type="checkbox" style="width:1rem;margin:unset !important;"
                                                    id="IsConfident" name="IsConfident" value="false" class="form-control"
                                                    onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                <label for="IsConfident" style="margin:.25rem .25rem 0 0">آیا اطلاعات
                                                    محرمانه است
                                                    ؟</label>
                                            @else
                                                <input type="checkbox" style="width:1rem;margin:unset !important;"
                                                    id="IsConfident" name="IsConfident" class="form-control"
                                                    onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                <label for="IsConfident" style="margin:.25rem .25rem 0 0">آیا اطلاعات
                                                    محرمانه است
                                                    ؟</label>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-md-3 col-lg-4 col-xl-4"></div>
                                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                                            <button type="submit" id="btnSubmit" class="btn btn-warning btn-user btn-block">
                                                ویرایش اطلاعات
                                            </button>
                                        </div>
                                        <div class="col-sm-3 col-md-3 col-lg-4 col-xl-4"></div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-md-3 col-lg-4 col-xl-4"></div>
                                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                                            @if (in_array('1', $sharedData['UserAccessedEntities']))
                                                @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 1)->pluck('rowValue')[0])[4] == 1)
                                                    <a class="btn btn-outline-secondary btn-user btn-block"
                                                        href="{{ route('scholar.Scholars') }}">لیست محققان</a>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-sm-3 col-md-3 col-lg-4 col-xl-4"></div>
                                    </div>
                                </form>
                            @endif
                        @endif
                        @if ($errors->any())
                            <div class="m-auto text-center">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ URL('Content/vendor/PersianDate/css/persian-datepicker.min.css') }}" rel="stylesheet" />
    <title>سامانه مدیریت تحقیقات - ویرایش محقق</title>
@endsection
@section('scripts')
    <script src="{{ URL('Content/vendor/PersianDate/js/persian-date.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/PersianDate/js/persian-datepicker.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('#CollaborationTypeSlt').selectize()[0].selectize.setValue($("#txtCollab").val(), false);
            $('#GradeSlt').selectize()[0].selectize.setValue($("#txtGrade").val(), false);
            $('#MillitaryStatusSlt').selectize()[0].selectize.setValue($("#txtMillit").val(), false);
            $('#MajorSlt').selectize()[0].selectize.setValue($("#txtMajor").val(), false);
            $('#collegeSlt').selectize()[0].selectize.setValue($("#txtcollege").val(), false);
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
            $("#SecurityApproveDate").persianDatepicker({
                altField: '#SecurityApproveDate',
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
            $("#observer").on('change', function() {
                if (!
                    /^[1-4]\d{3,4}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/
                    .test($("#observer").val())) {
                    $("#observer").val('');
                }
            });
            $("#SecurityApproveDate").on('change', function() {
                if (!
                    /^[1-4]\d{3,4}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/
                    .test($("#SecurityApproveDate").val())) {
                    $("#SecurityApproveDate").val('');
                }
            });
            $("#MajorSlt").on('change', function() {
                $("#OrentationSlt").html('')
                $.ajax({
                    url: '{{ URL::to('/') }}' + '/majorselectchanged/' + this.value,
                    type: 'get',
                    datatype: 'json',
                    success: function(result) {
                        // var newValue = "<option value='0' disabled selected>گرایش</option> "
                        // $.each(result, function (i, item) {
                        //     newValue += "<option value='" + item.NidOreintation + "'>" + item.Title + "</option> "
                        // });
                        $('#OrentationSlt').selectize()[0].selectize.destroy();
                        $("#OrentationSlt").html(result.Html)
                    },
                    error: function() {
                        $("#OrentationSlt").html(
                            '<option value="0" disabled selected>گرایش</option> ')
                    }
                });
            });
            $("#btnDeleteImage").click(function(e)
            {
                e.preventDefault();
                $.ajax({
                    url: '{{ URL::to('/') }}' + '/deleteuploadedimage/' + $("#ProfilePicture")
                        .val(),
                    type: 'post',
                    datatype: 'json',
                    success: function(result) {
                        if (result.HasValue) {
                            $("#ProfilePicture").val('');
                            $("#uploadedframe").attr('hidden', 'hidden');
                            $("#uploadedImage").attr('hidden', 'hidden');
                            $.ajax({
                                url: '{{ URL::to('/') }}' + '/deletescholarprofile/' + $("#NidScholar").val(),
                                type: 'post',
                                datatype: 'json',
                                success: function(result) {},
                                error: function() {}
                            });
                        }else
                        {
                            $("#UploadMessage").text('خطا در حذف فایل')
                            $("#UploadMessage").removeAttr('hidden');
                        }
                    },
                    error: function() {
                        $("#UploadMessage").text('خطا در حذف فایل')
                        $("#UploadMessage").removeAttr('hidden');
                    }
                });

            });
        });

        function SecurityApproveChanged(cb) {
            $(cb).attr('value', cb.checked ? 'true' : 'false')
            if (cb.checked)
                $("#SecurityApproveDate").removeAttr('disabled')
            else {
                $("#SecurityApproveDate").attr('disabled', 'disabled')
                $("#SecurityApproveDate").val('')
            }
        }
    </script>
@endsection

@endsection
