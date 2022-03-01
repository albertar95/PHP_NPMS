<thead>
    <tr>
        <th>تصویر</th>
        <th>مشخصات کاربر</th>
        <th>نام کاربری</th>
        <th>سطح کاربری</th>
        <th>عملیات</th>
    </tr>
</thead>
<tfoot>
    <tr>
        <th>تصویر</th>
        <th>مشخصات کاربر</th>
        <th>نام کاربری</th>
        <th>سطح کاربری</th>
        <th>عملیات</th>
    </tr>
</tfoot>
<tbody>
    @if (!empty($Users))
        @foreach ($Users as $usr)
            <tr>
                <td>
                    @if (!empty($usr->ProfilePicture))
                        <img src="/storage/images/{{ $usr->ProfilePicture }}" height="50" width="50" />
                    @else
                        <img height="50" width="50" src="{{ URL('Content/img/User/user3.png') }}">
                    @endforelse
                </td>
                <td>{{ $usr->FirstName }} {{ $usr->LastName }}</td>
                <td>{{ $usr->Username }}</td>
                <td>{{ $usr->RoleTitle }}</td>
                <td>
                    @if ($sourceid == 5)
                        @if (in_array('3', $sharedData['UserAccessedEntities']))
                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 3)->pluck('rowValue')[0])[3] == 1)
                                <button class="btn btn-info btn-icon-split" style="margin: 2px;width: 110px;"
                                    onclick="ShowModal(1,'{{ $usr->NidUser }}')">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-info-circle"></i>
                                    </span>
                                    <span class="text">جزییات</span>
                                </button>
                            @endif
                        @endif
                        @if (in_array('3', $sharedData['UserAccessedEntities']))
                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 3)->pluck('rowValue')[0])[1] == 1)
                                <a href="{{ sprintf('%s/%s', URL::to('/edituser'), $usr->NidUser) }}"
                                    class="btn btn-warning btn-icon-split" style="margin: 2px;width: 110px;">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-pencil-alt"></i>
                                    </span>
                                    <span class="text">ویرایش</span>
                                </a>
                            @endif
                        @endif
                        @if (in_array('3', $sharedData['UserAccessedEntities']))
                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 3)->pluck('rowValue')[0])[2] == 1)
                                <button class="btn btn-danger btn-icon-split" style="margin: 2px;width: 110px;"
                                    onclick="ShowModal(2,'{{ $usr->NidUser }}')">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                    <span class="text">غیرفعال</span>
                                </button>
                            @endif
                        @endif
                    @else
                        @if ($sourceid == 1)
                            @if (in_array('3', $sharedData['UserAccessedEntities']))
                                @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 3)->pluck('rowValue')[0])[2] == 1)
                                    <button class="btn btn-success btn-icon-split" style="margin: 2px;width: 140px;"
                                        onclick="ShowModal(3,'{{ $usr->NidUser }}')">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-undo"></i>
                                        </span>
                                        <span class="text">فعال کردن</span>
                                    </button>
                                    {{-- <button class="btn btn-danger btn-icon-split" style="margin: 2px;width: 110px;"
                                        onclick="ShowModal(4,'{{ $usr->NidUser }}')">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                        <span class="text">حذف</span>
                                    </button> --}}
                                @endif
                            @endif
                        @endif
                        @if ($sourceid == 2)
                            @if (in_array('0', $sharedData['UserAccessedEntities']))
                                <button class="btn btn-success btn-icon-split" style="margin: 2px;width: 140px;"
                                    onclick="ShowModal(5,'{{ $usr->NidUser }}')">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-undo"></i>
                                    </span>
                                    <span class="text">رفع تعلیق</span>
                                </button>
                            @endif
                        @endif
                    @endforelse
                </td>
            </tr>
        @endforeach
    @endif
</tbody>
