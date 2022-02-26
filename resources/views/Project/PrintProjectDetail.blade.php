<html>

<head>
    <style>
        body {
            font-family: 'fa', sans-serif !important;
        }

        tr:nth-child(even) {
            background-color: #e3e3e3;
        }

    </style>
</head>

<body>
    <div id="Reportheader" style="display: flex;margin-bottom: 5px;">
        <div style="border: grey 1px solid;width: 20%;text-align: right;padding: 3px;">
            {{ auth()->user()->UserName }} : کاربر <br />
            تاریخ گزارش : {{ $ReportDate }}<br />
            زمان گزارش : {{ $ReportTime }}<br />
            @if($ConfidentLevel == 0)
            طبقه بندی : عادی
            @else
            طبقه بندی : محرمانه
            @endforelse
        </div>
        <div style="text-align: center;margin: 0 auto;width: 60%;">
            <h1>جزییات طرح</h1>
        </div>
        <div style="width: 20%;"></div>
    </div>
    <div style="border: cornflowerblue 2px solid;margin-bottom: 25px;"></div>
    <table class="table table-bordered" border="1" id="ScholarDataTable"
        style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
        <thead>
            <tr style="background-color: #d2ebfa;">
                <th colspan="2">اطلاعات محقق</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">نام</td>
                <td>{{ $Scholar->FirstName }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">نام خانوادگی</td>
                <td>{{ $Scholar->LastName }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">نام پدر</td>
                <td>{{ $Scholar->FatherName }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">تاریخ تولد</td>
                <td>{{ $Scholar->BirthDate }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">کد ملی</td>
                <td>{{ $Scholar->NationalCode }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">شماره همراه</td>
                <td>{{ $Scholar->Mobile }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">مقطع تحصیلی</td>
                <td>{{ $Scholar->GradeTitle }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">وضعیت خدمتی</td>
                <td>{{ $Scholar->MillitaryStatusTitle }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">رشته تحصیلی</td>
                <td>{{ $Scholar->Major->Title }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">گرایش</td>
                <td>{{ $Scholar->Oreintation->Title }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">محل تحصیل</td>
                <td>{{ $Scholar->CollegeTitle }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">نوع همکاری</td>
                <td>{{ $Scholar->CollaborationTypeTitle }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">تعداد طرح ها</td>
                <td>{{ $Scholar->Projects->count() }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">طرح ها</td>
                <td>
                    @foreach ($Scholar->Projects as $proj)
                        <label class="form-control">{{ $proj->Subject }}</label>
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered" border="1" id="ProjectDataTable"
        style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
        <thead>
            <tr style="background-color: #d2ebfa;">
                <th colspan="2">اطلاعات طرح</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font: bolder;color: cornflowerblue;">موضوع طرح</td>
                <td>{{ $Project->Subject }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">مشخصات محقق</td>
                <td>{{ $Scholar->FirstName }}
                    {{ $Scholar->LastName }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">یگان تخصصی</td>
                <td>{{ $Project->UnitTitle }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">گروه تخصصی</td>
                <td>{{ $Project->GroupTitle }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">استاد راهنما</td>
                <td>{{ $Project->Supervisor }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">شماره تماس استاد راهنما</td>
                <td>{{ $Project->SupervisorMobile }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">استاد مشاور</td>
                <td>{{ $Project->Advisor }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">شماره تماس استاد مشاور</td>
                <td>{{ $Project->AdvisorMobile }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">تاریخ نامه عتف</td>
                <td>{{ $Project->ATFLetterDate }}</td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered" border="1" id="ScholarDataTable"
        style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
        <thead>
            <tr style="background-color: #d2ebfa;">
                <th colspan="2">اطلاعات تکمیلی طرح</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">داور 1</td>
                <td>{{ $Project->Referee1 }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">داور 2</td>
                <td>{{ $Project->Referee2 }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">ویراستار</td>
                <td>{{ $Project->Editor }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">تاریخ نامه 10 درصد</td>
                <td>{{ $Project->TenPercentLetterDate }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">تاریخ تحویل فرم 30 درصد</td>
                <td>{{ $Project->ThirtyPercentLetterDate }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">تاریخ تحویل فرم 60 درصد</td>
                <td>{{ $Project->SixtyPercentLetterDate }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">تاریخ روگرفت</td>
                <td>{{ $Project->PreImploymentLetterDate }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">تاریخ بکارگیری</td>
                <td>{{ $Project->ImploymentDate }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">تاریخ نامه حفاظت</td>
                <td>{{ $Project->SecurityLetterDate }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">تاریخ دفاع</td>
                <td>{{ $Project->ThesisDefenceDate }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">تاریخ ارسال نامه دفاعیه</td>
                <td>{{ $Project->ThesisDefenceLetterDate }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">مدت کسری</td>
                <td>{{ $Project->ReducePeriod }}</td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">چاپ کتاب</td>
                <td>
                    @if (!is_null($Project->HasBookPublish) && $Project->HasBookPublish == true)
                        <label for="HasBookPublish" class="form-control">دارد</label>
                    @elseif (!is_null($Project->HasBookPublish) && $Project->HasBookPublish == false)
                        <label for="HasBookPublish" class="form-control">ندارد</label>
                    @else
                        <label for="HasBookPublish" class="form-control">ندارد</label>
                    @endforelse
                </td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">کمیسیون</td>
                <td>
                    {{ $Project->Commision }}
                </td>
            </tr>
            <tr>
                <td style="font: bolder;color: cornflowerblue;width: 50%;">تایید نهایی</td>
                <td>
                    @if (!is_null($Project->FinalApprove) && $Project->FinalApprove == true)
                        <label for="FinalApprove" class="form-control">دارد</label>
                    @elseif (!is_null($Project->FinalApprove) && $Project->FinalApprove == false)
                        <label for="FinalApprove" class="form-control">ندارد</label>
                    @else
                        <label for="FinalApprove" class="form-control">ندارد</label>
                    @endforelse
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
