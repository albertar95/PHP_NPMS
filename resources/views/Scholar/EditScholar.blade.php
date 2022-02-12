@extends('Layouts.app')

@section('Content')

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div style="direction: ltr">
                        @if (in_array('1', $sharedData['UserAccessedEntities']))
                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 1)->pluck('rowValue')[0])[4] == 1)
                                <a id="btnReturn" class="btn btn-outline-info btn-block" style="margin:1rem;width:25%;"
                                    href="{{ route('scholar.Scholars') }}">&larr; بازگشت</a>
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
                                            <select class="form-control allWidth" data-ng-style="btn-primary" name="GradeId" placeholder="مقطع تحصیلی" id="GradeSlt"
                                                style="padding:0 .75rem;">
                                                <option value="0" disabled>مقطع تحصیلی</option>
                                                @foreach ($Grades->sortBy('SettingTitle') as $grd)
                                                    @if ($grd->IsDeleted)
                                                        @if ($grd->SettingValue == $Scholar->GradeId)
                                                            <option value="{{ $Scholar->SettingValue }}" selected data-tokens="{{ $Scholar->SettingTitle }}">
                                                                {{ $Scholar->SettingTitle }}</option>
                                                        @endif
                                                    @else
                                                        @if ($grd->SettingValue == $Scholar->GradeId)
                                                            <option value="{{ $grd->SettingValue }}" selected data-tokens="{{ $Scholar->SettingTitle }}">
                                                                {{ $grd->SettingTitle }}</option>
                                                        @else
                                                            <option value="{{ $grd->SettingValue }}" data-tokens="{{ $Scholar->SettingTitle }}">
                                                                {{ $grd->SettingTitle }}
                                                            </option>
                                                        @endforelse
                                                    @endforelse
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <select class="form-control allWidth" data-ng-style="btn-primary" placeholder="وضعیت خدمتی" id="MillitaryStatusSlt"
                                                name="MillitaryStatus" style="padding:0 .75rem;">
                                                <option value="0" disabled>وضعیت خدمتی</option>
                                                @foreach ($MillitaryStatuses->sortBy('SettingTitle') as $mls)
                                                    @if ($mls->IsDeleted)
                                                        @if ($mls->SettingValue == $Scholar->MillitaryStatus)
                                                            <option value="{{ $mls->SettingValue }}" selected data-tokens="{{ $mls->SettingTitle }}">
                                                                {{ $mls->SettingTitle }}</option>
                                                        @endif
                                                    @else
                                                        @if ($grd->SettingValue == $Scholar->GradeId)
                                                            <option value="{{ $mls->SettingValue }}" selected data-tokens="{{ $mls->SettingTitle }}">
                                                                {{ $mls->SettingTitle }}</option>
                                                        @else
                                                            <option value="{{ $mls->SettingValue }}" data-tokens="{{ $mls->SettingTitle }}">
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
                                            <select class="form-control allWidth" data-ng-style="btn-primary" name="MajorId" placeholder="رشته تحصیلی" id="MajorSlt"
                                                id="MajorSlt" style="padding:0 .75rem;">
                                                <option value="0" disabled>رشته تحصیلی</option>
                                                @foreach ($Majors->sortBy('Title') as $mjr)
                                                    @if ($mjr->NidMajor == $Scholar->MajorId)
                                                        <option value="{{ $mjr->NidMajor }}" selected data-tokens="{{ $mjr->Title }}">
                                                            {{ $mjr->Title }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $mjr->NidMajor }}" data-tokens="{{ $mjr->Title }}">{{ $mjr->Title }}
                                                        </option>
                                                    @endforelse
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <select class="form-control allWidth" data-ng-style="btn-primary" placeholder="گرایش"
                                                name="OreintationId" id="OrentationSlt" style="padding:0 .75rem;">
                                                <option value="0" disabled>گرایش</option>
                                                @foreach ($Oreintations->sortBy('Title') as $orn)
                                                    @if ($orn->NidOreintation == $Scholar->OreintationId)
                                                        <option value="{{ $orn->NidOreintation }}" selected data-tokens="{{ $orn->Title }}">
                                                            {{ $orn->Title }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $orn->NidOreintation }}" data-tokens="{{ $orn->Title }}">{{ $orn->Title }}
                                                        </option>
                                                    @endforelse
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <select class="form-control allWidth" data-ng-style="btn-primary" name="college" placeholder="محل تحصیل" id="collegeSlt"
                                                style="padding:0 .75rem;">
                                                <option value="0" disabled>محل تحصیل</option>
                                                @foreach ($Colleges->sortBy('SettingTitle') as $mls)
                                                    @if ($mls->IsDeleted)
                                                        @if ($mls->SettingValue == $Scholar->college)
                                                            <option value="{{ $mls->SettingValue }}" selected data-tokens="{{ $mls->SettingTitle }}">
                                                                {{ $mls->SettingTitle }}</option>
                                                        @endif
                                                    @else
                                                        @if ($mls->SettingValue == $Scholar->college)
                                                            <option value="{{ $mls->SettingValue }}" selected data-tokens="{{ $mls->SettingTitle }}">
                                                                {{ $mls->SettingTitle }}</option>
                                                        @else
                                                            <option value="{{ $mls->SettingValue }}" data-tokens="{{ $mls->SettingTitle }}">
                                                                {{ $mls->SettingTitle }}
                                                            </option>
                                                        @endforelse
                                                    @endforelse
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <select class="form-control allWidth" data-ng-style="btn-primary" palceholder="نوع همکاری" id="CollaborationTypeSlt"
                                                name="CollaborationType" style="padding:0 .75rem;">
                                                <option value="0" disabled>نوع همکاری</option>
                                                @foreach ($CollaborationTypes->sortBy('SettingTitle') as $typ)
                                                    @if ($typ->IsDeleted)
                                                        @if ($typ->SettingValue == $Scholar->CollaborationType)
                                                            <option value="{{ $typ->SettingValue }}" selected data-tokens="{{ $typ->SettingTitle }}">
                                                                {{ $typ->SettingTitle }}</option>
                                                        @endif
                                                    @else
                                                        @if ($mls->SettingValue == $Scholar->CollaborationType)
                                                            <option value="{{ $typ->SettingValue }}" selected data-tokens="{{ $typ->SettingTitle }}">
                                                                {{ $typ->SettingTitle }}</option>
                                                        @else
                                                            <option value="{{ $typ->SettingValue }}" data-tokens="{{ $typ->SettingTitle }}">
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
                                                <div class="frame" style="margin:.5rem;width:50%;margin-left:25%;"
                                                    id="uploadedframe">
                                                    <img src="{{ sprintf('/storage/images/%s', $Scholar->ProfilePicture) }}"
                                                        id="userImg" style="width:100%;height:200px;" />
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
                                    <button type="submit" id="btnSubmit" class="btn btn-warning btn-user btn-block"
                                        style="width:25%;margin:auto;">
                                        ویرایش اطلاعات
                                    </button>
                                    <hr>
                                </form>
                            @endif
                        @endif
                        @if (in_array('1', $sharedData['UserAccessedEntities']))
                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 1)->pluck('rowValue')[0])[4] == 1)
                                <a class="btn btn-outline-secondary btn-user btn-block"
                                    href="{{ route('scholar.Scholars') }}" style="width:25%;margin:auto;">لیست محققان</a>
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
@endsection
@section('scripts')
    <script src="{{ URL('Content/vendor/PersianDate/js/persian-date.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/PersianDate/js/persian-datepicker.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('#GradeSlt').selectize({
                sortField: 'value'
            });
            $('#MillitaryStatusSlt').selectize({
                sortField: 'value'
            });
            $('#MajorSlt').selectize({
                sortField: 'value'
            });
            $('#collegeSlt').selectize({
                sortField: 'value'
            });
            $('#CollaborationTypeSlt').selectize({
                sortField: 'value'
            });
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
            $("#MajorSlt").on('change', function() {
                $("#OrentationSlt").html('')
                $.ajax({
                    url: '/majorselectchanged/' + this.value,
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
        });
    </script>
@endsection

@endsection
