@extends('Layouts.app')

@section('Content')
<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">جزییات طرح</h1>
                    </div>
                    <form class="user" id="ProjectDetailForm">
                        <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                            <!-- Card Header - Accordion -->
                            <a href="#collapseScholarItems" class="d-block card-header py-3" data-toggle="collapse"
                               role="button" aria-expanded="true" aria-controls="collapseScholarItems">
                                <h6 class="m-0 font-weight-bold text-primary">اطلاعات محقق</h6>
                            </a>
                            <!-- Card Content - Collapse -->
                            <div class="collapse show" id="collapseScholarItems" style="padding:.75rem;">
                                <div class="form-group row" style="text-align:right;">
                                    <div class="col-sm-2" style="padding:.5rem;">
                                        <label>نام : </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-control">{{ $Scholar->FirstName }}</label>
                                    </div>
                                    <div class="col-sm-2" style="padding:.5rem;">
                                        <label>نام خانوادگی : </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-control">{{ $Scholar->LastName }}</label>
                                    </div>
                                </div>
                                <div class="form-group row" style="text-align:right;">
                                    <div class="col-sm-2" style="padding:.5rem;">
                                        <label>نام پدر : </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-control">{{ $Scholar->FatherName }}</label>
                                    </div>
                                    <div class="col-sm-2" style="padding:.5rem;">
                                        <label>تاریخ تولد : </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-control">{{ $Scholar->BirthDate }}</label>
                                    </div>
                                </div>
                                <div class="form-group row" style="text-align:right;">
                                    <div class="col-sm-2" style="padding:.5rem;">
                                        <label>کد ملی : </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-control">{{ $Scholar->NationalCode }}</label>
                                    </div>
                                    <div class="col-sm-2" style="padding:.5rem;">
                                        <label>شماره همراه : </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-control">{{ $Scholar->Mobile }}</label>
                                    </div>
                                </div>
                                <div class="form-group row" style="text-align:right;">
                                    <div class="col-sm-2" style="padding:.5rem;">
                                        <label>مقطع تحصیلی : </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-control">{{ $Scholar->GradeTitle }}</label>
                                    </div>
                                    <div class="col-sm-2" style="padding:.5rem;">
                                        <label>وضعیت خدمتی : </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-control">{{ $Scholar->MillitaryStatusTitle }}</label>
                                    </div>
                                </div>
                                <div class="form-group row" style="text-align:right;">
                                    <div class="col-sm-2" style="padding:.5rem;">
                                        <label>رشته تحصیلی : </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-control">{{ $Scholar->Major->Title }}</label>
                                    </div>
                                    <div class="col-sm-2" style="padding:.5rem;">
                                        <label>گرایش : </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-control">{{ $Scholar->Oreintation->Title }}</label>
                                    </div>
                                </div>
                                <div class="form-group row" style="text-align:right;">
                                    <div class="col-sm-2" style="padding:.5rem;">
                                        <label>محل تحصیل : </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-control">{{ $Scholar->CollegeTitle }}</label>
                                    </div>
                                    <div class="col-sm-2" style="padding:.5rem;">
                                        <label>نوع همکاری : </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-control">{{ $Scholar->CollaborationTypeTitle }}</label>
                                    </div>
                                </div>
                                <div class="form-group row" style="text-align:right;">
                                    <div class="col-sm-2" style="padding:.5rem;">
                                        <label>تعداد طرح ها : </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-control">{{ $Scholar->Projects->count() }}</label>
                                    </div>
                                    <div class="col-sm-2" style="padding:.5rem;">
                                        <label>طرح ها : </label>
                                    </div>
                                    <div class="col-sm-4" style="display:table-column">
                                        @foreach ($Scholar->Projects as $proj)
                                            <label class="form-control">{{ $proj->Subject }}</label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                            <!-- Card Header - Accordion -->
                            <a href="#collapsePrimaryItems" class="d-block card-header py-3" data-toggle="collapse"
                               role="button" aria-expanded="true" aria-controls="collapsePrimaryItems">
                                <h6 class="m-0 font-weight-bold text-primary">اطلاعات طرح</h6>
                            </a>
                            <!-- Card Content - Collapse -->
                            <div class="collapse show" style="padding:.75rem;" id="collapsePrimaryItems">
                                <div class="form-group row" style="text-align:right;">
                                    <div class="col-sm-2" style="padding:.5rem;">
                                        <label>موضوع طرح : </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-control">{{ $Project->Subject }}</label>
                                    </div>
                                    <div class="col-sm-2" style="padding:.5rem;">
                                        <label>مشخصات محقق : </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-control">{{ $Scholar->FirstName }} {{ $Scholar->LastName }}</label>
                                    </div>
                                </div>
                                <div class="form-group row" style="text-align:right;">
                                    <div class="col-sm-2" style="padding:.5rem;">
                                        <label>یگان تخصصی : </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-control">{{ $Project->UnitTitle }}</label>
                                    </div>
                                    <div class="col-sm-2" style="padding:.5rem;">
                                        <label>گروه تخصصی : </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-control">{{ $Project->GroupTitle }}</label>
                                    </div>
                                </div>
                                <div class="form-group row" style="text-align:right;">
                                    <div class="col-sm-2" style="padding:.5rem;">
                                        <label>استاد راهنما : </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-control">{{ $Project->Supervisor }}</label>
                                    </div>
                                    <div class="col-sm-2" style="padding:.5rem;">
                                        <label>شماره تماس استاد راهنما : </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-control">{{ $Project->SupervisorMobile }}</label>
                                    </div>
                                </div>
                                <div class="form-group row" style="text-align:right;">
                                    <div class="col-sm-2" style="padding:.5rem;">
                                        <label>استاد مشاور : </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-control">{{ $Project->Advisor }}</label>
                                    </div>
                                    <div class="col-sm-2" style="padding:.5rem;">
                                        <label>شماره تماس استاد مشاور : </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-control">{{ $Project->AdvisorMobile }}</label>
                                    </div>
                                </div>
                                <div class="form-group row" style="text-align:right;">
                                    <div class="col-sm-2" style="padding:.5rem;">
                                        <label>تاریخ نامه عتف : </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-control">{{ $Project->ATFLetterDate }}</label>
                                    </div>
                                    <div class="col-sm-2" style="padding:.5rem;">
                                    </div>
                                    <div class="col-sm-4">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                            <!-- Card Header - Accordion -->
                            <a href="#collapseExtraItems" class="d-block card-header py-3" data-toggle="collapse"
                               role="button" aria-expanded="true" aria-controls="collapseExtraItems">
                                <h6 class="m-0 font-weight-bold text-primary">اطلاعات تکمیلی طرح</h6>
                            </a>
                            <!-- Card Content - Collapse -->
                            <div class="collapse show" style="padding:.75rem;" id="collapseExtraItems">
                                <div class="card-body">
                                    <div class="form-group row" style="text-align:right;">
                                        <div class="col-sm-2" style="padding:.5rem;">
                                            <label>داور 1 : </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-control">{{ $Project->Referee1 }}</label>
                                        </div>
                                        <div class="col-sm-2" style="padding:.5rem;">
                                            <label>داور 2 : </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-control">{{ $Project->Referee2 }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group row" style="text-align:right;">
                                        <div class="col-sm-2" style="padding:.5rem;">
                                            <label>ویراستار : </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-control">{{ $Project->Editor }}</label>
                                        </div>
                                        <div class="col-sm-2" style="padding:.5rem;">
                                            <label>تاریخ نامه 10 درصد : </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-control">{{ $Project->TenPercentLetterDate }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group row" style="text-align:right;">
                                        <div class="col-sm-2" style="padding:.5rem;">
                                            <label>تاریخ تحویل فرم 30 درصد : </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-control">{{ $Project->SixtyPercentLetterDate }}</label>
                                        </div>
                                        <div class="col-sm-2" style="padding:.5rem;">
                                            <label>تاریخ تحویل فرم 60 درصد : </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-control">{{ $Project->TenPercentLetterDate }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group row" style="text-align:right;">
                                        <div class="col-sm-2" style="padding:.5rem;">
                                            <label>تاریخ روگرفت : </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-control">{{ $Project->PreImploymentLetterDate }}</label>
                                        </div>
                                        <div class="col-sm-2" style="padding:.5rem;">
                                            <label>تاریخ بکارگیری : </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-control">{{ $Project->ImploymentDate }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group row" style="text-align:right;">
                                        <div class="col-sm-2" style="padding:.5rem;">
                                            <label>تاریخ نامه حفاظت : </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-control">{{ $Project->SecurityLetterDate }}</label>
                                        </div>
                                        <div class="col-sm-2" style="padding:.5rem;">
                                            <label>تاریخ دفاع : </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-control">{{ $Project->ThesisDefenceDate }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group row" style="text-align:right;">
                                        <div class="col-sm-2" style="padding:.5rem;">
                                            <label>تاریخ ارسال نامه دفاعیه : </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-control">{{ $Project->ThesisDefenceLetterDate }}</label>
                                        </div>
                                        <div class="col-sm-2" style="padding:.5rem;">
                                            <label>مدت کسری : </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-control">{{ $Project->ReducePeriod }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <textarea class="form-control" id="Commision" name="Commision"
                                                      placeholder="کمیسیون" rows="5" readonly>
                                                      {{ $Project->Commision }}
                                                </textarea>
                                            </div>
                                            <div class="col-sm-6" style="display:flex;padding-right:10%;">
                                                @if (!is_null($Project->HasBookPublish) &&  $Project->HasBookPublish == true)
                                                    <label for="HasBookPublish" style="margin:.25rem .25rem 0 0">چاپ کتاب دارد</label>
                                                @elseif (!is_null($Project->HasBookPublish) && $Project->HasBookPublish == false)
                                                    <label for="HasBookPublish" style="margin:.25rem .25rem 0 0">چاپ کتاب ندارد</label>
                                                @else
                                                    <label for="HasBookPublish" style="margin:.25rem .25rem 0 0">چاپ کتاب ندارد</label>
                                                @endforelse
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <hr>
                        <a href="{{ route('project.Projects') }}" id="btnSubmit" class="btn btn-outline-secondary btn-user btn-block" style="width:25%;margin:auto;">
                            بازگشت به لیست طرح ها
                        </a>
                        </form>
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

@endsection
