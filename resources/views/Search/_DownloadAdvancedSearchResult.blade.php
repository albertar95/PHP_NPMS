<html>

<head>
    <style>
        body {
            font-family: 'fa', sans-serif !important;
        }

    </style>
</head>

<body>

    <h3>طرح ها</h3>
    @if ($Projects->count() > 0)
        <div class="table-responsive" dir="ltr">
            <table class="table table-bordered" id="dataTable" style="width:100%;direction:rtl;text-align:center;"
                cellspacing="0">
                <thead>
                    <tr>
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
                    <tr>
                        <th>نام محقق</th>
                        <th>کد ملی</th>
                        <th>رشته</th>
                        <th>گرایش</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>نام محقق</th>
                        <th>کد ملی</th>
                        <th>رشته</th>
                        <th>گرایش</th>
                    </tr>
                </tfoot>
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
                    <tr>
                        <th>مشخصات کاربر</th>
                        <th>نام کاربری</th>
                        <th>سطح کاربری</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Users as $usr)
                        <tr>
                            <td>{{ $usr->FirstName }} {{ $usr->LastName }}</td>
                            <td>{{ $usr->Username }}</td>
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
                    <tr>
                        <th>ردیف</th>
                        <th>نوع</th>
                        <th>عنوان</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ردیف</th>
                        <th>نوع</th>
                        <th>عنوان</th>
                    </tr>
                </tfoot>
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
