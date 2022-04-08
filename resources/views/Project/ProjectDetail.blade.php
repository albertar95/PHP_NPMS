@extends('Layouts.app')

@section('Content')
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row" id="ProjectDetailData">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">جزییات طرح</h1>
                        </div>
                        @if (in_array('2', $sharedData['UserAccessedEntities']))
                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 2)->pluck('rowValue')[0])[3] == 1)
                                <form class="user" id="ProjectDetailForm">
                                    <input type="text" id="txtNidProject" value="{{ $Project->NidProject }}" hidden />
                                    <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                                        <!-- Card Header - Accordion -->
                                        <a href="#collapseBriefItems" class="d-block card-header py-3" data-toggle="collapse"
                                            role="button" aria-expanded="true" aria-controls="collapseBriefItems">
                                            <h6 class="m-0 font-weight-bold text-primary">گزارش اجمالی طرح</h6>
                                        </a>
                                        <!-- Card Content - Collapse -->
                                        <div class="collapse show" id="collapseBriefItems" style="padding:.75rem;">
                                            <div class="form-group row" style="text-align:right;">
                                                <div class="col-lg-12">
                                                    <div class="row" style="margin: 2px;">
                                                        @if ($Scholar->IsSecurityApproved)
                                                            <div class="btn btn-success btn-circle">
                                                                <i class="fas fa-check"></i>
                                                            </div>
                                                            <h5>تاییدیه حفاظت</h5>
                                                        @else
                                                            <div class="btn btn-danger btn-circle">
                                                                <i class="fas fa-times"></i>
                                                            </div>
                                                            <h5>تاییدیه حفاظت</h5>
                                                        @endforelse
                                                    </div>
                                                    <div class="row" style="margin: 2px;">
                                                        @if ($Project->TitleApproved)
                                                            <div class="btn btn-success btn-circle">
                                                                <i class="fas fa-check"></i>
                                                            </div>
                                                            <h5>تاییدیه عنوان</h5>
                                                        @else
                                                            <div class="btn btn-danger btn-circle">
                                                                <i class="fas fa-times"></i>
                                                            </div>
                                                            <h5>تاییدیه عنوان</h5>
                                                        @endforelse
                                                    </div>
                                                    <div class="row" style="margin: 2px;">
                                                        @if (!empty($Project->PreImploymentLetterDate))
                                                            <div class="btn btn-success btn-circle">
                                                                <i class="fas fa-check"></i>
                                                            </div>
                                                            <h5>نامه روگرفت</h5>
                                                        @else
                                                            <div class="btn btn-danger btn-circle">
                                                                <i class="fas fa-times"></i>
                                                            </div>
                                                            <h5>نامه روگرفت</h5>
                                                        @endforelse
                                                    </div>
                                                    <div class="row" style="margin: 2px;">
                                                        @if (!empty($Project->ImploymentDate))
                                                            <div class="btn btn-success btn-circle">
                                                                <i class="fas fa-check"></i>
                                                            </div>
                                                            <h5>نامه بکارگیری</h5>
                                                        @else
                                                            <div class="btn btn-danger btn-circle">
                                                                <i class="fas fa-times"></i>
                                                            </div>
                                                            <h5>نامه بکارگیری</h5>
                                                        @endforelse
                                                    </div>
                                                    <div class="row" style="margin: 2px;">
                                                        @if (!empty($Project->TenPercentLetterDate))
                                                            <div class="btn btn-success btn-circle">
                                                                <i class="fas fa-check"></i>
                                                            </div>
                                                            <h5>دفاع 10 درصد</h5>
                                                        @else
                                                            <div class="btn btn-danger btn-circle">
                                                                <i class="fas fa-times"></i>
                                                            </div>
                                                            <h5>دفاع 10 درصد</h5>
                                                        @endforelse
                                                    </div>
                                                    <div class="row" style="margin: 2px;">
                                                        @if (!empty($Project->ThirtyPercentLetterDate))
                                                            <div class="btn btn-success btn-circle">
                                                                <i class="fas fa-check"></i>
                                                            </div>
                                                            <h5>دفاع 30 درصد</h5>
                                                        @else
                                                            <div class="btn btn-danger btn-circle">
                                                                <i class="fas fa-times"></i>
                                                            </div>
                                                            <h5>دفاع 30 درصد</h5>
                                                        @endforelse
                                                    </div>
                                                    <div class="row" style="margin: 2px;">
                                                        @if (!empty($Project->SixtyPercentLetterDate))
                                                            <div class="btn btn-success btn-circle">
                                                                <i class="fas fa-check"></i>
                                                            </div>
                                                            <h5>دفاع 60 درصد</h5>
                                                        @else
                                                            <div class="btn btn-danger btn-circle">
                                                                <i class="fas fa-times"></i>
                                                            </div>
                                                            <h5>دفاع 60 درصد</h5>
                                                        @endforelse
                                                    </div>
                                                    <div class="row" style="margin: 2px;">
                                                        @if (!empty($Project->ThesisDefenceLetterDate))
                                                            <div class="btn btn-success btn-circle">
                                                                <i class="fas fa-check"></i>
                                                            </div>
                                                            <h5>نامه دفاعیه</h5>
                                                        @else
                                                            <div class="btn btn-danger btn-circle">
                                                                <i class="fas fa-times"></i>
                                                            </div>
                                                            <h5>نامه دفاعیه</h5>
                                                        @endforelse
                                                    </div>
                                                    <div class="row" style="margin: 2px;">
                                                        @if (!empty($Project->Commision))
                                                            <div class="btn btn-success btn-circle">
                                                                <i class="fas fa-check"></i>
                                                            </div>
                                                            <h5>کمیسیون</h5>
                                                        @else
                                                            <div class="btn btn-danger btn-circle">
                                                                <i class="fas fa-times"></i>
                                                            </div>
                                                            <h5>کمیسیون</h5>
                                                        @endforelse
                                                    </div>
                                                    <div class="row" style="margin: 2px;">
                                                        @if ($Project->HasBookPublish)
                                                            <div class="btn btn-success btn-circle">
                                                                <i class="fas fa-check"></i>
                                                            </div>
                                                            <h5>چاپ کتاب</h5>
                                                        @else
                                                            <div class="btn btn-danger btn-circle">
                                                                <i class="fas fa-times"></i>
                                                            </div>
                                                            <h5>چاپ کتاب</h5>
                                                        @endforelse
                                                    </div>
                                                    <div class="row" style="margin: 2px;">
                                                        @if ($Project->FinalApprove)
                                                            <div class="btn btn-success btn-circle">
                                                                <i class="fas fa-check"></i>
                                                            </div>
                                                            <h5>تایید نهایی</h5>
                                                        @else
                                                            <div class="btn btn-danger btn-circle">
                                                                <i class="fas fa-times"></i>
                                                            </div>
                                                            <h5>تایید نهایی</h5>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                                        <!-- Card Header - Accordion -->
                                        <a href="#collapseScholarItems" class="d-block card-header py-3"
                                            data-toggle="collapse" role="button" aria-expanded="true"
                                            aria-controls="collapseScholarItems">
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
                                                    <label>تاییدیه حفاظت : </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    @if ($Scholar->IsSecurityApproved)
                                                        <label class="form-control">دارد</label>
                                                    @else
                                                        <label class="form-control">ندارد</label>
                                                    @endforelse
                                                </div>
                                                <div class="col-sm-2" style="padding:.5rem;">
                                                    <label>تاریخ نامه حفاظت : </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label
                                                        class="form-control">{{ $Scholar->SecurityApproveDate }}</label>
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
                                                    <label
                                                        class="form-control">{{ $Scholar->MillitaryStatusTitle }}</label>
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
                                                    <label
                                                        class="form-control">{{ $Scholar->Oreintation->Title }}</label>
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
                                                    <label
                                                        class="form-control">{{ $Scholar->CollaborationTypeTitle }}</label>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="text-align:right;">
                                                <div class="col-sm-2" style="padding:.5rem;">
                                                    <label>تعداد طرح ها : </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label
                                                        class="form-control">{{ $Scholar->Projects->count() }}</label>
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
                                        <a href="#collapsePrimaryItems" class="d-block card-header py-3"
                                            data-toggle="collapse" role="button" aria-expanded="true"
                                            aria-controls="collapsePrimaryItems">
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
                                                    <label class="form-control">{{ $Scholar->FirstName }}
                                                        {{ $Scholar->LastName }}</label>
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
                                                    <label
                                                        class="form-control">{{ $Project->SupervisorMobile }}</label>
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
                                        <a href="#collapseExtraItems" class="d-block card-header py-3"
                                            data-toggle="collapse" role="button" aria-expanded="true"
                                            aria-controls="collapseExtraItems">
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
                                                        <label
                                                            class="form-control">{{ $Project->TenPercentLetterDate }}</label>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="text-align:right;">
                                                    <div class="col-sm-2" style="padding:.5rem;">
                                                        <label>تاریخ تحویل فرم 30 درصد : </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label
                                                            class="form-control">{{ $Project->ThirtyPercentLetterDate }}</label>
                                                    </div>
                                                    <div class="col-sm-2" style="padding:.5rem;">
                                                        <label>تاریخ تحویل فرم 60 درصد : </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label
                                                            class="form-control">{{ $Project->SixtyPercentLetterDate }}</label>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="text-align:right;">
                                                    <div class="col-sm-2" style="padding:.5rem;">
                                                        <label>تاریخ روگرفت : </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label
                                                            class="form-control">{{ $Project->PreImploymentLetterDate }}</label>
                                                    </div>
                                                    <div class="col-sm-2" style="padding:.5rem;">
                                                        <label>تاریخ بکارگیری : </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label
                                                            class="form-control">{{ $Project->ImploymentDate }}</label>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="text-align:right;">
                                                    {{-- <div class="col-sm-2" style="padding:.5rem;">
                                                        <label>تاریخ نامه حفاظت : </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label
                                                            class="form-control">{{ $Project->SecurityLetterDate }}</label>
                                                    </div> --}}
                                                    <div class="col-sm-2" style="padding:.5rem;">
                                                        <label>تاریخ دفاع : </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label
                                                            class="form-control">{{ $Project->ThesisDefenceDate }}</label>
                                                    </div>
                                                    <div class="col-sm-2" style="padding:.5rem;">
                                                        <label>تاریخ ارسال نامه دفاعیه : </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label
                                                            class="form-control">{{ $Project->ThesisDefenceLetterDate }}</label>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="text-align:right;">
                                                    <div class="col-sm-2" style="padding:.5rem;">
                                                        <label>مدت کسری : </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label
                                                            class="form-control">{{ $Project->ReducePeriod }}</label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <textarea class="form-control" id="Commision" name="Commision" placeholder="کمیسیون" rows="5"
                                                            readonly>{{ $Project->Commision }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-2" style="padding:.5rem;">
                                                        <label>وضعیت چاپ کتاب : </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        @if (!is_null($Project->HasBookPublish) && $Project->HasBookPublish == true)
                                                            <label for="HasBookPublish" class="form-control">دارد</label>
                                                        @elseif (!is_null($Project->HasBookPublish) && $Project->HasBookPublish == false)
                                                            <label for="HasBookPublish"
                                                                class="form-control">ندارد</label>
                                                        @else
                                                            <label for="HasBookPublish"
                                                                class="form-control">ندارد</label>
                                                        @endforelse
                                                    </div>
                                                    <div class="col-sm-2" style="padding:.5rem;">
                                                        <label>تایید نهایی : </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        @if (!is_null($Project->FinalApprove) && $Project->FinalApprove == true)
                                                            <label for="FinalApprove" class="form-control">دارد</label>
                                                        @elseif (!is_null($Project->FinalApprove) && $Project->FinalApprove == false)
                                                            <label for="FinalApprove" class="form-control">ندارد</label>
                                                        @else
                                                            <label for="FinalApprove" class="form-control">ندارد</label>
                                                        @endforelse
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-2" style="padding:.5rem;">
                                                        <label>وضعیت محرمانگی : </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        @if (!is_null($Project->IsConfident) && $Project->IsConfident == true)
                                                            <label for="IsConfident" class="form-control">دارد</label>
                                                        @elseif (!is_null($Project->IsConfident) && $Project->IsConfident == false)
                                                            <label for="IsConfident" class="form-control">ندارد</label>
                                                        @else
                                                            <label for="IsConfident" class="form-control">ندارد</label>
                                                        @endforelse
                                                    </div>
                                                    <div class="col-sm-2" style="padding:.5rem;">
                                                        <label>غیر فعال : </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        @if (!is_null($Project->IsDisabled) && $Project->IsDisabled == true)
                                                            <label for="IsDisabled" class="form-control">می باشد</label>
                                                        @elseif (!is_null($Project->IsDisabled) && $Project->IsDisabled == false)
                                                            <label for="IsDisabled" class="form-control">نمی باشد</label>
                                                        @else
                                                            <label for="IsDisabled" class="form-control">نمی باشد</label>
                                                        @endforelse
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-2" style="padding:.5rem;">
                                                        <label>فایل های ضمیمه : </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        @foreach ($datafiles as $file)
                                                            <a href="{{ URL($file->FilePath) }}" target="_blank"
                                                                style="margin: 5px;">{{ $file->FileName }}</a>
                                                        @endforeach
                                                    </div>
                                                    <div class="col-sm-2" style="padding:.5rem;">
                                                    </div>
                                                    <div class="col-sm-4">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-md-3 col-lg-4 col-xl-4"></div>
                                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                                            @if (in_array('2', $sharedData['UserAccessedEntities']))
                                                @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 2)->pluck('rowValue')[0])[5] == 1)
                                                    <button id="btnPrint"
                                                        class="btn btn-outline-primary btn-user btn-block">
                                                        پرینت
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-sm-3 col-md-3 col-lg-4 col-xl-4"></div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-md-3 col-lg-4 col-xl-4"></div>
                                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                                            @if (in_array('2', $sharedData['UserAccessedEntities']))
                                                @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 2)->pluck('rowValue')[0])[3] == 1)
                                                    <a href="{{ route('project.Projects') }}" id="btnSubmit"
                                                        class="btn btn-outline-secondary btn-user btn-block">
                                                        لیست طرح ها
                                                    </a>
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
                            <p style="text-align:right;" id="ErrorMessage"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('styles')
    <title>سامانه مدیریت تحقیقات - جزییات طرح</title>
    <style>
        label {
            overflow: hidden;
        }

        h5 {
            margin: 2px;
        }

    </style>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(function() {
            $("#btnPrint").click(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ URL::to('/') }}' + '/printprojectdetail/' + $("#txtNidProject")
                        .val(),
                    type: 'get',
                    datatype: 'json',
                    success: function(result) {
                        if (result.HasValue) {
                            newWin = window.open("");
                            newWin.document.write(result.Html);
                            newWin.print();
                            newWin.close();
                        } else {
                            var divToPrint = document.getElementById("ProjectDetailData");
                            newWin = window.open("");
                            newWin.document.write(divToPrint.outerHTML);
                            newWin.print();
                            newWin.close();
                        }
                    },
                    error: function() {
                        var divToPrint = document.getElementById("ProjectDetailData");
                        newWin = window.open("");
                        newWin.document.write(divToPrint.outerHTML);
                        newWin.print();
                        newWin.close();
                    }
                });
            });
        });
    </script>
@endsection
@endsection
