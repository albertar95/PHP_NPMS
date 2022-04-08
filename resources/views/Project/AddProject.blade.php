@extends('Layouts.app')

@section('Content')

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">ایجاد طرح</h1>
                        </div>
                        @if (in_array('2', $sharedData['UserAccessedEntities']))
                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 2)->pluck('rowValue')[0])[0] == 1)
                                <form class="user" id="AddProjectForm">
                                    @csrf
                                    <input type="text" id="UserId" name="UserId" value="{{ auth()->user()->NidUser }}"
                                        hidden />
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="Subject"
                                                name="Subject" placeholder="عنوان طرح">
                                        </div>
                                        <div class="col-sm-6">
                                            <select class="form-control allWidth" data-ng-style="btn-primary"
                                                name="ScholarId" id="ScholarId" style="padding:0 .75rem;"
                                                placeholder="انتخاب محقق">
                                                <option value="0" selected>انتخاب محقق</option>
                                                @foreach ($Scholars->sortBy('LastName') as $sch)
                                                    <option value="{{ $sch->NidScholar }}"
                                                        data-tokens="{{ $sch->FirstName }} {{ $sch->LastName }}">
                                                        {{ $sch->FirstName }}
                                                        {{ $sch->LastName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <select class="form-control allWidth" data-ng-style="btn-primary" name="UnitId"
                                                id="UnitId" style="padding:0 .75rem;" placeholder="انتخاب یگان">
                                                <option value="0" selected>انتخاب یگان کاربر</option>
                                                @foreach ($Units->sortBy('Title') as $uni)
                                                    <option value="{{ $uni->NidUnit }}" data-tokens="{{ $uni->Title }}">
                                                        {{ $uni->Title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <select class="form-control allWidth" data-ng-style="btn-primary" name="GroupId"
                                                id="GroupId" style="padding:0 .75rem;" placeholder="انتخاب گروه">
                                                <option value="0" selected>انتخاب گروه</option>
                                                @foreach ($UnitGroups->sortBy('Title') as $ung)
                                                    <option value="{{ $ung->NidGroup }}"
                                                        data-tokens="{{ $ung->Title }}">{{ $ung->Title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0" style="display:flex;padding-right:10%;">
                                            <input type="checkbox"
                                                style="width:1rem;margin:unset !important;margin-right:10%;"
                                                id="TitleApproved" name="TitleApproved" class="form-control"
                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                            <label for="TitleApproved" style="margin:.25rem .25rem 0 0">عنوان طرح تایید شده
                                                است؟</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-user" id="ATFLetterDate"
                                                name="ATFLetterDate" placeholder="تاریخ ارسال نامه به عتف">
                                        </div>
                                    </div>
                                    <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                                        <!-- Card Header - Accordion -->
                                        <a href="#collapseExtraItems" class="d-block card-header py-3 collapsed"
                                            data-toggle="collapse" role="button" aria-expanded="false"
                                            aria-controls="collapseExtraItems">
                                            <h6 class="m-0 font-weight-bold text-primary">اطلاعات تکمیلی</h6>
                                        </a>
                                        <!-- Card Content - Collapse -->
                                        <div class="collapse" id="collapseExtraItems">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="Supervisor" name="Supervisor" placeholder="استاد راهنما">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="SupervisorMobile" name="SupervisorMobile"
                                                            placeholder="شماره تماس استاد راهنما">
                                                        <p id="SupervisorMobileError"
                                                            style="font-size:.75rem;text-align:center;color:tomato;" hidden>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="Advisor" name="Advisor" placeholder="استاد مشاور">
                                                        <p id="AdvisorMobileError"
                                                            style="font-size:.75rem;text-align:center;color:tomato;" hidden>
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="AdvisorMobile" name="AdvisorMobile"
                                                            placeholder="شماره تماس استاد مشاور">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="Referee1" name="Referee1" placeholder="داور اول">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="Referee2" name="Referee2" placeholder="داور دوم">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="PreImploymentLetterDate" name="PreImploymentLetterDate"
                                                            placeholder="تاریخ رو گرفت">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="ImploymentDate" name="ImploymentDate"
                                                            placeholder="تاریخ بکارگیری">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="Editor" name="Editor" placeholder="ویراستار">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="TenPercentLetterDate" name="TenPercentLetterDate"
                                                            placeholder="تاریخ نامه 10 درصد">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="ThirtyPercentLetterDate" name="ThirtyPercentLetterDate"
                                                            placeholder="تاریخ تحویل فرم 30 درصد">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="SixtyPercentLetterDate" name="SixtyPercentLetterDate"
                                                            placeholder="تاریخ تحویل فرم 60 درصد">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        {{-- <input type="text" class="form-control form-control-user"
                                                            id="SecurityLetterDate" name="SecurityLetterDate"
                                                            placeholder="تاریخ نامه حفاظت"> --}}
                                                            <input type="text" class="form-control form-control-user"
                                                            id="ThesisDefenceDate" name="ThesisDefenceDate"
                                                            placeholder="تاریخ دفاعیه">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-user"
                                                        id="ThesisDefenceLetterDate" name="ThesisDefenceLetterDate"
                                                        placeholder="تاریخ ارسال نامه دفاعیه">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <input type="number" class="form-control form-control-user"
                                                        id="ReducePeriod" name="ReducePeriod" placeholder="مدت کسری">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <textarea class="form-control" id="Commision" name="Commision"
                                                        placeholder="کمیسیون" rows="5"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0" style="display:flex;padding-right:10%;">
                                                        <input type="checkbox"
                                                        style="width:1rem;margin:unset !important;margin-right:10%;"
                                                        id="HasBookPublish" name="HasBookPublish" class="form-control"
                                                        onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                    <label for="HasBookPublish" style="margin:.25rem .25rem 0 0">چاپ
                                                        کتاب
                                                        دارد؟</label>
                                                    </div>
                                                    <div class="col-sm-6" style="display:flex;padding-right:10%;">
                                                        <input type="checkbox" style="width:1rem;margin:unset !important;"
                                                        id="FinalApprove" name="FinalApprove" class="form-control"
                                                        onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                    <label for="FinalApprove" style="margin:.25rem .25rem 0 0">تایید
                                                        نهایی
                                                        طرح</label>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0"
                                                        style="display:flex;padding-right:10%;">
                                                        <input type="checkbox" style="width:1rem;margin:unset !important;"
                                                        id="IsConfident" name="IsConfident" class="form-control"
                                                        onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                    <label for="IsConfident" style="margin:.25rem .25rem 0 0">آیا
                                                        اطلاعات
                                                        محرمانه است ؟</label>
                                                    </div>
                                                    <div class="col-sm-6" style="display:flex;padding-right:10%;">
                                                        <input type="checkbox" style="width:1rem;margin:unset !important;"
                                                        id="IsDisabled" name="IsDisabled" class="form-control"
                                                        onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                    <label for="IsDisabled" style="margin:.25rem .25rem 0 0">طرح غیرفعال
                                                        شود؟</label>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <input type="file" multiple class="custom-file-input"
                                                            onchange="UploadFile(2)" id="FileUpload" name="FileUpload">
                                                        <input type="text" class="custom-file-input" id="FileUploadIds"
                                                            name="FileUploadIds" hidden>
                                                        <label class="custom-file-label" for="FileUpload"
                                                            data-browse="انتخاب فایل ها"
                                                            style="width:75%;margin:0 auto;">انتخاب فایل ها
                                                        </label>
                                                        <p id="FileUploadMessage" style="text-align:center;color:tomato;"
                                                            hidden></p>
                                                    </div>
                                                    <div class="col-sm-6" style="display:flex;padding-right:10%;" id="uploadedFileDemo">
                                                    </div>
                                                </div>
                                                {{-- <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0"
                                                        style="display:flex;padding-right:10%;">
                                                    </div>
                                                    <div class="col-sm-6" style="display:flex;padding-right:10%;">
                                                    </div>
                                                </div> --}}
                                            </div>
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
                                            @if (in_array('2', $sharedData['UserAccessedEntities']))
                                                @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 2)->pluck('rowValue')[0])[4] == 1)
                                                    <a class="btn btn-outline-secondary btn-user btn-block"
                                                        href="{{ route('project.Projects') }}">لیست طرح ها</a>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-sm-3 col-md-3 col-lg-4 col-xl-4"></div>
                                    </div>
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
                            <p style="text-align:right;" id="ErrorMessage">
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('styles')
    <link href="{{ URL('Content/vendor/PersianDate/css/persian-datepicker.min.css') }}" rel="stylesheet" />
    <title>سامانه مدیریت تحقیقات - ایجاد طرح</title>
@endsection
@section('scripts')
    <script src="{{ URL('Content/vendor/PersianDate/js/persian-date.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/PersianDate/js/persian-datepicker.min.js') }}"></script>
    <script type="text/javascript">
        var ValiditiyMessage = "";
        $(function() {
            $('#ScholarId').selectize({
                sortField: 'value'
            });
            $('#UnitId').selectize({
                sortField: 'value'
            });
            $('#GroupId').selectize({
                sortField: 'value'
            });
            var isvalidSupervisorTel = true;
            $("#Subject").focus();
            $("#TenPercentLetterDate").persianDatepicker({
                altField: '#TenPercentLetterDate',
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
            $("#ThirtyPercentLetterDate").persianDatepicker({
                altField: '#ThirtyPercentLetterDate',
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
            $("#SixtyPercentLetterDate").persianDatepicker({
                altField: '#SixtyPercentLetterDate',
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
            $("#PreImploymentLetterDate").persianDatepicker({
                altField: '#PreImploymentLetterDate',
                altFormat: 'YYYY/MM/DD',
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
            $("#ImploymentDate").persianDatepicker({
                altField: '#ImploymentDate',
                altFormat: 'YYYY/MM/DD',
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
            $("#SecurityLetterDate").persianDatepicker({
                altField: '#SecurityLetterDate',
                altFormat: 'YYYY/MM/DD',
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
            $("#ThesisDefenceDate").persianDatepicker({
                altField: '#ThesisDefenceDate',
                altFormat: 'YYYY/MM/DD',
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
            $("#ThesisDefenceLetterDate").persianDatepicker({
                altField: '#ThesisDefenceLetterDate',
                altFormat: 'YYYY/MM/DD',
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
            $("#ATFLetterDate").persianDatepicker({
                altField: '#ATFLetterDate',
                altFormat: 'YYYY/MM/DD',
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
            $("#TenPercentLetterDate").on('change', function() {
                if (!
                    /^[1-4]\d{3,4}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/
                    .test($("#TenPercentLetterDate").val())) {
                    $("#TenPercentLetterDate").val('');
                }
            });
            $("#ThirtyPercentLetterDate").on('change', function() {
                if (!
                    /^[1-4]\d{3,4}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/
                    .test($("#ThirtyPercentLetterDate").val())) {
                    $("#ThirtyPercentLetterDate").val('');
                }
            });
            $("#SixtyPercentLetterDate").on('change', function() {
                if (!
                    /^[1-4]\d{3,4}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/
                    .test($("#SixtyPercentLetterDate").val())) {
                    $("#SixtyPercentLetterDate").val('');
                }
            });
            $("#PreImploymentLetterDate").on('change', function() {
                if (!
                    /^[1-4]\d{3,4}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/
                    .test($("#PreImploymentLetterDate").val())) {
                    $("#PreImploymentLetterDate").val('');
                }
            });
            $("#ImploymentDate").on('change', function() {
                if (!
                    /^[1-4]\d{3,4}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/
                    .test($("#ImploymentDate").val())) {
                    $("#ImploymentDate").val('');
                }
            });
            $("#SecurityLetterDate").on('change', function() {
                if (!
                    /^[1-4]\d{3,4}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/
                    .test($("#SecurityLetterDate").val())) {
                    $("#SecurityLetterDate").val('');
                }
            });
            $("#ThesisDefenceDate").on('change', function() {
                if (!
                    /^[1-4]\d{3,4}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/
                    .test($("#ThesisDefenceDate").val())) {
                    $("#ThesisDefenceDate").val('');
                }
            });
            $("#ThesisDefenceLetterDate").on('change', function() {
                if (!
                    /^[1-4]\d{3,4}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/
                    .test($("#ThesisDefenceLetterDate").val())) {
                    $("#ThesisDefenceLetterDate").val('');
                }
            });
            $("#ATFLetterDate").on('change', function() {
                if (!
                    /^[1-4]\d{3,4}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/
                    .test($("#ATFLetterDate").val())) {
                    $("#ATFLetterDate").val('');
                }
            });
            $("#SupervisorMobile").change(function() {
                if ($("#SupervisorMobile").val() == '') {
                    $("#SupervisorMobileError").attr('hidden', 'hidden');
                } else {
                    if (!isValidMobile($("#SupervisorMobile").val())) {
                        $("#SupervisorMobileError").text('شماره همراه وارد شده صحیح نمی باشد');
                        $("#SupervisorMobileError").removeAttr('hidden');
                        isvalidSupervisorTel = false;
                    } else {
                        isvalidSupervisorTel = true;
                        $("#SupervisorMobileError").attr('hidden', 'hidden');
                    }
                }
            });
            $("#AdvisorMobile").change(function() {
                if ($("#AdvisorMobile").val() == '') {
                    $("#AdvisorMobileError").attr('hidden', 'hidden');
                } else {
                    if (!isValidMobile($("#AdvisorMobile").val())) {
                        $("#AdvisorMobileError").text('شماره همراه وارد شده صحیح نمی باشد');
                        $("#AdvisorMobileError").removeAttr('hidden');
                        isvalidSupervisorTel = false;
                    } else {
                        isvalidSupervisorTel = true;
                        $("#AdvisorMobileError").attr('hidden', 'hidden');
                    }
                }
            });
            $("#btnSubmit").click(function(e) {
                e.preventDefault();
                if (CheckInputValidity()) {
                    $.ajax({
                        url: '{{URL::to('/')}}' + '/submitaddproject',
                        type: 'post',
                        datatype: 'json',
                        data: $("#AddProjectForm").serialize(),
                        success: function(result) {
                            if (!result.HasValue) {
                                $("#ErrorMessage").text(result.Message)
                                $("#errorAlert").removeAttr('hidden')
                                window.setTimeout(function() {
                                    $("#errorAlert").attr('hidden', 'hidden');
                                }, 5000);
                            } else {
                                $("#SuccessMessage").text("طرح با موفقیت ایجاد گردید")
                                $("#successAlert").removeAttr('hidden')
                                window.setTimeout(function() {
                                    window.location.href = '{{URL::to('/')}}' + '/projects';
                                }, 3000);
                            }
                        },
                        error: function(response) {
                            var message = "<ul>";
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

        function isValidMobile(input) {
            return /((\+|00)98|0)9\d{9}/.test(input);
        }

        function CheckInputValidity() {
            var isValid = true;
            if (!$("#Subject").val()) {
                ValiditiyMessage += '<li>';
                ValiditiyMessage += "عنوان طرح وارد نشده است";
                ValiditiyMessage += '</li>';
                isValid = false;
            }
            if ($("#ScholarId").val() == "0" || !$("#ScholarId").val()) {
                ValiditiyMessage += '<li>';
                ValiditiyMessage += "محقق انتخاب نشده است";
                ValiditiyMessage += '</li>';
                isValid = false;
            }
            if ($("#UnitId").val() == "0" || !$("#UnitId").val()) {
                ValiditiyMessage += '<li>';
                ValiditiyMessage += "یگان انتخاب نشده است";
                ValiditiyMessage += '</li>';
                isValid = false;
            }
            if ($("#GroupId").val() == "0" || !$("#GroupId").val()) {
                ValiditiyMessage += '<li>';
                ValiditiyMessage += "گروه تخصصی انتخاب نشده است";
                ValiditiyMessage += '</li>';
                isValid = false;
            }
            ValiditiyMessage = "<ul>" + ValiditiyMessage + "</ul>";
            return isValid;
        }
    </script>
@endsection

@endsection
