
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

<div class="form-group row">
<button class="btn btn-danger" style="margin:5px;" onclick="ExportResult(1, 1, 'UserActivityReport')">خروجی pdf</button>
<button class="btn btn-success" style="margin:5px;" onclick="ExportResult(1,2,'UserActivityReport')">خروجی excel</button>
<button class="btn btn-primary" style="margin:5px;" onclick="ExportResult(1,3,'UserActivityReport')">خروجی word</button>
</div>
