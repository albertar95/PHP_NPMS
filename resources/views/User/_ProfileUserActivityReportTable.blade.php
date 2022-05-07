<input type="text" value="{{ $txtLoadCount }}" id="LoadCount" hidden>
<table class="table table-bordered" id="userlogdataTable" style="width:100%;direction:rtl;text-align:center;"
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
