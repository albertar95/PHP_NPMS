{{ $tmpCounter = 1; }}
@switch ($TblId)
    @case (1)
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
            @foreach ($Units as $unit)
                <tr>
                    <td>{{ $tmpCounter }}</td>
                    <td>{{ $unit->Title }}</td>
                    <td>
                        <button class="btn btn-danger" onclick="DeleteModal(1,{{ $unit->NidUnit }})">حذف</button>
                        <button class="btn btn-warning"
                            onclick="EditThis(1,{{ $unit->NidUnit }},{{ $unit->Title }},'')">ویرایش</button>
                    </td>
                </tr>
                {{ $tmpCounter++; }}
            @endforeach
        </tbody>
    </table>
    @break
    @case (2)
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
            {{ $tmpCounter = 1; }}
            @foreach ($UnitGroups as $unitgroup)
            <tr>
                <td>{{ $tmpCounter }}</td>
                <td>{{ $Units->Where('NidUnit','=',$unitgroup->UnitId)->firstOrFail()->Title }}</td>
                <td>{{ $unitgroup->Title }}</td>
                <td>
                    <button class="btn btn-danger" onclick="DeleteModal(2,{{ $unitgroup->NidGroup }})">حذف</button>
                    <button class="btn btn-warning"
                        onclick="EditThis(2,{{ $unitgroup->NidGroup }},{{ $unitgroup->Title }},{{ $unitgroup->UnitId }})">ویرایش</button>
                </td>
            </tr>
            {{ $tmpCounter++; }}
        @endforeach
        </tbody>
    </table>
    @break
    @case (3)
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
            {{ $tmpCounter = 1; }}
            @foreach ($Grades as $grade)
            <tr>
                <td>{{ $tmpCounter }}</td>
                <td>{{ $grade->SettingTitle }}</td>
                <td>
                    <button class="btn btn-danger" onclick="DeleteModal(3,{{ $grade->NidSetting }})">حذف</button>
                    <button class="btn btn-warning"
                        onclick="EditThis(3,{{ $grade->NidSetting }},{{ $grade->SettingTitle }},{{ $grade->SettingValue }})">ویرایش</button>
                </td>
            </tr>
            {{ $tmpCounter++; }}
        @endforeach
        </tbody>
    </table>
    @break
    @case (4)
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
            {{ $tmpCounter = 1; }}
            @foreach ($Majors as $major)
            <tr>
                <td>{{ $tmpCounter }}</td>
                <td>{{ $major->Title }}</td>
                <td>
                    <button class="btn btn-danger" onclick="DeleteModal(4,{{ $major->NidMajor }})">حذف</button>
                    <button class="btn btn-warning"
                        onclick="EditThis(4,{{ $major->NidMajor }},{{ $major->Title }},'')">ویرایش</button>
                </td>
            </tr>
            {{ $tmpCounter++; }}
        @endforeach
        </tbody>
    </table>
    @break
    @case (5)
    <table class="table table-bordered" id="OreintationdataTable" style="width:100%;direction:rtl;text-align:center;"
        cellspacing="0">
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
            {{ $tmpCounter = 1; }}
            @foreach ($Oreintations as $oreintation)
            <tr>
                <td>{{ $tmpCounter }}</td>
                <td>{{ $Majors->Where('NidMajor','=',$oreintation->MajorId)->firstOrFail()->Title }}</td>
                <td>{{ $oreintation->Title }}</td>
                <td>
                    <button class="btn btn-danger" onclick="DeleteModal(5,{{ $oreintation->NidOreintation }})">حذف</button>
                    <button class="btn btn-warning"
                        onclick="EditThis(5,{{ $oreintation->NidOreintation }},{{ $oreintation->Title }},{{ $oreintation->MajorId }})">ویرایش</button>
                </td>
            </tr>
            {{ $tmpCounter++; }}
        @endforeach
        </tbody>
    </table>
    @break
    @case (6)
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
            {{ $tmpCounter = 1; }}
            @foreach ($Colleges as $college)
            <tr>
                <td>{{ $tmpCounter }}</td>
                <td>{{ $college->SettingTitle }}</td>
                <td>
                    <button class="btn btn-danger" onclick="DeleteModal(6,{{ $college->NidSetting }})">حذف</button>
                    <button class="btn btn-warning"
                        onclick="EditThis(6,{{ $college->NidSetting }},{{ $college->SettingTitle }},{{ $college->SettingValue }})">ویرایش</button>
                </td>
            </tr>
            {{ $tmpCounter++; }}
        @endforeach
        </tbody>
    </table>
    @break
    @case (7)
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
            {{ $tmpCounter = 1; }}
            @foreach ($MillitaryStatuses as $millit)
            <tr>
                <td>{{ $tmpCounter }}</td>
                <td>{{ $millit->SettingTitle }}</td>
                <td>
                    <button class="btn btn-danger" onclick="DeleteModal(7,{{ $millit->NidSetting }})">حذف</button>
                    <button class="btn btn-warning"
                        onclick="EditThis(7,{{ $millit->NidSetting }},{{ $millit->SettingTitle }},{{ $millit->SettingValue }})">ویرایش</button>
                </td>
            </tr>
            {{ $tmpCounter++; }}
        @endforeach
        </tbody>
    </table>
    @break
    @case (8)
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
            {{ $tmpCounter = 1; }}
            @foreach ($CollaborationTypes as $collab)
            <tr>
                <td>{{ $tmpCounter }}</td>
                <td>{{ $collab->SettingTitle }}</td>
                <td>
                    <button class="btn btn-danger" onclick="DeleteModal(8,{{ $collab->NidSetting }})">حذف</button>
                    <button class="btn btn-warning"
                        onclick="EditThis(8,{{ $collab->NidSetting }},{{ $collab->SettingTitle }},{{ $collab->SettingValue }})">ویرایش</button>
                </td>
            </tr>
            {{ $tmpCounter++; }}
        @endforeach
        </tbody>
    </table>
    @break
    @endswitch
