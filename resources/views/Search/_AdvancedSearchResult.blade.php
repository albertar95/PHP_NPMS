<div class="form-group row">
    <button class="btn btn-danger btn-icon-split" style="margin:5px;" onclick="ExportResult(1)">
        <span class="icon text-white-50">
            <i class="fas fa-file-pdf"></i>
        </span>
        <span class="text">
            خروجی
            pdf
        </span>
    </button>
    <button class="btn btn-primary btn-icon-split" style="margin:5px;" onclick="ExportResult(3)">
        <span class="icon text-white-50">
            <i class="fas fa-print"></i>
        </span>
        <span class="text">
            پرینت
        </span>
    </button>
    <p style="font-size:large;text-align: center;color: lightcoral;margin-top: 0.5rem;" id="waitText2" hidden>لطفا منتظر بمانید</p>
</div>
@if (in_array('2', $sharedData['UserAccessedEntities']))
    <h3 style="text-align: right;">طرح ها</h3>
    @if ($Projects->count() > 0)
        <div class="table-responsive" dir="ltr">
            <table class="table table-bordered" id="projectdataTable" style="width:100%;direction:rtl;text-align:center;"
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
                                <a href="{{ sprintf("%s/%s",URL::to('/projectdetail'),$prj->NidProject) }}" class="btn btn-secondary">جزییات</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p style="text-align: right;">موردی یافت نشد</p>
    @endforelse
@endif
@if (in_array('1', $sharedData['UserAccessedEntities']))
    <h3 style="text-align: right;">محققان</h3>
    @if ($Scholars->count() > 0)
        <div class="table-responsive" dir="ltr">
            <table class="table table-bordered" id="scholardataTable" style="width:100%;direction:rtl;text-align:center;"
                cellspacing="0">
                <thead>
                    <tr>
                        <th>نام محقق</th>
                        <th>کد ملی</th>
                        <th class="priority-2">رشته</th>
                        <th class="priority-3">گرایش</th>
                        <th class="priority-3">تاییدیه حفاظت</th>
                        <th class="priority-3">تاریخ نامه حفاظت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>نام محقق</th>
                        <th>کد ملی</th>
                        <th class="priority-2">رشته</th>
                        <th class="priority-3">گرایش</th>
                        <th class="priority-3">تاییدیه حفاظت</th>
                        <th class="priority-3">تاریخ نامه حفاظت</th>
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
                            @if($sch->IsSecurityApproved)
                            <td class="priority-3">دارد</td>
                            @else
                            <td class="priority-3">ندارد</td>
                            @endforelse
                            <td class="priority-3">{{ $sch->SecurityApproveDate }}</td>
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
        <p style="text-align: right;">موردی یافت نشد</p>
    @endforelse
@endif
@if (in_array('3', $sharedData['UserAccessedEntities']))
    <h3 style="text-align: right;">کاربران</h3>
    @if ($Users->count() > 0)
        <div class="table-responsive" dir="ltr" id="tableWrapper">
            <table class="table table-bordered" id="userdataTable" style="width:100%;direction:rtl;text-align:center;"
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
                                @if (!empty($usr->ProfilePicture))
                                    <img src="{{ sprintf('/storage/images/%s', $usr->ProfilePicture) }}" height="100"
                                        width="100" />
                                @endif
                            </td>
                            <td>{{ $usr->FirstName }} {{ $usr->LastName }}</td>
                            <td>{{ $usr->UserName }}</td>
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
        <p style="text-align: right;">موردی یافت نشد</p>
    @endforelse
@endif
@if (in_array('6', $sharedData['UserAccessedEntities']))
    <h3 style="text-align: right;">اطلاعات پایه</h3>

    @if ($BaseInfo->count() > 0)
        <div class="table-responsive" dir="ltr" id="BaseInfoTableWrapper">
            <table class="table table-bordered" id="BaseInfodataTable"
                style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
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
                    @foreach ($BaseInfo->sortBy('SettingKey') as $key => $bi)
                        <tr>
                            <td>{{ $key + 1 }}</td>
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
        <p style="text-align: right;">موردی یافت نشد</p>
    @endforelse
@endif
