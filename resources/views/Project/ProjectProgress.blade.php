@extends('Layouts.app')

@section('Content')

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="row" style="direction: ltr;margin: 10px;">
                        @if (in_array('2', $sharedData['UserAccessedEntities']))
                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 2)->pluck('rowValue')[0])[4] == 1)
                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">
                                    <a id="btnReturn" class="btn btn-outline-info btn-block"
                                        href="{{ route('project.Projects') }}">&larr; بازگشت</a>
                                </div>
                            @endif
                        @endif
                    </div>
                    <div style="direction: ltr;">
                    </div>
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">ویرایش طرح</h1>
                        </div>
                        @if (in_array('2', $sharedData['UserAccessedEntities']))
                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 2)->pluck('rowValue')[0])[1] == 1)
                                <form class="user" id="EditProjectForm">
                                    @csrf
                                    <input id="CreateDate" name="CreateDate" value="{{ $Project->CreateDate }}" hidden />
                                    <input id="NidProject" name="NidProject" value="{{ $Project->NidProject }}" hidden />
                                    <input id="PersianCreateDate" name="PersianCreateDate"
                                        value="{{ $Project->PersianCreateDate }}" hidden />
                                    {{-- <input id="ProjectNumber" name="ProjectNumber" value="{{ $Project->ProjectNumber }}"
                                        hidden /> --}}
                                    <input id="ProjectStatus" name="ProjectStatus" value="{{ $Project->ProjectStatus }}"
                                        hidden />
                                    <input id="UserId" name="UserId" value="{{ $Project->UserId }}" hidden />
                                    <input id="txtScholar" value="{{ $Project->ScholarId }}" hidden />
                                    <input id="txtUnit" value="{{ $Project->UnitId }}" hidden />
                                    <input id="txtGroup" value="{{ $Project->GroupId }}" hidden />
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="ProjectNumber"
                                                name="ProjectNumber" placeholder="شماره پرونده"
                                                value="{{ $Project->ProjectNumber }}">
                                        </div>
                                        <div class="col-sm-6">
                                            <select class="form-control allWidth" data-ng-style="btn-primary"
                                                name="ScholarId" id="ScholarId" style="padding:0 .75rem;"
                                                placeholder="انتخاب محقق">
                                                <option value="0" disabled>انتخاب محقق</option>
                                                @foreach ($Scholars->sortBy('LastName') as $sch)
                                                    @if ($sch->NidScholar == $Project->ScholarId)
                                                        <option value="{{ $sch->NidScholar }}" selected
                                                            data-tokens="{{ $sch->FirstName }} {{ $sch->LastName }}">
                                                            {{ $sch->FirstName }}
                                                            {{ $sch->LastName }}</option>
                                                    @else
                                                        <option value="{{ $sch->NidScholar }}"
                                                            data-tokens="{{ $sch->FirstName }} {{ $sch->LastName }}">
                                                            {{ $sch->FirstName }}
                                                            {{ $sch->LastName }}</option>
                                                    @endforelse
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <textarea rows="5" class="form-control form-control-user" id="Subject" name="Subject"
                                                placeholder="عنوان طرح">{{ $Project->Subject }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <select class="form-control allWidth" data-ng-style="btn-primary" name="UnitId"
                                                id="UnitId" style="padding:0 .75rem;" placeholder="انتخاب یگان">
                                                <option value="0" disabled>انتخاب یگان کاربر</option>
                                                @foreach ($Units->sortBy('Title') as $uni)
                                                    @if ($uni->NidUnit == $Project->UnitId)
                                                        <option value="{{ $uni->NidUnit }}" selected
                                                            data-tokens="{{ $uni->Title }}">{{ $uni->Title }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $uni->NidUnit }}"
                                                            data-tokens="{{ $uni->Title }}">{{ $uni->Title }}</option>
                                                    @endforelse
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <select class="form-control allWidth" data-ng-style="btn-primary" name="GroupId"
                                                id="GroupId" style="padding:0 .75rem;" placeholder="انتخاب گروه">
                                                <option value="0" disabled>انتخاب گروه</option>
                                                @foreach ($UnitGroups->sortBy('Title') as $ung)
                                                    @if ($ung->NidGroup == $Project->GroupId)
                                                        <option value="{{ $ung->NidGroup }}" selected
                                                            data-tokens="{{ $ung->Title }}">
                                                            {{ $ung->Title }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $ung->NidGroup }}"
                                                            data-tokens="{{ $ung->Title }}">{{ $uni->Title }}
                                                        </option>
                                                    @endforelse
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="ATFLetterDate"
                                                name="ATFLetterDate" value="{{ $Project->ATFLetterDate }}"
                                                placeholder="تاریخ ارسال نامه به عتف">
                                        </div>
                                        <div class="col-sm-6" style="display:flex;padding-right:10%;">
                                            @if (!is_null($Project->TitleApproved) && $Project->TitleApproved == true)
                                                <input type="checkbox" style="width:1rem;margin:unset !important;"
                                                    id="TitleApproved" name="TitleApproved" class="form-control"
                                                    value="true" checked
                                                    onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                <label for="TitleApproved" style="margin:.25rem .25rem 0 0">عنوان طرح تایید
                                                    شده
                                                    است؟</label>
                                            @elseif(!is_null($Project->TitleApproved) && $Project->TitleApproved == false)
                                                <input type="checkbox" style="width:1rem;margin:unset !important;"
                                                    id="TitleApproved" name="TitleApproved" value="false"
                                                    class="form-control"
                                                    onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                <label for="TitleApproved" style="margin:.25rem .25rem 0 0">عنوان طرح تایید
                                                    شده
                                                    است؟</label>
                                            @else
                                                <input type="checkbox" style="width:1rem;margin:unset !important;"
                                                    id="TitleApproved" name="TitleApproved" class="form-control"
                                                    onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                <label for="TitleApproved" style="margin:.25rem .25rem 0 0">عنوان طرح تایید
                                                    شده
                                                    است؟</label>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                                        <!-- Card Header - Accordion -->
                                        <a href="#collapseExtraItems" class="d-block card-header py-3"
                                            data-toggle="collapse" role="button" aria-expanded="true"
                                            aria-controls="collapseExtraItems">
                                            <h6 class="m-0 font-weight-bold text-primary">اطلاعات تکمیلی</h6>
                                        </a>
                                        <!-- Card Content - Collapse -->
                                        <div class="collapse show" id="collapseExtraItems">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="Supervisor" name="Supervisor"
                                                            value="{{ $Project->Supervisor }}"
                                                            placeholder="استاد راهنما">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="SupervisorMobile" name="SupervisorMobile"
                                                            value="{{ $Project->SupervisorMobile }}"
                                                            placeholder="شماره تماس استاد راهنما">
                                                        <p id="SupervisorMobileError"
                                                            style="font-size:.75rem;text-align:center;color:tomato;" hidden>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="Advisor" name="Advisor" value="{{ $Project->Advisor }}"
                                                            placeholder="استاد مشاور">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="AdvisorMobile" name="AdvisorMobile"
                                                            value="{{ $Project->AdvisorMobile }}"
                                                            placeholder="شماره تماس استاد مشاور">
                                                        <p id="AdvisorMobileError"
                                                            style="font-size:.75rem;text-align:center;color:tomato;" hidden>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="Referee1" name="Referee1"
                                                            value="{{ $Project->Referee1 }}" placeholder="داور اول">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="Referee2" name="Referee2"
                                                            value="{{ $Project->Referee2 }}" placeholder="داور دوم">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="PreImploymentLetterDate" name="PreImploymentLetterDate"
                                                            value="{{ $Project->PreImploymentLetterDate }}"
                                                            placeholder="تاریخ روگرفت">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="ImploymentDate" name="ImploymentDate"
                                                            value="{{ $Project->ImploymentDate }}"
                                                            placeholder="تاریخ شروع بکار">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="Editor" name="Editor" value="{{ $Project->Editor }}"
                                                            placeholder="ویراستار">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="TenPercentLetterDate" name="TenPercentLetterDate"
                                                            value="{{ $Project->TenPercentLetterDate }}"
                                                            placeholder="تاریخ نامه 10 درصد">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="ThirtyPercentLetterDate" name="ThirtyPercentLetterDate"
                                                            value="{{ $Project->ThirtyPercentLetterDate }}"
                                                            placeholder="تاریخ تحویل فرم 30 درصد">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="SixtyPercentLetterDate" name="SixtyPercentLetterDate"
                                                            value="{{ $Project->SixtyPercentLetterDate }}"
                                                            placeholder="تاریخ تحویل فرم 60 درصد">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        {{-- <input type="text" class="form-control form-control-user"
                                                            id="SecurityLetterDate" name="SecurityLetterDate"
                                                            value="{{ $Project->SecurityLetterDate }}"
                                                            placeholder="تاریخ نامه حفاظت"> --}}
                                                        <input type="text" class="form-control form-control-user"
                                                            id="ThesisDefenceDate" name="ThesisDefenceDate"
                                                            value="{{ $Project->ThesisDefenceDate }}"
                                                            placeholder="تاریخ دفاعیه">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="ThesisDefenceLetterDate" name="ThesisDefenceLetterDate"
                                                            value="{{ $Project->ThesisDefenceLetterDate }}"
                                                            placeholder="تاریخ ارسال نامه دفاعیه">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <input type="text" class="form-control form-control-user"
                                                            style="margin-bottom: 5px;"
                                                            value="{{ (int) ($Project->ReducePeriod / 30) }}"
                                                            id="ReducePeriodMonth" name="ReducePeriodMonth"
                                                            placeholder="مدت کسری (ماه)">
                                                        <input type="text" class="form-control form-control-user"
                                                            value="{{ (int) ($Project->ReducePeriod % 30) }}"
                                                            id="ReducePeriodDay" name="ReducePeriodDay"
                                                            placeholder="مدت کسری (روز)">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <textarea class="form-control" id="Commision" name="Commision" placeholder="کمیسیون"
                                                            rows="5">{{ $Project->Commision }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0"
                                                        style="display:flex;padding-right:10%;">
                                                        @if (!is_null($Project->HasBookPublish) && $Project->HasBookPublish == true)
                                                            <input type="checkbox"
                                                                style="width:1rem;margin:unset !important;margin-right:10%;"
                                                                id="HasBookPublish" name="HasBookPublish"
                                                                class="form-control" value="true" checked
                                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                            <label for="HasBookPublish" style="margin:.25rem .25rem 0 0">چاپ
                                                                کتاب
                                                                دارد؟</label>
                                                        @elseif(!is_null($Project->HasBookPublish) && $Project->HasBookPublish == false)
                                                            <input type="checkbox"
                                                                style="width:1rem;margin:unset !important;margin-right:10%;"
                                                                id="HasBookPublish" name="HasBookPublish" value="false"
                                                                class="form-control"
                                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                            <label for="HasBookPublish" style="margin:.25rem .25rem 0 0">چاپ
                                                                کتاب
                                                                دارد؟</label>
                                                        @else
                                                            <input type="checkbox"
                                                                style="width:1rem;margin:unset !important;margin-right:10%;"
                                                                id="HasBookPublish" name="HasBookPublish"
                                                                class="form-control"
                                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                            <label for="HasBookPublish" style="margin:.25rem .25rem 0 0">چاپ
                                                                کتاب
                                                                دارد؟</label>
                                                        @endforelse
                                                    </div>
                                                    <div class="col-sm-6" style="display:flex;padding-right:10%;">
                                                        @if (!is_null($Project->IsConfident) && $Project->IsConfident == true)
                                                            <input type="checkbox"
                                                                style="width:1rem;margin:unset !important;" id="IsConfident"
                                                                name="IsConfident" class="form-control" value="true"
                                                                checked
                                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                            <label for="IsConfident" style="margin:.25rem .25rem 0 0">آیا
                                                                اطلاعات
                                                                محرمانه است ؟</label>
                                                        @elseif(!is_null($Project->IsConfident) && $Project->IsConfident == false)
                                                            <input type="checkbox"
                                                                style="width:1rem;margin:unset !important;" id="IsConfident"
                                                                name="IsConfident" value="false" class="form-control"
                                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                            <label for="IsConfident" style="margin:.25rem .25rem 0 0">آیا
                                                                اطلاعات
                                                                محرمانه است ؟</label>
                                                        @else
                                                            <input type="checkbox"
                                                                style="width:1rem;margin:unset !important;" id="IsConfident"
                                                                name="IsConfident" class="form-control"
                                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                            <label for="IsConfident" style="margin:.25rem .25rem 0 0">آیا
                                                                اطلاعات
                                                                محرمانه است ؟</label>
                                                        @endforelse
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
                                                            style="width:75%;margin:0 auto;">فایل های ضمیمه
                                                        </label>
                                                        <p id="FileUploadMessage" style="text-align:center;color:tomato;"
                                                            hidden></p>
                                                    </div>
                                                    <div class="col-sm-6" style="display:flex;padding-right:10%;"
                                                        id="uploadedFileDemo">
                                                        @foreach ($datafiles as $file)
                                                            {{-- <a href="{{ URL($file->FilePath) }}" target="_blank"
                                                                style="margin: 5px;">{{ $file->FileName }}</a> --}}
                                                            <div class="image-area">
                                                                <a class="remove-image removeFile" href="#"
                                                                    onclick="btnRemoveFile(event);"
                                                                    id="{{ $file->NidFile }}"
                                                                    style="display: inline;">&#215;</a>
                                                                <a href="{{ URL($file->FilePath) }}" target="_blank"
                                                                    style="padding: 25px;">{{ $file->FileName }}</a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0"
                                                        style="display:flex;padding-right:10%;">
                                                        @if (!is_null($Project->FinalApprove) && $Project->FinalApprove == true)
                                                            <input type="checkbox"
                                                                style="width:1rem;margin:unset !important;"
                                                                id="FinalApprove" name="FinalApprove" class="form-control"
                                                                value="true" checked
                                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                            <label for="FinalApprove" style="margin:.25rem .25rem 0 0">تایید
                                                                نهایی
                                                                طرح</label>
                                                        @elseif(!is_null($Project->FinalApprove) && $Project->FinalApprove == false)
                                                            <input type="checkbox"
                                                                style="width:1rem;margin:unset !important;"
                                                                id="FinalApprove" name="FinalApprove" value="false"
                                                                class="form-control"
                                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                            <label for="FinalApprove" style="margin:.25rem .25rem 0 0">تایید
                                                                نهایی
                                                                طرح</label>
                                                        @else
                                                            <input type="checkbox"
                                                                style="width:1rem;margin:unset !important;"
                                                                id="FinalApprove" name="FinalApprove" class="form-control"
                                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                            <label for="FinalApprove" style="margin:.25rem .25rem 0 0">تایید
                                                                نهایی
                                                                طرح</label>
                                                        @endforelse
                                                    </div>
                                                    <div class="col-sm-6" style="display:flex;padding-right:10%;">
                                                        @if (!is_null($Project->IsDisabled) && $Project->IsDisabled == true)
                                                            <input type="checkbox"
                                                                style="width:1rem;margin:unset !important;" id="IsDisabled"
                                                                name="IsDisabled" class="form-control" value="true"
                                                                checked
                                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                            <label for="IsDisabled" style="margin:.25rem .25rem 0 0">طرح غیر
                                                                فعال
                                                                شود؟</label>
                                                        @elseif(!is_null($Project->IsDisabled) && $Project->IsDisabled == false)
                                                            <input type="checkbox"
                                                                style="width:1rem;margin:unset !important;" id="IsDisabled"
                                                                name="IsDisabled" value="false" class="form-control"
                                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                            <label for="IsDisabled" style="margin:.25rem .25rem 0 0">طرح غیر
                                                                فعال
                                                                شود؟</label>
                                                        @else
                                                            <input type="checkbox"
                                                                style="width:1rem;margin:unset !important;" id="IsDisabled"
                                                                name="IsDisabled" class="form-control"
                                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                                            <label for="IsDisabled" style="margin:.25rem .25rem 0 0">طرح غیر
                                                                فعال
                                                                شود؟</label>
                                                        @endforelse
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
                                            <button type="submit" id="btnSubmit"
                                                class="btn btn-warning btn-user btn-block">
                                                ویرایش اطلاعات
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
                                                        href="{{ route('project.Projects') }}">لیست طرح
                                                        ها</a>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-sm-3 col-md-3 col-lg-4 col-xl-4"></div>
                                    </div>
                                </form>
                            @endif
                        @endif
                        <hr />
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
    <link href="{{ URL('Content/vendor/PersianDate/css/persian-datepicker.min.css') }}" rel="stylesheet" />
    <title>سامانه مدیریت تحقیقات - ویرایش طرح</title>
@endsection
@section('scripts')
    <script src="{{ URL('Content/vendor/PersianDate/js/persian-date.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/PersianDate/js/persian-datepicker.min.js') }}"></script>
    <script type="text/javascript">
        var ValiditiyMessage = "";
        $(function() {
            $('#ScholarId').selectize()[0].selectize.setValue($("#txtScholar").val(), false);
            $('#UnitId').selectize()[0].selectize.setValue($("#txtUnit").val(), false);
            $('#GroupId').selectize()[0].selectize.setValue($("#txtGroup").val(), false);
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
                    /^[1۱][34۳۴][0123456789۰۱۲۳۴۵۶۷۸۹][0123456789۰۱۲۳۴۵۶۷۸۹]\/([0۰]?[123456789۱۲۳۴۵۶۷۸۹]|[1۱][012۰۱۲])\/([0۰]?[123456789۱۲۳۴۵۶۷۸۹]|[12۱۲][0123456789۰۱۲۳۴۵۶۷۸۹]|[3۳][01۰۱])$/
                    .test($("#TenPercentLetterDate").val())) {
                    $("#TenPercentLetterDate").val('');
                }
            });
            $("#ThirtyPercentLetterDate").on('change', function() {
                if (!
                    /^[1۱][34۳۴][0123456789۰۱۲۳۴۵۶۷۸۹][0123456789۰۱۲۳۴۵۶۷۸۹]\/([0۰]?[123456789۱۲۳۴۵۶۷۸۹]|[1۱][012۰۱۲])\/([0۰]?[123456789۱۲۳۴۵۶۷۸۹]|[12۱۲][0123456789۰۱۲۳۴۵۶۷۸۹]|[3۳][01۰۱])$/
                    .test($("#ThirtyPercentLetterDate").val())) {
                    $("#ThirtyPercentLetterDate").val('');
                }
            });
            $("#SixtyPercentLetterDate").on('change', function() {
                if (!
                    /^[1۱][34۳۴][0123456789۰۱۲۳۴۵۶۷۸۹][0123456789۰۱۲۳۴۵۶۷۸۹]\/([0۰]?[123456789۱۲۳۴۵۶۷۸۹]|[1۱][012۰۱۲])\/([0۰]?[123456789۱۲۳۴۵۶۷۸۹]|[12۱۲][0123456789۰۱۲۳۴۵۶۷۸۹]|[3۳][01۰۱])$/
                    .test($("#SixtyPercentLetterDate").val())) {
                    $("#SixtyPercentLetterDate").val('');
                }
            });
            $("#PreImploymentLetterDate").on('change', function() {
                if (!
                    /^[1۱][34۳۴][0123456789۰۱۲۳۴۵۶۷۸۹][0123456789۰۱۲۳۴۵۶۷۸۹]\/([0۰]?[123456789۱۲۳۴۵۶۷۸۹]|[1۱][012۰۱۲])\/([0۰]?[123456789۱۲۳۴۵۶۷۸۹]|[12۱۲][0123456789۰۱۲۳۴۵۶۷۸۹]|[3۳][01۰۱])$/
                    .test($("#PreImploymentLetterDate").val())) {
                    $("#PreImploymentLetterDate").val('');
                }
            });
            $("#ImploymentDate").on('change', function() {
                if (!
                    /^[1۱][34۳۴][0123456789۰۱۲۳۴۵۶۷۸۹][0123456789۰۱۲۳۴۵۶۷۸۹]\/([0۰]?[123456789۱۲۳۴۵۶۷۸۹]|[1۱][012۰۱۲])\/([0۰]?[123456789۱۲۳۴۵۶۷۸۹]|[12۱۲][0123456789۰۱۲۳۴۵۶۷۸۹]|[3۳][01۰۱])$/
                    .test($("#ImploymentDate").val())) {
                    $("#ImploymentDate").val('');
                }
            });
            $("#SecurityLetterDate").on('change', function() {
                if (!
                    /^[1۱][34۳۴][0123456789۰۱۲۳۴۵۶۷۸۹][0123456789۰۱۲۳۴۵۶۷۸۹]\/([0۰]?[123456789۱۲۳۴۵۶۷۸۹]|[1۱][012۰۱۲])\/([0۰]?[123456789۱۲۳۴۵۶۷۸۹]|[12۱۲][0123456789۰۱۲۳۴۵۶۷۸۹]|[3۳][01۰۱])$/
                    .test($("#SecurityLetterDate").val())) {
                    $("#SecurityLetterDate").val('');
                }
            });
            $("#ThesisDefenceDate").on('change', function() {
                if (!
                    /^[1۱][34۳۴][0123456789۰۱۲۳۴۵۶۷۸۹][0123456789۰۱۲۳۴۵۶۷۸۹]\/([0۰]?[123456789۱۲۳۴۵۶۷۸۹]|[1۱][012۰۱۲])\/([0۰]?[123456789۱۲۳۴۵۶۷۸۹]|[12۱۲][0123456789۰۱۲۳۴۵۶۷۸۹]|[3۳][01۰۱])$/
                    .test($("#ThesisDefenceDate").val())) {
                    $("#ThesisDefenceDate").val('');
                }
            });
            $("#ThesisDefenceLetterDate").on('change', function() {
                if (!
                    /^[1۱][34۳۴][0123456789۰۱۲۳۴۵۶۷۸۹][0123456789۰۱۲۳۴۵۶۷۸۹]\/([0۰]?[123456789۱۲۳۴۵۶۷۸۹]|[1۱][012۰۱۲])\/([0۰]?[123456789۱۲۳۴۵۶۷۸۹]|[12۱۲][0123456789۰۱۲۳۴۵۶۷۸۹]|[3۳][01۰۱])$/
                    .test($("#ThesisDefenceLetterDate").val())) {
                    $("#ThesisDefenceLetterDate").val('');
                }
            });
            $("#ATFLetterDate").on('change', function() {
                var id = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
                if (!
                    /^[1۱][34۳۴][0123456789۰۱۲۳۴۵۶۷۸۹][0123456789۰۱۲۳۴۵۶۷۸۹]\/([0۰]?[123456789۱۲۳۴۵۶۷۸۹]|[1۱][012۰۱۲])\/([0۰]?[123456789۱۲۳۴۵۶۷۸۹]|[12۱۲][0123456789۰۱۲۳۴۵۶۷۸۹]|[3۳][01۰۱])$/
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
                        url: '{{ URL::to('/') }}' + '/updateproject',
                        type: 'post',
                        datatype: 'json',
                        data: $("#EditProjectForm").serialize(),
                        success: function(result) {
                            if (!result.HasValue) {
                                $("#ErrorMessage").text(result.Message)
                                $("#errorAlert").removeAttr('hidden')
                                window.setTimeout(function() {
                                    $("#errorAlert").attr('hidden', 'hidden');
                                }, 5000);
                            } else {
                                $("#SuccessMessage").text("طرح با موفقیت ویرایش گردید")
                                $("#successAlert").removeAttr('hidden')
                                window.setTimeout(function() {
                                    window.location.href = '{{ URL::to('/') }}' +
                                        '/projects'
                                }, 1200);
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
            if (!$("#ProjectNumber").val()) {
                ValiditiyMessage += '<li>';
                ValiditiyMessage += "شماره پرونده وارد نشده است";
                ValiditiyMessage += '</li>';
                isValid = false;
            }
            if ($('#FinalApprove').is(":checked")) {
                if (!$("#Advisor").val() || !$("#Supervisor").val() || !$("#ImploymentDate").val() || !$(
                        "#TenPercentLetterDate").val() || !$("#ThirtyPercentLetterDate").val() || !$(
                        "#SixtyPercentLetterDate").val() || !$("#ThesisDefenceDate").val() || !$("#Editor").val() || !$(
                        "#Commision").val() || !$('#TitleApproved').is(":checked") || !$('#HasBookPublish').is(
                    ":checked")) {
                    ValiditiyMessage += '<li>';
                    ValiditiyMessage += "اطلاعات طرح کامل نمی باشد بنابراین امکان تایید نهایی وجود ندارد";
                    ValiditiyMessage += '</li>';
                    isValid = false;
                }
            }
            ValiditiyMessage = "<ul>" + ValiditiyMessage + "</ul>";
            return isValid;
        }
    </script>
@endsection


@endsection
