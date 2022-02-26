<html>
<head>
    <style>
        body {font-family: 'fa', sans-serif !important;}
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
            <h1>گزارش فعالیت کاربر</h1>
        </div>
        <div style="width: 20%;"></div>
    </div>
    <div style="border: cornflowerblue 2px solid;margin-bottom: 25px;"></div>
    @if (!is_null($logs))

    <div class="table-responsive" dir="ltr">
        <table class="table table-bordered" border="1" id="logsDataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
            <thead>
                <tr style="background-color: #d2ebfa;">
                    <th>تاریخ</th>
                    <th>زمان</th>
                    <th>نام کاربری</th>
                    <th>توضیحات</th>
                    <th>درجه اهمیت</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $lg)
                    <tr>
                        <td>{{ $lg->LogDate ?? "" }}</td>
                        <td>{{ $lg->LogTime ?? "" }}</td>
                        <td>{{ $lg->Username ?? "" }}</td>
                        <td>{{ $lg->Description ?? "" }}</td>
                        <td>{{ $lg->ImportanceLevel ?? "" }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</body>
</html>
