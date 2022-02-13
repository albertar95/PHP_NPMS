@if ($Scholars->count() > 0)
    <div class="table-responsive" dir="ltr">
        <table class="table table-bordered" border="1" id="ScholarDataTable"
            style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
            <thead>
                <tr>
                    @if ($OutputKey->contains('FirstName') || $OutputKey->contains('LastName'))

                        <th>نام محقق</th>
                    @endif
                    @if ($OutputKey->contains('NationalCode'))
                        <th>کد ملی</th>
                    @endif
                    @if ($OutputKey->contains('GradeId'))
                        <th>مقطع تحصیلی</th>
                    @endif
                    @if ($OutputKey->contains('MajorId'))
                        <th>رشته</th>
                    @endif
                    @if ($OutputKey->contains('OreintationId'))
                        <th>گرایش</th>
                    @endif
                    @if ($OutputKey->contains('college'))
                        <th>محل تحصیل</th>
                    @endif
                    @if ($OutputKey->contains('BirthDate'))
                        <th>تاریخ تولد</th>
                    @endif
                    @if ($OutputKey->contains('CollaborationType'))
                        <th>نوع همکاری</th>
                    @endif
                    @if ($OutputKey->contains('FatherName'))
                        <th>نام پدر</th>
                    @endif
                    @if ($OutputKey->contains('MillitaryStatus'))
                        <th>وضعیت خدمتی</th>
                    @endif
                    @if ($OutputKey->contains('Mobile'))
                        <th>شماره همراه</th>
                    @endif
                    @if ($OutputKey->contains('ProjectCount'))
                        <th>پروژه ها</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($Scholars as $sch)
                    <tr>
                        @if ($OutputKey->contains('FirstName') || $OutputKey->contains('LastName'))

                            @if ($OutputKey->contains('FirstName') && $OutputKey->contains('LastName'))

                                <td>{{ $sch->FirstName ?? '' }} {{ $sch->LastName ?? '' }}</td>
                            @elseif ($OutputKey->contains('FirstName'))

                                <td>{{ $sch->FirstName ?? '' }}</td>
                            @else

                                <td>{{ $sch->LastName ?? '' }}</td>
                            @endforelse
                        @endif
                        @if ($OutputKey->contains('NationalCode'))
                            <td>{{ $sch->NationalCode ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('GradeId'))
                            <td>{{ $sch->GradeTitle ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('MajorId'))
                            <td>{{ $sch->Major->Title }}</td>
                        @endif
                        @if ($OutputKey->contains('OreintationId'))
                            <td>{{ $sch->Oreintation->Title }}</td>
                        @endif
                        @if ($OutputKey->contains('college'))
                            <td>{{ $sch->CollegeTitle ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('BirthDate'))
                            <td>{{ $sch->BirthDate ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('CollaborationType'))
                            <td>{{ $sch->CollaborationTypeTitle ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('FatherName'))
                            <td>{{ $sch->FatherName ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('MillitaryStatus'))
                            <td>{{ $sch->MillitaryStatusTitle ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('Mobile'))
                            <td>{{ $sch->Mobile ?? '' }}</td>
                        @endif
                        {{-- @if ($OutputKey->contains('ProjectCount'))

                            <td>
                                @foreach ($Projects as $prj)

                                    <p>{{ $sch->Subject }}</p>
                                @endforeach
                            </td>
                        @endif --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@if ($Projects->count() > 0)
    <div class="table-responsive" dir="ltr">
        <table class="table table-bordered" border="1" id="ProjectDataTable"
            style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
            <thead>
                <tr>
                    @if ($OutputKey->contains('ProjectNumber'))

                        <th>شماره پرونده</th>
                    @endif
                    @if ($OutputKey->contains('Subject'))
                        <th>عنوان</th>
                    @endif
                    @if ($OutputKey->contains('ScholarTitle'))
                        <th>نام محقق</th>
                    @endif
                    @if ($OutputKey->contains('UnitTitle'))
                        <th>یگان تخصصی</th>
                    @endif
                    @if ($OutputKey->contains('GroupTitle'))
                        <th>گروه تخصصی</th>
                    @endif
                    @if ($OutputKey->contains('PersianCreateDate'))
                        <th>تاریخ ایجاد</th>
                    @endif
                    @if ($OutputKey->contains('Supervisor'))
                        <th>استاد راهنما</th>
                    @endif
                    @if ($OutputKey->contains('Advisor'))
                        <th>استاد مشاور</th>
                    @endif
                    @if ($OutputKey->contains('Referee'))
                        <th>داوران</th>
                    @endif
                    @if ($OutputKey->contains('ProjectStatus'))
                        <th>وضعیت طرح</th>
                    @endif
                    @if ($OutputKey->contains('TenPercentLetterDate'))
                        <th>تاریخ نامه 10 درصد</th>
                    @endif
                    @if ($OutputKey->contains('PreImploymentLetterDate'))
                        <th>تاریخ نامه روگرفت</th>
                    @endif
                    @if ($OutputKey->contains('ImploymentDate'))
                        <th>تاریخ بکارگیری</th>
                    @endif
                    @if ($OutputKey->contains('SecurityLetterDate'))
                        <th>تاریخ نامه حفاظت</th>
                    @endif
                    @if ($OutputKey->contains('ThirtyPercentLetterDate'))
                        <th>تاریخ نامه 30 درصد</th>
                    @endif
                    @if ($OutputKey->contains('SixtyPercentLetterDate'))
                        <th>تاریخ نامه 60 درصد</th>
                    @endif
                    @if ($OutputKey->contains('ATFLetterDate'))
                        <th>تاریخ نامه عتف</th>
                    @endif
                    @if ($OutputKey->contains('ThesisDefenceDate'))
                        <th>تاریخ دفاعیه</th>
                    @endif
                    @if ($OutputKey->contains('ThesisDefenceLetterDate'))
                        <th>تاریخ نامه دفاعیه</th>
                    @endif
                    @if ($OutputKey->contains('ReducePeriod'))
                        <th>مدت کسری</th>
                    @endif
                    @if ($OutputKey->contains('SupervisorMobile'))
                        <th>شماره همراه راهنما</th>
                    @endif
                    @if ($OutputKey->contains('AdvisorMobile'))
                        <th>شماره همراه مشاور</th>
                    @endif
                    @if ($OutputKey->contains('Editor'))
                        <th>ویراستار</th>
                    @endif
                    @if ($OutputKey->contains('TitleApproved'))
                        <th>تایید عنوان</th>
                    @endif
                    @if ($OutputKey->contains('HasBookPublish'))
                        <th>چاپ کتاب</th>
                    @endif
                    @if ($OutputKey->contains('FinalApprove'))
                        <th>تایید نهایی</th>
                    @endif
                    @if ($OutputKey->contains('IsConfident'))
                        <th>محرمانه</th>
                    @endif
                    @if ($OutputKey->contains('UserTitle'))
                        <th>کاربر ایجاد کننده</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($Projects as $sch)
                    <tr>
                        @if ($OutputKey->contains('ProjectNumber'))

                            <td>{{ $sch->ProjectNumber ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('Subject'))
                            <td>{{ $sch->Subject ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('ScholarTitle'))
                            <td>{{ $sch->ScholarTitle ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('UnitTitle'))
                            <td>{{ $sch->UnitTitle ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('GroupTitle'))
                            <td>{{ $sch->GroupTitle ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('PersianCreateDate'))
                            <td>{{ $sch->PersianCreateDate ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('Supervisor'))
                            <td>{{ $sch->Supervisor ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('Advisor'))
                            <td>{{ $sch->Advisor ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('Referee'))
                            <td>{{ $sch->Referee1 ?? '' }} | {{ $sch->Referee2 ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('ProjectStatus'))
                            <td>{{ $sch->ProjectStatus ?? '' }} %</td>
                        @endif
                        @if ($OutputKey->contains('TenPercentLetterDate'))
                            <td>{{ $sch->TenPercentLetterDate ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('PreImploymentLetterDate'))
                            <td>{{ $sch->PreImploymentLetterDate ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('ImploymentDate'))
                            <td>{{ $sch->ImploymentDate ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('SecurityLetterDate'))
                            <td>{{ $sch->SecurityLetterDate ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('ThirtyPercentLetterDate'))
                            <td>{{ $sch->ThirtyPercentLetterDate ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('SixtyPercentLetterDate'))
                            <td>{{ $sch->SixtyPercentLetterDate ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('ATFLetterDate'))
                            <td>{{ $sch->ATFLetterDate ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('ThesisDefenceDate'))
                            <td>{{ $sch->ThesisDefenceDate ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('ThesisDefenceLetterDate'))
                            <td>{{ $sch->ThesisDefenceLetterDate ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('ReducePeriod'))
                            <td>{{ $sch->ReducePeriod ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('SupervisorMobile'))
                            <td>{{ $sch->SupervisorMobile ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('AdvisorMobile'))
                            <td>{{ $sch->AdvisorMobile ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('Editor'))
                            <td>{{ $sch->Editor ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('TitleApproved'))
                            @if ($sch->TitleApproved)
                                <td>دارد</td>
                            @else
                                <td>ندارد</td>
                            @endforelse
                        @endif
                        @if ($OutputKey->contains('HasBookPublish'))
                            @if ($sch->HasBookPublish)
                                <td>دارد</td>
                            @else
                                <td>ندارد</td>
                            @endforelse
                        @endif
                        @if ($OutputKey->contains('FinalApprove'))
                            @if ($sch->FinalApprove)
                                <td>دارد</td>
                            @else
                                <td>ندارد</td>
                            @endforelse
                        @endif
                        @if ($OutputKey->contains('IsConfident'))
                            @if ($sch->IsConfident)
                                <td>دارد</td>
                            @else
                                <td>ندارد</td>
                            @endforelse
                        @endif
                        @if ($OutputKey->contains('UserTitle'))
                            <td>{{ $sch->UserTitle ?? '' }}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@if ($Users->count() > 0)
    <div class="table-responsive" dir="ltr">
        <table class="table table-bordered" border="1" id="UserDataTable"
            style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
            <thead>
                <tr>
                    @if ($OutputKey->contains('ProfilePicture'))

                        <th>نمایه</th>
                    @endif
                    @if ($OutputKey->contains('Username'))
                        <th>نام کاربری</th>
                    @endif
                    @if ($OutputKey->contains('FirstName') || $OutputKey->contains('LastName'))
                        <th>نام کاربر</th>
                    @endif
                    @if ($OutputKey->contains('RoleTitle'))
                        <th>نقش</th>
                    @endif
                    @if ($OutputKey->contains('IsLockedOut'))
                        <th>قفل شدن</th>
                    @endif
                    @if ($OutputKey->contains('IsDisabled'))
                        <th>غیرفعال شدن</th>
                    @endif
                    @if ($OutputKey->contains('LastLoginDate'))
                        <th>آخرین ورود</th>
                    @endif
                    @if ($OutputKey->contains('IncorrectPasswordCount'))
                        <th>تعداد کلمه عبور اشتباه</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($Users as $usr)
                    <tr>
                        @if ($OutputKey->contains('ProfilePicture'))
                            <td>
                                @if (!empty($usr->ProfilePicture))
                                    <img src="/storage/images/{{ $usr->ProfilePicture }}" height="50" width="50" />
                                @else
                                    <img height="50" width="50" src="{{ URL('Content/img/User/user3.png') }}">
                                @endforelse
                            </td>
                        @endif
                        @if ($OutputKey->contains('Username'))
                            <td>{{ $usr->Username ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('FirstName') || $OutputKey->contains('LastName'))
                            @if ($OutputKey->contains('FirstName') && $OutputKey->contains('LastName'))

                                <td>{{ $usr->FirstName ?? '' }} {{ $usr->LastName ?? '' }}</td>
                            @elseif ($OutputKey->contains('FirstName'))

                                <td>{{ $usr->FirstName ?? '' }}</td>
                            @else

                                <td>{{ $usr->LastName ?? '' }}</td>
                            @endforelse
                        @endif
                        @if ($OutputKey->contains('RoleTitle'))
                            <td>{{ $usr->RoleTitle ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('IsLockedOut'))
                            @if ($usr->IsLockedOut)
                                <td>بلی</td>
                            @else
                                <td>خیر</td>
                            @endforelse
                        @endif
                        @if ($OutputKey->contains('IsDisabled'))
                            @if ($usr->IsDisabled)
                                <td>بلی</td>
                            @else
                                <td>خیر</td>
                            @endforelse
                        @endif
                        @if ($OutputKey->contains('LastLoginDate'))
                            <td>{{ $usr->LastLoginDate ?? '' }}</td>
                        @endif
                        @if ($OutputKey->contains('IncorrectPasswordCount'))
                            <td>{{ $usr->IncorrectPasswordCount ?? '' }}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
<div class="form-group row">
    <button class="btn btn-danger btn-icon-split" style="margin:5px;"
        onclick="ExportResult(1, 1, '{{ $ReportName }}')">
        <span class="icon text-white-50">
            <i class="fas fa-file-pdf"></i>
        </span>
        <span class="text">
            خروجی
            pdf
        </span>
    </button>
    <button class="btn btn-success btn-icon-split" style="margin:5px;"
        onclick="ExportResult(1,2,'{{ $ReportName }}')">
        <span class="icon text-white-50">
            <i class="fas fa-file-excel"></i>
        </span>
        <span class="text">
            خروجی
            excel
        </span>
    </button>
    <button class="btn btn-primary btn-icon-split" style="margin:5px;"
        onclick="ExportResult(1,3,'{{ $ReportName }}')">
        <span class="icon text-white-50">
            <i class="fas fa-print"></i>
        </span>
        <span class="text">
            پرینت
        </span>
    </button>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#ScholarDataTable').DataTable();
        $('#ProjectDataTable').DataTable();
        $('#UserDataTable').DataTable();
    });
</script>
