<input type="number" value="{{ $txtLoadCount }}" id="LoadCount" hidden>
<table class="table table-bordered" id="dataTable1" style="width:100%;direction:rtl;text-align:center;"
    cellspacing="0">
    <thead>
        <tr>
            <th>شماره پرونده</th>
            <th>نام محقق</th>
            <th>موضوع</th>
            <th class="priority-1">یگان کاربر</th>
            <th class="priority-2">گروه</th>
            <th class="priority-3">وضعیت</th>
            <th>عملیات</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>شماره پرونده</th>
            <th>نام محقق</th>
            <th>موضوع</th>
            <th class="priority-1">یگان کاربر</th>
            <th class="priority-2">گروه</th>
            <th class="priority-3">وضعیت</th>
            <th>عملیات</th>
        </tr>
    </tfoot>
    <tbody>
        @if (in_array('2', $sharedData['UserAccessedEntities']))
            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 2)->pluck('rowValue')[0])[4] == 1)
                @foreach ($Projects as $prj)
                    <tr>
                        <td>{{ $prj->ProjectNumber }}</td>
                        <td>{{ $prj->ScholarName }}</td>
                        <td>{{ $prj->Subject }}</td>
                        <td class="priority-1">{{ $prj->UnitName }}</td>
                        <td class="priority-2">{{ $prj->GroupName }}</td>
                        <td>
                            <div class="chart-pie" style="width:50px;margin:0 auto;">
                                <canvas id="{{ $prj->NidProject }}"
                                    title="{{ $prj->ProjectStatus }}"></canvas>
                            </div>
                        </td>
                        <td>
                            @if (in_array('2', $sharedData['UserAccessedEntities']))
                                @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 2)->pluck('rowValue')[0])[1] == 1)
                                    <a href="{{ sprintf("%s/%s",URL::to('/projectprogress'),$prj->NidProject) }}"
                                        style="margin: 2px;width: 110px;"
                                        class="btn btn-warning btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-pencil-alt"></i>
                                        </span>
                                        <span class="text">ویرایش</span>
                                    </a>
                                @endif
                            @endif
                            @if (in_array('2', $sharedData['UserAccessedEntities']))
                                @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 2)->pluck('rowValue')[0])[2] == 1)
                                    <button class="btn btn-danger btn-icon-split"
                                        style="margin: 2px;width: 110px;"
                                        onclick="ShowModal(2,'{{ $prj->NidProject }}')">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                        <span class="text">&nbsp; &nbsp; حذف</span>
                                    </button>
                                @endif
                            @endif
                            @if (in_array('2', $sharedData['UserAccessedEntities']))
                                @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 2)->pluck('rowValue')[0])[3] == 1)
                                    <a href="{{ sprintf("%s/%s",URL::to('/projectdetail'),$prj->NidProject) }}"
                                        style="margin: 2px;width: 110px;"
                                        class="btn btn-info btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-info-circle"></i>
                                        </span>
                                        <span class="text">جزییات</span>
                                    </a>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        @endif
    </tbody>
</table>
{{-- <a rel="nofollow" href="#" id="btnMorePage" onclick="MorePages()" style="font-size: 17px;">نمایش طرح های بیشتر &plus;</a> --}}
