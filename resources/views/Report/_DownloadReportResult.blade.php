<html>
<head>
    <style>
        body {font-family: 'fa', sans-serif !important;}

        </style>
</head>
<body>

@if (!is_null($Scholars))

<div class="table-responsive" dir="ltr">
    <table class="table table-bordered" border="1" id="ScholarDataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
        <thead>
            <tr>
                @if ($OutputKey->contains("FirstName") || $OutputKey->contains("LastName"))

                    <th>نام محقق</th>
                @endif
                @if ($OutputKey->contains("NationalCode"))

                    <th>کد ملی</th>
                @endif
                @if ($OutputKey->contains("GradeId"))

                    <th>مقطع تحصیلی</th>
                @endif
                @if ($OutputKey->contains("MajorId"))

                    <th>رشته</th>
                @endif
                @if ($OutputKey->contains("OreintationId"))

                    <th>گرایش</th>
                @endif
                @if ($OutputKey->contains("college"))

                    <th>محل تحصیل</th>
                @endif
                @if ($OutputKey->contains("BirthDate"))

                    <th>تاریخ تولد</th>
                @endif
                @if ($OutputKey->contains("CollaborationType"))

                    <th>نوع همکاری</th>
                @endif
                @if ($OutputKey->contains("FatherName"))

                    <th>نام پدر</th>
                @endif
                @if ($OutputKey->contains("MillitaryStatus"))

                    <th>وضعیت خدمتی</th>
                @endif
                @if ($OutputKey->contains("Mobile"))

                    <th>شماره همراه</th>
                @endif
                @if ($OutputKey->contains("ProjectCount"))

                    <th>پروژه ها</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($Scholars as $sch)
                <tr>
                    @if ($OutputKey->contains("FirstName") || $OutputKey->contains("LastName"))

                        @if ($OutputKey->contains("FirstName") && $OutputKey->contains("LastName"))

                            <td>{{ $sch->FirstName ?? ""}} {{ $sch->LastName ?? "" }}</td>
                        @elseif ($OutputKey->contains("FirstName"))

                            <td>{{ $sch->FirstName ?? "" }}</td>
                        @else

                            <td>{{ $sch->LastName ?? "" }}</td>
                        @endforelse
                    @endif
                    @if ($OutputKey->contains("NationalCode"))

                        <td>{{ $sch->NationalCode ?? "" }}</td>
                    @endif
                    @if ($OutputKey->contains("GradeId"))

                        <td>{{ $sch->GradeTitle ?? "" }}</td>
                    @endif
                    @if ($OutputKey->contains("MajorId"))

                        <td>{{ $sch->Major->Title }}</td>
                    @endif
                    @if ($OutputKey->contains("OreintationId"))

                        <td>{{ $sch->Oreintation->Title }}</td>
                    @endif
                    @if ($OutputKey->contains("college"))

                        <td>{{ $sch->CollegeTitle ?? "" }}</td>
                    @endif
                    @if ($OutputKey->contains("BirthDate"))

                        <td>{{ $sch->BirthDate ?? "" }}</td>
                    @endif
                    @if ($OutputKey->contains("CollaborationType"))

                        <td>{{ $sch->CollaborationTypeTitle ?? "" }}</td>
                    @endif
                    @if ($OutputKey->contains("FatherName"))

                        <td>{{ $sch->FatherName ?? "" }}</td>
                    @endif
                    @if ($OutputKey->contains("MillitaryStatus"))

                        <td>{{ $sch->MillitaryStatusTitle ?? "" }}</td>
                    @endif
                    @if ($OutputKey->contains("Mobile"))

                        <td>{{ $sch->Mobile ?? "" }}</td>
                    @endif
                    {{-- @if ($OutputKey->contains("ProjectCount"))

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

</body>
</html>
