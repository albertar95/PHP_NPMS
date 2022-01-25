@extends('Layouts.app')

@section('Content')

<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-12">
                <div style="direction: ltr;">
                @if(in_array('2',$sharedData['UserAccessedEntities']))
                    @if(explode(',',$sharedData['UserAccessedSub']->where('entity','=',2)->pluck('rowValue')[0])[4] == 1)
                    <a id="btnReturn" class="btn btn-outline-info btn-block" style="margin:1rem;width:25%;" href="{{ route('project.Projects') }}">&larr; بازگشت</a>
                    @endif
                @endif
            </div>
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">اطلاعات طرح</h1>
                    </div>
                    <form class="user" id="EditProjectForm">
                        @csrf
                        <input id="CreateDate" name="CreateDate" value="{{ $Project->CreateDate }}" hidden/>
                        <input id="NidProject" name="NidProject" value="{{ $Project->NidProject }}" hidden />
                        <input id="PersianCreateDate" name="PersianCreateDate" value="{{ $Project->PersianCreateDate }}" hidden />
                        <input id="ProjectNumber" name="ProjectNumber" value="{{ $Project->ProjectNumber }}" hidden />
                        <input id="ProjectStatus" name="ProjectStatus" value="{{ $Project->ProjectStatus }}" hidden />
                        <input id="UserId" name="UserId" value="{{ $Project->UserId }}" hidden />
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user" id="Subject" name="Subject" value="{{ $Project->Subject }}"
                                       placeholder="عنوان طرح" />
                            </div>
                            <div class="col-sm-6">
                                <select class="form-control allWidth" data-ng-style="btn-primary" name="ScholarId" id="ScholarId" style="padding:0 .75rem;">
                                    <option value="0" disabled>انتخاب محقق</option>
                                    @foreach ($Scholars->sortBy('LastName') as $sch)
                                    {
                                        @if ($sch->NidScholar == $Project->ScholarId)
                                            <option value="{{ $sch->NidScholar }}" selected>{{ $sch->FirstName }} {{ $sch->LastName }}</option>
                                        @else
                                            <option value="{{ $sch->NidScholar }}">{{ $sch->FirstName }} {{ $sch->LastName }}</option>
                                        @endforelse
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <select class="form-control allWidth" data-ng-style="btn-primary" name="UnitId" id="UnitId" style="padding:0 .75rem;">
                                    <option value="0" disabled>انتخاب یگان</option>
                                    @foreach ($Units->sortBy('Title') as $uni)
                                        @if ($uni->NidUnit == $Project->UnitId)
                                            <option value="{{ $uni->NidUnit }}" selected>{{ $uni->Title }}</option>
                                        @else
                                            <option value="{{ $uni->NidUnit }}">{{ $uni->Title }}</option>
                                        @endforelse
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <select class="form-control allWidth" data-ng-style="btn-primary" name="GroupId" id="GroupId" style="padding:0 .75rem;">
                                    <option value="0" disabled>انتخاب گروه</option>
                                    @foreach ($UnitGroups->sortBy('Title') as $ung)
                                    @if ($ung->NidGroup == $Project->GroupId)
                                        <option value="{{ $ung->NidGroup }}" selected>{{ $ung->Title }}</option>
                                    @else
                                        <option value="{{ $ung->NidGroup }}">{{ $uni->Title }}</option>
                                    @endforelse
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0" style="display:flex;padding-right:10%;">
                                @if (!is_null($Project->TitleApproved) && $Project->TitleApproved == true)
                                    <input type="checkbox" style="width:1rem;margin:unset !important;" id="TitleApproved" name="TitleApproved" class="form-control" value="true" checked onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                    <label for="TitleApproved" style="margin:.25rem .25rem 0 0">عنوان طرح تایید شده است؟</label>
                                @elseif(!is_null($Project->TitleApproved) && $Project->TitleApproved == false)
                                    <input type="checkbox" style="width:1rem;margin:unset !important;" id="TitleApproved" name="TitleApproved" value="false" class="form-control" onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                    <label for="TitleApproved" style="margin:.25rem .25rem 0 0">عنوان طرح تایید شده است؟</label>
                                @else
                                    <input type="checkbox" style="width:1rem;margin:unset !important;" id="TitleApproved" name="TitleApproved" class="form-control" onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                    <label for="TitleApproved" style="margin:.25rem .25rem 0 0">عنوان طرح تایید شده است؟</label>
                                @endforelse
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control form-control-user" id="ATFLetterDate" name="ATFLetterDate" value="{{ $Project->ATFLetterDate }}"
                                       placeholder="تاریخ ارسال نامه به عتف">
                            </div>
                        </div>
                        <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                            <!-- Card Header - Accordion -->
                            <a href="#collapseExtraItems" class="d-block card-header py-3" data-toggle="collapse"
                               role="button" aria-expanded="true" aria-controls="collapseExtraItems">
                                <h6 class="m-0 font-weight-bold text-primary">اطلاعات تکمیلی</h6>
                            </a>
                            <!-- Card Content - Collapse -->
                            <div class="collapse show" id="collapseExtraItems">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="Supervisor" name="Supervisor" value="{{ $Project->Supervisor }}"
                                                   placeholder="استاد راهنما">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-user" id="SupervisorMobile" name="SupervisorMobile" value="{{ $Project->SupervisorMobile }}"
                                                   placeholder="شماره تماس استاد راهنما">
                                            <p id="SupervisorMobileError" style="font-size:.75rem;text-align:center;color:tomato;" hidden></p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="Advisor" name="Advisor" value="{{ $Project->Advisor }}"
                                                   placeholder="استاد مشاور">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-user" id="AdvisorMobile" name="AdvisorMobile" value="{{ $Project->AdvisorMobile }}"
                                                   placeholder="شماره تماس استاد مشاور">
                                            <p id="AdvisorMobileError" style="font-size:.75rem;text-align:center;color:tomato;" hidden></p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="Referee1" name="Referee1" value="{{ $Project->Referee1 }}"
                                                   placeholder="داور اول">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-user" id="Referee2" name="Referee2" value="{{ $Project->Referee2 }}"
                                                   placeholder="داور دوم">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="PreImploymentLetterDate" name="PreImploymentLetterDate" value="{{ $Project->PreImploymentLetterDate }}"
                                                   placeholder="تاریخ روگرفت">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-user" id="ImploymentDate" name="ImploymentDate" value="{{ $Project->ImploymentDate }}"
                                                   placeholder="تاریخ شروع بکار">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="Editor" name="Editor" value="{{ $Project->Editor }}"
                                                   placeholder="ویراستار">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-user" id="TenPercentLetterDate" name="TenPercentLetterDate" value="{{ $Project->TenPercentLetterDate }}"
                                                   placeholder="تاریخ نامه 10 درصد">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="ThirtyPercentLetterDate" name="ThirtyPercentLetterDate" value="{{ $Project->ThirtyPercentLetterDate }}"
                                                   placeholder="تاریخ تحویل فرم 30 درصد">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-user" id="SixtyPercentLetterDate" name="SixtyPercentLetterDate" value="{{ $Project->SixtyPercentLetterDate }}"
                                                   placeholder="تاریخ تحویل فرم 60 درصد">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="SecurityLetterDate" name="SecurityLetterDate" value="{{ $Project->SecurityLetterDate }}"
                                                   placeholder="تاریخ نامه حفاظت">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-user" id="ThesisDefenceDate" name="ThesisDefenceDate" value="{{ $Project->ThesisDefenceDate }}"
                                                   placeholder="تاریخ دفاعیه">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="ThesisDefenceLetterDate" name="ThesisDefenceLetterDate" value="{{ $Project->ThesisDefenceLetterDate }}"
                                                   placeholder="تاریخ ارسال نامه دفاعیه">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="number" class="form-control form-control-user" id="ReducePeriod" name="ReducePeriod" value="{{ $Project->ReducePeriod }}"
                                                   placeholder="مدت کسری">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <textarea class="form-control" id="Commision" name="Commision"
                                                      placeholder="کمیسیون" rows="5">{{ $Project->Commision }}</textarea>
                                        </div>
                                        <div class="col-sm-6" style="display:flex;padding-right:10%;">
                                        @if (!is_null($Project->HasBookPublish) && $Project->HasBookPublish == true)
                                        <input type="checkbox" style="width:1rem;margin:unset !important;margin-right:10%;" id="HasBookPublish" name="HasBookPublish" class="form-control" value="true" checked onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                        <label for="HasBookPublish" style="margin:.25rem .25rem 0 0">چاپ کتاب دارد؟</label>
                                        @elseif(!is_null($Project->HasBookPublish) && $Project->HasBookPublish == false)
                                        <input type="checkbox" style="width:1rem;margin:unset !important;margin-right:10%;" id="HasBookPublish" name="HasBookPublish" value="false" class="form-control" onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                        <label for="HasBookPublish" style="margin:.25rem .25rem 0 0">چاپ کتاب دارد؟</label>
                                        @else
                                        <input type="checkbox" style="width:1rem;margin:unset !important;margin-right:10%;" id="HasBookPublish" name="HasBookPublish" class="form-control" onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                        <label for="HasBookPublish" style="margin:.25rem .25rem 0 0">چاپ کتاب دارد؟</label>
                                        @endforelse
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0" style="display:flex;padding-right:10%;">
                                            @if (!is_null($Project->FinalApprove) && $Project->FinalApprove == true)
                                            <input type="checkbox" style="width:1rem;margin:unset !important;" id="FinalApprove" name="FinalApprove" class="form-control" value="true" checked onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                            <label for="FinalApprove" style="margin:.25rem .25rem 0 0">تایید نهایی طرح</label>
                                            @elseif(!is_null($Project->FinalApprove) && $Project->FinalApprove == false)
                                            <input type="checkbox" style="width:1rem;margin:unset !important;" id="FinalApprove" name="FinalApprove" value="false" class="form-control" onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                            <label for="FinalApprove" style="margin:.25rem .25rem 0 0">تایید نهایی طرح</label>
                                            @else
                                            <input type="checkbox" style="width:1rem;margin:unset !important;" id="FinalApprove" name="FinalApprove" class="form-control" onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                            <label for="FinalApprove" style="margin:.25rem .25rem 0 0">تایید نهایی طرح</label>
                                            @endforelse
                                            </div>
                                            <div class="col-sm-6" style="display:flex;padding-right:10%;">
                                                @if (!is_null($Project->IsConfident) && $Project->IsConfident == true)
                                                <input type="checkbox" style="width:1rem;margin:unset !important;" id="IsConfident" name="IsConfident" class="form-control" value="true" checked onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                <label for="IsConfident" style="margin:.25rem .25rem 0 0">آیا اطلاعات محرمانه است ؟</label>
                                                @elseif(!is_null($Project->IsConfident) && $Project->IsConfident == false)
                                                <input type="checkbox" style="width:1rem;margin:unset !important;" id="IsConfident" name="IsConfident" value="false" class="form-control" onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                <label for="IsConfident" style="margin:.25rem .25rem 0 0">آیا اطلاعات محرمانه است ؟</label>
                                                @else
                                                <input type="checkbox" style="width:1rem;margin:unset !important;" id="IsConfident" name="IsConfident" class="form-control" onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                <label for="IsConfident" style="margin:.25rem .25rem 0 0">آیا اطلاعات محرمانه است ؟</label>
                                                @endforelse
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0" style="display:flex;padding-right:10%;">
                                                @if (!is_null($Project->IsDisabled) && $Project->IsDisabled == true)
                                                <input type="checkbox" style="width:1rem;margin:unset !important;" id="IsDisabled" name="IsDisabled" class="form-control" value="true" checked onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                <label for="IsDisabled" style="margin:.25rem .25rem 0 0">طرح غیر فعال شود؟</label>
                                                @elseif(!is_null($Project->IsDisabled) && $Project->IsDisabled == false)
                                                <input type="checkbox" style="width:1rem;margin:unset !important;" id="IsDisabled" name="IsDisabled" value="false" class="form-control" onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                <label for="IsDisabled" style="margin:.25rem .25rem 0 0">طرح غیر فعال شود؟</label>
                                                @else
                                                <input type="checkbox" style="width:1rem;margin:unset !important;" id="IsDisabled" name="IsDisabled" class="form-control" onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                <label for="IsDisabled" style="margin:.25rem .25rem 0 0">طرح غیر فعال شود؟</label>
                                                @endforelse
                                                </div>
                                                <div class="col-sm-6" style="display:flex;padding-right:10%;">
                                                </div>
                                            </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="btnSubmit" class="btn btn-outline-warning btn-user btn-block" style="width:25%;margin:auto;">
                            ویرایش اطلاعات
                        </button>
                        <hr>
                    </form>
                    <hr />
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
    <link href="{{ URL('Content/vendor/PersianDate/css/persian-datepicker.min.css') }}" rel="stylesheet" />
@endsection
@section ('scripts')
    <script src="{{ URL('Content/vendor/PersianDate/js/persian-date.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/PersianDate/js/persian-datepicker.min.js') }}"></script>
    <script type="text/javascript">
    var ValiditiyMessage = "";
            $(function () {
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
                        enabled:true
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
                $("#TenPercentLetterDate").on('change', function () {
                    if (!/^[1-4]\d{3}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/.test($("#TenPercentLetterDate").val())) {
                        $("#TenPercentLetterDate").val('');
                    }
                });
                $("#ThirtyPercentLetterDate").on('change', function () {
                    if (!/^[1-4]\d{3}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/.test($("#ThirtyPercentLetterDate").val())) {
                        $("#ThirtyPercentLetterDate").val('');
                    }
                });
                $("#SixtyPercentLetterDate").on('change', function () {
                    if (!/^[1-4]\d{3}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/.test($("#SixtyPercentLetterDate").val())) {
                        $("#SixtyPercentLetterDate").val('');
                    }
                });
                $("#PreImploymentLetterDate").on('change', function () {
                    if (!/^[1-4]\d{3}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/.test($("#PreImploymentLetterDate").val())) {
                        $("#PreImploymentLetterDate").val('');
                    }
                });
                $("#ImploymentDate").on('change', function () {
                    if (!/^[1-4]\d{3}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/.test($("#ImploymentDate").val())) {
                        $("#ImploymentDate").val('');
                    }
                });
                $("#SecurityLetterDate").on('change', function () {
                    if (!/^[1-4]\d{3}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/.test($("#SecurityLetterDate").val())) {
                        $("#SecurityLetterDate").val('');
                    }
                });
                $("#ThesisDefenceDate").on('change', function () {
                    if (!/^[1-4]\d{3}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/.test($("#ThesisDefenceDate").val())) {
                        $("#ThesisDefenceDate").val('');
                    }
                });
                $("#ThesisDefenceLetterDate").on('change', function () {
                    if (!/^[1-4]\d{3}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/.test($("#ThesisDefenceLetterDate").val())) {
                        $("#ThesisDefenceLetterDate").val('');
                    }
                });
                $("#ATFLetterDate").on('change', function () {
                    if (!/^[1-4]\d{3}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/.test($("#ATFLetterDate").val())) {
                        $("#ATFLetterDate").val('');
                    }
                });
                $("#SupervisorMobile").change(function () {
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
                $("#AdvisorMobile").change(function () {
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
                $("#btnSubmit").click(function (e) {
                    e.preventDefault();
                    if(CheckInputValidity())
                    {
                        $.ajax(
                        {
                            url: '/updateproject',
                            type: 'post',
                            datatype: 'json',
                            data: $("#EditProjectForm").serialize(),
                            success: function (result) {
                                if (!result.HasValue) {
                                    $("#ErrorMessage").text(result.Message)
                                    $("#errorAlert").removeAttr('hidden')
                                    window.setTimeout(function () { $("#errorAlert").attr('hidden', 'hidden'); }, 5000);
                                } else
                                {
                                    $("#SuccessMessage").text("طرح با موفقیت ویرایش گردید")
                                    $("#successAlert").removeAttr('hidden')
                                    window.setTimeout(function () {window.location.href = '/projects' }, 1200);
                                }
                            },
                            error: function () {
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
        function isValidMobile(input) {
            return /((\+|00)98|0)9\d{9}/.test(input);
        }
        function CheckInputValidity()
        {
            var isValid = true;
            if(!$("#Subject").val())
            {
                ValiditiyMessage += '<li>';
                ValiditiyMessage += "عنوان طرح وارد نشده است";
                ValiditiyMessage += '</li>';
                isValid = false;
            }
            ValiditiyMessage = "<ul>" + ValiditiyMessage + "</ul>";
            return isValid;
        }
    </script>
@endsection


@endsection
