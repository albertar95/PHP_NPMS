@if (!is_null($logs))

    <div class="table-responsive" dir="ltr">
        <table class="table table-bordered" id="logsDataTable" style="width:100%;direction:rtl;text-align:center;"
            cellspacing="0">
            <thead>
                <tr>
                    <th>تاریخ</th>
                    <th>زمان</th>
                    <th>نام کاربری</th>
                    <th>نوع فعالیت</th>
                    <th>توضیحات</th>
                    <th>ای پی</th>
                    <th>درجه اهمیت</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $lg)
                    <tr>
                        <td>{{ $lg->LogDate ?? '' }}</td>
                        <td>{{ $lg->LogTime ?? '' }}</td>
                        <td>{{ $lg->Username ?? '' }}</td>
                        <td>{{ $lg->ActionName ?? '' }}</td>
                        <td>{{ $lg->Description ?? '' }}</td>
                        <td>{{ $lg->IP ?? '' }}</td>
                        @switch($lg->ImportanceLevel)
                            @case(1)
                                <td>عادی</td>
                            @break

                            @case(2)
                                <td>مهم</td>
                            @break

                            @case(3)
                                <td>خیلی مهم</td>
                            @break

                            @default
                                <td></td>
                        @endswitch
                        {{-- <td>{{ $lg->ImportanceLevel ?? '' }}</td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

<div class="form-group row">
    <button class="btn btn-danger" style="margin:5px;" onclick="ExportResult(1, 1, 'UserActivityReport')"> <i
            class="fas fa-file-pdf"></i>
        خروجی
        pdf</button>
    <button class="btn btn-success" style="margin:5px;" onclick="ExportResult(1,2,'UserActivityReport')"> <i
            class="fas fa-file-excel"></i>
        خروجی
        excel</button>
    <button class="btn btn-primary" style="margin:5px;" onclick="ExportResult(1,3,'UserActivityReport')"> <i
            class="fas fa-print"></i>
        پرینت</button>
</div>
