<h3>طرح ها</h3>
@if ($Projects->count() > 0)
    <div class="table-responsive" dir="ltr">
        <table class="table table-bordered" id="dataTable" style="width:100%;direction:rtl;text-align:center;"
            cellspacing="0">
            <thead>
                <tr>
                    <th>شماره پرونده</th>
                    <th>نام محقق</th>
                    <th>موضوع</th>
                    <th class="priority-1">یگان</th>
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
                    <th class="priority-1">یگان</th>
                    <th class="priority-2">گروه</th>
                    <th class="priority-3">وضعیت</th>
                    <th>عملیات</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($Projects as $prj)
                    <tr>
                        <td>{{ $prj->ProjectNumber }}</td>
                        <td>{{ $prj->ScholarName }}</td>
                        <td>{{ $prj->Subject }}</td>
                        <td class="priority-1">{{ $prj->UnitName }}</td>
                        <td class="priority-2">{{ $prj->GroupName }}</td>
                        <td class="priority-3">% {{ $prj->ProjectStatus }}</td>
                        <td>
                            <a href="{{ link_to_route('project.ProjectDetail', '', $NidProject = $prj->NidProject) }}"
                                class="btn btn-secondary">جزییات</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <p>موردی یافت نشد</p>
@endforelse
<h3>محققان</h3>
@if ($Scholars->count() > 0)
    <div class="table-responsive" dir="ltr">
        <table class="table table-bordered" id="dataTable" style="width:100%;direction:rtl;text-align:center;"
            cellspacing="0">
            <thead>
                <tr>
                    <th>نام محقق</th>
                    <th>کد ملی</th>
                    <th class="priority-2">رشته</th>
                    <th class="priority-3">گرایش</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>نام محقق</th>
                    <th>کد ملی</th>
                    <th class="priority-2">رشته</th>
                    <th class="priority-3">گرایش</th>
                    <th>عملیات</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($Scholars as $sch)
                    <tr>
                        <td>{{ $sch->FirstName }} {{ $sch->LastName }}</td>
                        <td>{{ $sch->NationalCode }}</td>
                        <td class="priority-2">{{ $sch->MajorName }}</td>
                        <td class="priority-3">{{ $sch->OreintationName }}</td>
                        <td>
                            <button class="btn btn-secondary"
                                onclick="ShowDetailModal(1,'{{ $sch->NidScholar }}')">جزییات</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <p>موردی یافت نشد</p>
@endforelse
<h3>کاربران</h3>
@if ($Users->count() > 0)
    <div class="table-responsive" dir="ltr" id="tableWrapper">
        <table class="table table-bordered" id="dataTable" style="width:100%;direction:rtl;text-align:center;"
            cellspacing="0">
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
                @foreach ($Users as $usr)
                    <tr>
                        <td>
                            @if (!Empty($usr->ProfilePicture))
                                <img src="{{ sprintf("/storage/images/%s", $usr->ProfilePicture) }}" height="100" width="100" />
                            @endif
                        </td>
                        <td>{{ $usr->FirstName }} {{ $usr->LastName }}</td>
                        <td>{{ $usr->Username }}</td>
                        @if (!$usr->IsAdmin)
                            <td>کاربر عادی</td>
                        @else
                        <td>کاربر ادمین</td>
                        @endforelse
                <td>
                    <button class="btn btn-secondary"
                        onclick="ShowDetailModal(2,'{{ $usr->NidUser }}')">جزییات</button>
                </td>
                </tr>
@endforeach
</tbody>
</table>
</div>
@else
<p>موردی یافت نشد</p>
@endforelse
<h3>اطلاعات پایه</h3>

@if ($BaseInfo->count() > 0)
    <div class="table-responsive" dir="ltr" id="BaseInfoTableWrapper">
        <table class="table table-bordered" id="BaseInfodataTable" style="width:100%;direction:rtl;text-align:center;"
            cellspacing="0">
            <thead>
                <tr>
                    <th>ردیف</th>
                    <th>نوع</th>
                    <th>عنوان</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>ردیف</th>
                    <th>نوع</th>
                    <th>عنوان</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($BaseInfo->sortBy('SettingKey') as $bi)
                    <tr>
                        <td>{{ $tmpCounter }}</td>
                        @switch ($bi->SettingKey)
                            @case ('CollaborationType')
                                <td>نوع همکاری</td>
                            @break
                            @case ('College')
                                <td>دانشکده</td>
                            @break
                            @case ('GradeId')
                                <td>مقطع تحصیلی</td>
                            @break
                            @case ('MillitaryStatus')
                                <td>وضعیت خدمتی</td>
                            @break
                        @endswitch
                        <td>{{ $bi->SettingTitle }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
<p>موردی یافت نشد</p>
@endforelse
