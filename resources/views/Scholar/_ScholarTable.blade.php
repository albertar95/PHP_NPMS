<input type="number" value="{{ $txtLoadCount }}" id="LoadCount" hidden>
@if (in_array('1', $sharedData['UserAccessedEntities']))
    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 1)->pluck('rowValue')[0])[4] == 1)
        <table class="table table-bordered" id="dataTable1"
            style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
            <thead>
                <tr>
                    <th>نام محقق</th>
                    <th>کد ملی</th>
                    <th class="priority-1">مقطع تحصیلی</th>
                    <th class="priority-2">رشته</th>
                    <th class="priority-3">گرایش</th>
                    <th class="priority-4">محل تحصیل</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>نام محقق</th>
                    <th>کد ملی</th>
                    <th class="priority-1">مقطع تحصیلی</th>
                    <th class="priority-2">رشته</th>
                    <th class="priority-3">گرایش</th>
                    <th class="priority-4">محل تحصیل</th>
                    <th>عملیات</th>
                </tr>
            </tfoot>
            <tbody>
                @if (in_array('1', $sharedData['UserAccessedEntities']))
                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 1)->pluck('rowValue')[0])[4] == 1)
                        @foreach ($Scholar as $sch)
                            <tr>
                                <td>{{ $sch->FirstName ?? '' }} {{ $sch->LastName ?? '' }}</td>
                                <td>{{ $sch->NationalCode ?? '' }}</td>
                                <td class="priority-1">{{ $sch->Grade ?? '' }}</td>
                                <td class="priority-2">{{ $sch->MajorName }}</td>
                                <td class="priority-3">{{ $sch->OreintationName }}</td>
                                <td class="priority-4">{{ $sch->collegeName ?? '' }}</td>
                                <td>
                                    @if (in_array('1', $sharedData['UserAccessedEntities']))
                                        @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 1)->pluck('rowValue')[0])[1] == 1)
                                            <a href="{{ route('scholar.EditScholar', $sch->NidScholar) }}"
                                                style="margin: 2px;width: 110px;"
                                                class="btn btn-warning btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </span>
                                                <span class="text">ویرایش</span>
                                            </a>
                                        @endif
                                    @endif
                                    @if (in_array('1', $sharedData['UserAccessedEntities']))
                                        @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 1)->pluck('rowValue')[0])[2] == 1)
                                            <button class="btn btn-danger btn-icon-split"
                                                style="margin: 2px;width: 110px;"
                                                onclick="ShowModal(2,'{{ $sch->NidScholar }}')">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                                <span class="text">&nbsp; &nbsp; حذف</span>
                                            </button>
                                        @endif
                                    @endif
                                    @if (in_array('1', $sharedData['UserAccessedEntities']))
                                        @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 1)->pluck('rowValue')[0])[3] == 1)
                                            <button class="btn btn-info btn-icon-split"
                                                style="margin: 2px;width: 110px;"
                                                onclick="ShowModal(1,'{{ $sch->NidScholar }}')">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                                <span class="text">جزییات</span>
                                            </button>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @endif
            </tbody>
        </table>
    @endif
@endif
