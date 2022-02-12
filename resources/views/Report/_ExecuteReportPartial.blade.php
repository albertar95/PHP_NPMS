@if (!empty($tmpparam))
    @switch ($ReportType)
        @case (1)
            @switch ($tmpparam->FieldId)
                @case (1)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <input type="text" class="form-control form-control-user inputParams" id="{{ $tmpparam->FieldName }}"
                        name="{{ $tmpparam->FieldName }}">
                @break
                @case (2)
                    <select class="form-control allWidth inputParams" data-ng-style="btn-primary"
                        id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}" style="padding:0 .75rem;">
                        <option value="0" selected>مقطع تحصیلی</option>
                        @foreach ($Grades->sortBy('SettingTitle') as $grd)
                            <option value="{{ $grd->SettingValue }}">{{ $grd->SettingTitle }}</option>
                        @endforeach
                    </select>
                @break
                @case (3)
                    <select class="form-control allWidth inputParams" data-ng-style="btn-primary"
                        id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}" style="padding:0 .75rem;">
                        <option value="0" selected>رشته تحصیلی</option>
                        @foreach ($Majors->sortBy('Title') as $mjr)
                            <option value="{{ $mjr->NidMajor }}">{{ $mjr->Title }}</option>
                        @endforeach
                    </select>
                @break
                @case (4)
                    <select class="form-control allWidth inputParams" data-ng-style="btn-primary"
                        id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}" style="padding:0 .75rem;">
                        <option value="0" selected>گرایش</option>
                        @foreach ($Orientations->sortBy('MajorId') as $ore)
                            <option value="{{ $ore->NidOreintation }}">{{ $ore->Title }}</option>
                        @endforeach
                    </select>
                @break
                @case (5)
                    <select class="form-control allWidth inputParams" data-ng-style="btn-primary"
                        id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}" style="padding:0 .75rem;">
                        <option value="0" selected>وضعیت خدمتی</option>
                        @foreach ($MillitaryStatuses->sortBy('SettingTitle') as $typ)
                            <option value="{{ $typ->SettingValue }}">{{ $typ->SettingTitle }}</option>
                        @endforeach
                    </select>
                @break
                @case (6)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <input type="text" class="form-control form-control-user inputParams" id="{{ $tmpparam->FieldName }}"
                        name="{{ $tmpparam->FieldName }}">
                @break
            @endswitch
        @break
        @case (2)
            @switch ($tmpparam->FieldId)
                @case (1)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <input type="number" class="form-control form-control-user inputParams" id="{{ $tmpparam->FieldName }}"
                        name="{{ $tmpparam->FieldName }}"><label style="font-size: xx-large;">%</label>
                @break
                @case (2)
                    <select class="form-control allWidth inputParams" data-ng-style="btn-primary"
                        id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}" style="padding:0 .75rem;">
                        <option value="0" selected>یگان تخصصی</option>
                        @foreach ($units->sortBy('Title') as $un)
                            <option value="{{ $un->NidUnit }}">{{ $un->Title }}</option>
                        @endforeach
                    </select>
                @break
                @case (3)
                    <select class="form-control allWidth inputParams" data-ng-style="btn-primary"
                        id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}" style="padding:0 .75rem;">
                        <option value="0" selected>گروه تخصصی</option>
                        @foreach ($unitgroups->sortBy('Title') as $gp)
                            <option value="{{ $gp->NidGroup }}">{{ $gp->Title }}</option>
                        @endforeach
                    </select>
                @break
                @case (4)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <input type="text" class="form-control form-control-user inputParams" id="{{ $tmpparam->FieldName }}"
                        required name="{{ $tmpparam->FieldName }}">
                @break
                @case (5)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <input type="text" class="form-control form-control-user inputParams" id="{{ $tmpparam->FieldName }}"
                        required name="{{ $tmpparam->FieldName }}">
                @break
                @case (6)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <input type="text" class="form-control form-control-user inputParams" id="{{ $tmpparam->FieldName }}"
                        required name="{{ $tmpparam->FieldName }}">
                @break
                @case (7)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <input type="text" class="form-control form-control-user inputParams" id="{{ $tmpparam->FieldName }}"
                        required name="{{ $tmpparam->FieldName }}">
                @break
                @case (8)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <input type="text" class="form-control form-control-user inputParams" id="{{ $tmpparam->FieldName }}"
                        required name="{{ $tmpparam->FieldName }}">
                @break
                @case (9)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <input type="text" class="form-control form-control-user inputParams" id="{{ $tmpparam->FieldName }}"
                        required name="{{ $tmpparam->FieldName }}">
                @break
                @case (10)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <input type="text" class="form-control form-control-user inputParams" id="{{ $tmpparam->FieldName }}"
                        required name="{{ $tmpparam->FieldName }}">
                @break
                @case (11)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <input type="text" class="form-control form-control-user inputParams" id="{{ $tmpparam->FieldName }}"
                        required name="{{ $tmpparam->FieldName }}">
                @break
                @case (12)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <input type="text" class="form-control form-control-user inputParams" id="{{ $tmpparam->FieldName }}"
                        required name="{{ $tmpparam->FieldName }}">
                @break
                @case (13)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <input type="text" min="0" class="form-control form-control-user inputParams"
                        id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}">
                @break
                @case (14)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <input type="text" class="form-control form-control-user inputParams" id="{{ $tmpparam->FieldName }}"
                        required name="{{ $tmpparam->FieldName }}">
                @break
                @case (15)
                    <select class="form-control allWidth inputParams" data-ng-style="btn-primary"
                        id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}" style="padding:0 .75rem;">
                        <option value="0" selected>کاربر</option>
                        @foreach ($users->sortBy('UserName') as $usr)
                            <option value="{{ $usr->NidUser }}">{{ $usr->Username }}</option>
                        @endforeach
                    </select>
                @break
                @case (16)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <input type="text" class="form-control form-control-user inputParams" id="{{ $tmpparam->FieldName }}"
                        required name="{{ $tmpparam->FieldName }}">
                @break
                @case (17)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <input type="text" class="form-control form-control-user inputParams" id="{{ $tmpparam->FieldName }}"
                        required name="{{ $tmpparam->FieldName }}">
                @break
                @case (18)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <input type="text" class="form-control form-control-user inputParams" id="{{ $tmpparam->FieldName }}"
                        required name="{{ $tmpparam->FieldName }}">
                @break
                @case (19)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <select class="form-control allWidth inputParams" data-ng-style="btn-primary"
                        id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}" style="padding:0 .75rem;">
                        <option value="1" selected>دارد</option>
                        <option value="0">ندارد</option>
                    </select>
                @break
                @case (20)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <select class="form-control allWidth inputParams" data-ng-style="btn-primary"
                        id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}" style="padding:0 .75rem;">
                        <option value="1" selected>باشد</option>
                        <option value="0">نباشد</option>
                    </select>
                @break
            @endswitch
        @break
        @case (4)
            @switch ($tmpparam->FieldId)
                @case (1)
                    <select class="form-control allWidth inputParams" data-ng-style="btn-primary"
                        id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}" style="padding:0 .75rem;">
                        <option value="0" selected>نقش</option>
                        @foreach ($roles->sortBy('Title') as $rl)
                            <option value="{{ $rl->NidRole }}">{{ $rl->Title }}</option>
                        @endforeach
                    </select>
                @break
                @case (2)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <select class="form-control allWidth inputParams" data-ng-style="btn-primary"
                        id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}" style="padding:0 .75rem;">
                        <option value="1" selected>باشد</option>
                        <option value="0">نباشد</option>
                    </select>
                @break
                @case (3)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <select class="form-control allWidth inputParams" data-ng-style="btn-primary"
                        id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}" style="padding:0 .75rem;">
                        <option value="1" selected>باشد</option>
                        <option value="0">نباشد</option>
                    </select>
                @break
                @case (4)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <input type="text" class="form-control form-control-user inputParams" id="{{ $tmpparam->FieldName }}"
                        name="{{ $tmpparam->FieldName }}">
                @break
                @case (5)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <input type="number" min="0" class="form-control form-control-user inputParams"
                        id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}">
                @break
            @endswitch
        @break
    @endswitch
@endif
