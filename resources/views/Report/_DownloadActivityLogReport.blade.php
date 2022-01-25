<html>
<head>
    <style>
        body {font-family: 'fa', sans-serif !important;}

        </style>
</head>
<body>
    @if (!is_null($logs))

    <div class="table-responsive" dir="ltr">
        <table class="table table-bordered" id="logsDataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
            <thead>
                <tr>
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
