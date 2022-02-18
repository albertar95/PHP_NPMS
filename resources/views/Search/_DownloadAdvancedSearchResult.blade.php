<html>

<head>
    <style>
        body {
            font-family: 'fa', sans-serif !important;
            text-align: right;
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
            زمان گزارش : {{ $ReportTime }}
        </div>
        <div style="text-align: center;margin: 0 auto;width: 60%;">
            <h1>نتیجه جستجو</h1>
        </div>
        <div style="width: 20%;"></div>
    </div>
    <div style="border: cornflowerblue 2px solid;margin-bottom: 25px;"></div>
    <h3>طرح ها</h3>
    @if ($Projects->count() > 0)
        <div class="table-responsive" dir="ltr">
            <table class="table table-bordered" id="dataTable" style="width:100%;direction:rtl;text-align:center;"
                cellspacing="0">
                <thead>
                    <tr style="background-color: #d2ebfa;">
                        <th>شماره پرونده</th>
                        <th>نام محقق</th>
                        <th>موضوع</th>
                        <th>یگان</th>
                        <th>گروه</th>
                        <th>وضعیت</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Projects as $prj)
                        <tr>
                            <td>{{ $prj->ProjectNumber }}</td>
                            <td>{{ $prj->ScholarName }}</td>
                            <td>{{ $prj->Subject }}</td>
                            <td>{{ $prj->UnitName }}</td>
                            <td>{{ $prj->GroupName }}</td>
                            <td>% {{ $prj->ProjectStatus }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>موردی یافت نشد</p>
    @endforelse
    <h3>محققان</h3>
    @if ($Scholars->count() > 0)
        <div class="table-responsive" dir="ltr">
            <table class="table table-bordered" id="dataTable" style="width:100%;direction:rtl;text-align:center;"
                cellspacing="0">
                <thead>
                    <tr style="background-color: #d2ebfa;">
                        <th>نام محقق</th>
                        <th>کد ملی</th>
                        <th>رشته</th>
                        <th>گرایش</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Scholars as $sch)
                        <tr>
                            <td>{{ $sch->FirstName }} {{ $sch->LastName }}</td>
                            <td>{{ $sch->NationalCode }}</td>
                            <td>{{ $sch->MajorName }}</td>
                            <td>{{ $sch->OreintationName }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>موردی یافت نشد</p>
    @endforelse
    <h3>کاربران</h3>
    @if ($Users->count() > 0)
        <div class="table-responsive" dir="ltr" id="tableWrapper">
            <table class="table table-bordered" id="dataTable" style="width:100%;direction:rtl;text-align:center;"
                cellspacing="0">
                <thead>
                    <tr style="background-color: #d2ebfa;">
                        <th>مشخصات کاربر</th>
                        <th>نام کاربری</th>
                        <th>سطح کاربری</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Users as $usr)
                        <tr>
                            <td>{{ $usr->FirstName }} {{ $usr->LastName }}</td>
                            <td>{{ $usr->UserName }}</td>
                            @if (!$usr->IsAdmin)
                                <td>کاربر عادی</td>
                            @else
                                <td>کاربر ادمین</td>
                            @endforelse
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>موردی یافت نشد</p>
    @endforelse
    <h3>اطلاعات پایه</h3>

    @if ($BaseInfo->count() > 0)
        <div class="table-responsive" dir="ltr" id="BaseInfoTableWrapper">
            <table class="table table-bordered" id="BaseInfodataTable"
                style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                <thead>
                    <tr style="background-color: #d2ebfa;">
                        <th>ردیف</th>
                        <th>نوع</th>
                        <th>عنوان</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($BaseInfo->sortBy('SettingKey') as $key => $bi)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            @switch ($bi->SettingKey)
                                @case ('CollaborationType')
                                    <td>نوع همکاری</td>
                                @break
                                @case ('College')
                                    <td>دانشکده</td>
                                @break
                                @case ('GradeId')
                                    <td>مقطع تحصیلی</td>
                                @break
                                @case ('MillitaryStatus')
                                    <td>وضعیت خدمتی</td>
                                @break
                            @endswitch
                            <td>{{ $bi->SettingTitle }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>موردی یافت نشد</p>
    @endforelse

</body>

</html>
