@switch ($TblId)
    @case (1)
        @if (in_array('6', $sharedData['UserAccessedEntities']))
            <table class="table table-bordered" id="UnitdataTable" style="width:100%;direction:rtl;text-align:center;"
                cellspacing="0">
                <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>عنوان یگان</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ردیف</th>
                        <th>عنوان یگان</th>
                        <th>عملیات</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($Units as $key => $unit)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $unit->Title }}</td>
                            <td>
                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[2] == 1)
                                        <button class="btn btn-danger"
                                            onclick="DeleteModal(1,'{{ $unit->NidUnit }}')">حذف</button>
                                    @endif
                                @endif
                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[1] == 1)
                                        <button class="btn btn-warning"
                                            onclick="EditThis(1,'{{ $unit->NidUnit }}','{{ $unit->Title }}','')">ویرایش</button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @break
    @case (2)
        @if (in_array('6', $sharedData['UserAccessedEntities']))
            <table class="table table-bordered" id="UnitGroupdataTable" style="width:100%;direction:rtl;text-align:center;"
                cellspacing="0">
                <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>یگان</th>
                        <th>عنوان گروه</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ردیف</th>
                        <th>یگان</th>
                        <th>عنوان گروه</th>
                        <th>عملیات</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($UnitGroups as $key => $unitgroup)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $Units->Where('NidUnit', '=', $unitgroup->UnitId)->firstOrFail()->Title }}</td>
                            <td>{{ $unitgroup->Title }}</td>
                            <td>
                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[2] == 1)
                                        <button class="btn btn-danger"
                                            onclick="DeleteModal(2,'{{ $unitgroup->NidGroup }}')">حذف</button>
                                    @endif
                                @endif
                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[1] == 1)
                                        <button class="btn btn-warning"
                                            onclick="EditThis(2,'{{ $unitgroup->NidGroup }}','{{ $unitgroup->Title }}','{{ $unitgroup->UnitId }}')">ویرایش</button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @break
    @case (3)
        @if (in_array('6', $sharedData['UserAccessedEntities']))
            <table class="table table-bordered" id="GradedataTable" style="width:100%;direction:rtl;text-align:center;"
                cellspacing="0">
                <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>عنوان مقطع تحصیلی</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ردیف</th>
                        <th>عنوان مقطع تحصیلی</th>
                        <th>عملیات</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($Grades as $key => $grade)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $grade->SettingTitle }}</td>
                            <td>
                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[2] == 1)
                                        <button class="btn btn-danger"
                                            onclick="DeleteModal(3,'{{ $grade->NidSetting }}')">حذف</button>
                                    @endif
                                @endif
                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[1] == 1)
                                        <button class="btn btn-warning"
                                            onclick="EditThis(3,'{{ $grade->NidSetting }}','{{ $grade->SettingTitle }}','{{ $grade->SettingValue }}')">ویرایش</button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @break
    @case (4)
        @if (in_array('6', $sharedData['UserAccessedEntities']))
            <table class="table table-bordered" id="MajordataTable" style="width:100%;direction:rtl;text-align:center;"
                cellspacing="0">
                <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>عنوان رشته تحصیلی</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ردیف</th>
                        <th>عنوان رشته تحصیلی</th>
                        <th>عملیات</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($Majors as $key => $major)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $major->Title }}</td>
                            <td>
                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[2] == 1)
                                        <button class="btn btn-danger"
                                            onclick="DeleteModal(4,'{{ $major->NidMajor }}')">حذف</button>
                                    @endif
                                @endif
                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[1] == 1)
                                        <button class="btn btn-warning"
                                            onclick="EditThis(4,'{{ $major->NidMajor }}','{{ $major->Title }}','')">ویرایش</button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @break
    @case (5)
        @if (in_array('6', $sharedData['UserAccessedEntities']))
            <table class="table table-bordered" id="OreintationdataTable"
                style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>رشته تحصیلی</th>
                        <th>عنوان گرایش</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ردیف</th>
                        <th>رشته تحصیلی</th>
                        <th>عنوان گرایش</th>
                        <th>عملیات</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($Oreintations as $key => $oreintation)
                        <tr>
                            <td>{{ $key }}</td>
                            <td>{{ $Majors->Where('NidMajor', '=', $oreintation->MajorId)->firstOrFail()->Title }}</td>
                            <td>{{ $oreintation->Title }}</td>
                            <td>
                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[2] == 1)
                                        <button class="btn btn-danger"
                                            onclick="DeleteModal(5,'{{ $oreintation->NidOreintation }}')">حذف</button>
                                    @endif
                                @endif
                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[1] == 1)
                                        <button class="btn btn-warning"
                                            onclick="EditThis(5,'{{ $oreintation->NidOreintation }}','{{ $oreintation->Title }}','{{ $oreintation->MajorId }}')">ویرایش</button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @break
    @case (6)
        @if (in_array('6', $sharedData['UserAccessedEntities']))
            <table class="table table-bordered" id="CollegedataTable" style="width:100%;direction:rtl;text-align:center;"
                cellspacing="0">
                <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>عنوان دانشکده</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ردیف</th>
                        <th>عنوان دانشکده</th>
                        <th>عملیات</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($Colleges as $key => $college)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $college->SettingTitle }}</td>
                            <td>
                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[2] == 1)
                                        <button class="btn btn-danger"
                                            onclick="DeleteModal(6,'{{ $college->NidSetting }}')">حذف</button>
                                    @endif
                                @endif
                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[1] == 1)
                                        <button class="btn btn-warning"
                                            onclick="EditThis(6,'{{ $college->NidSetting }}','{{ $college->SettingTitle }}','{{ $college->SettingValue }}')">ویرایش</button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @break
    @case (7)
        @if (in_array('6', $sharedData['UserAccessedEntities']))
            <table class="table table-bordered" id="MillitdataTable" style="width:100%;direction:rtl;text-align:center;"
                cellspacing="0">
                <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>عنوان وضعیت خدمتی</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ردیف</th>
                        <th>عنوان وضعیت خدمتی</th>
                        <th>عملیات</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($MillitaryStatuses as $key => $millit)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $millit->SettingTitle }}</td>
                            <td>
                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[2] == 1)
                                        <button class="btn btn-danger"
                                            onclick="DeleteModal(7,'{{ $millit->NidSetting }}')">حذف</button>
                                    @endif
                                @endif
                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[1] == 1)
                                        <button class="btn btn-warning"
                                            onclick="EditThis(7,'{{ $millit->NidSetting }}','{{ $millit->SettingTitle }}','{{ $millit->SettingValue }}')">ویرایش</button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @break
    @case (8)
        @if (in_array('6', $sharedData['UserAccessedEntities']))
            <table class="table table-bordered" id="CollabdataTable" style="width:100%;direction:rtl;text-align:center;"
                cellspacing="0">
                <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>عنوان نوع همکاری</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ردیف</th>
                        <th>عنوان نوع همکاری</th>
                        <th>عملیات</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($CollaborationTypes as $key => $collab)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $collab->SettingTitle }}</td>
                            <td>
                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[2] == 1)
                                        <button class="btn btn-danger"
                                            onclick="DeleteModal(8,'{{ $collab->NidSetting }}')">حذف</button>
                                    @endif
                                @endif
                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[1] == 1)
                                        <button class="btn btn-warning"
                                            onclick="EditThis(8,'{{ $collab->NidSetting }}','{{ $collab->SettingTitle }}','{{ $collab->SettingValue }}')">ویرایش</button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @break
    @case(9)
        <table class="table table-bordered" id="RoledataTable" style="width:100%;direction:rtl;text-align:center;"
            cellspacing="0">
            <thead>
                <tr>
                    <th>ردیف</th>
                    <th>عنوان نقش</th>
                    <th>سطح نقش</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>ردیف</th>
                    <th>عنوان نقش</th>
                    <th>سطح نقش</th>
                    <th>عملیات</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($Roles as $key => $role)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $role->Title }}</td>
                        @if ($role->IsAdmin)
                            <td>نقش مدیر</td>
                        @else
                            <td>نقش عادی</td>
                        @endforelse
                        <td>
                            @if (in_array('0', $sharedData['UserAccessedEntities']))
                                @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 0)->pluck('rowValue')[0])[2] == 1)
                                    <button class="btn btn-danger btn-icon-split" style="margin: 2px;"
                                        onclick="DeleteModal(1,'{{ $role->NidRole }}')">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                        <span class="text">حذف</span>
                                    </button>
                                @endif
                                @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 0)->pluck('rowValue')[0])[1] == 1)
                                    <button class="btn btn-warning btn-icon-split" style="margin: 2px;"
                                        onclick="EditThis('{{ $role->NidRole }}','{{ $role->Title }}','{{ $role->CreateDate }}','{{ $role->IsAdmin }}')">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-pencil-alt"></i>
                                        </span>
                                        <span class="text">ویرایش</span>
                                    </button>
                                @endif
                                <a href="/managerolepermissions/{{ $role->NidRole }}" style="margin: 2px;"
                                    class="btn btn-info btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-door-open"></i>
                                    </span>
                                    <span class="text">اعمال دسترسی</span>
                                </a>
                                <a href="/managerolesuser/{{ $role->NidRole }}" style="margin: 2px;"
                                    class="btn btn-secondary btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <span class="text">کاربران</span>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @break
@endswitch
