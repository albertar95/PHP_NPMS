@if (!empty($tmpparam))
    @switch ($ReportType)
        @case (1)
            @switch ($tmpparam->FieldId)
                @case (1)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <input type="text" class="form-control form-control-user inputParams" id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}">
                    @break
                @case (2)
                    <select class="form-control allWidth inputParams" data-ng-style="btn-primary" id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}" style="padding:0 .75rem;">
                        <option value="0" disabled selected>مقطع تحصیلی</option>
                        @foreach ($Grades->sortBy('SettingTitle') as $grd)
                            <option value="{{ $grd->SettingValue }}">{{ $grd->SettingTitle }}</option>
                        @endforeach
                    </select>
                    @break
                @case (3)
                    <select class="form-control allWidth inputParams" data-ng-style="btn-primary" id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}" style="padding:0 .75rem;">
                        <option value="0" disabled selected>رشته تحصیلی</option>
                        @foreach ($Majors->sortBy('Title') as $mjr)
                        <option value="{{ $mjr->NidMajor }}">{{ $mjr->Title }}</option>
                        @endforeach
                    </select>
                    @break
                @case (4)
                    <select class="form-control allWidth inputParams" data-ng-style="btn-primary" id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}" style="padding:0 .75rem;">
                        <option value="0" disabled selected>گرایش</option>
                        @foreach ($Orientations->sortBy('MajorId') as $ore)
                        <option value="{{ $ore->NidOreintation }}">{{ $ore->Title }}</option>
                        @endforeach
                    </select>
                    @break
                @case (5)
                    <select class="form-control allWidth inputParams" data-ng-style="btn-primary" id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}" style="padding:0 .75rem;">
                        <option value="0" disabled selected>وضعیت خدمتی</option>
                        @foreach ($MillitaryStatuses->sortBy('SettingTitle') as $typ)
                        <option value="{{ $typ->SettingValue }}">{{ $typ->SettingTitle }}</option>
                        @endforeach
                    </select>
                    @break
                @case (6)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <input type="text" class="form-control form-control-user inputParams" id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}">
                    @break
            @endswitch
            @break
    @endswitch
@endif
