@model Tuple<int,string>

{{-- @{
    NPMS_WebUI.ViewModels.SharedLayoutViewModel slvm = new NPMS_WebUI.ViewModels.SharedLayoutViewModel(null,1);
    var tmpparam = NPMS_WebUI.ViewModels.SharedLayoutViewModel.ReportParametersInfos.Where(p => p.ParameterType == 0 && p.TypeId == Model.Item1 && p.FieldName == Model.Item2).FirstOrDefault();
} --}}
@if (!is_null($tmpparam))
{
    @switch ($ReportType)
    {
        @case (1)
            @switch ($tmpparam->FieldId)
            {
                @case (1)
                    <label style="text-align:right;margin-top:.45rem;">{{ $tmpparam->PersianName }}</label>
                    <input type="text" class="form-control form-control-user inputParams" id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}">
                    @break
                @case (2)
                    <select class="form-control allWidth inputParams" data-ng-style="btn-primary" id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}" style="padding:0 .75rem;">
                        <option value="0" disabled selected>مقطع تحصیلی</option>
                        {{-- @foreach (var grd in slvm.GetGrades().OrderBy(p => p.SettingTitle))
                        {
                            <option value="@grd.SettingValue">@grd.SettingTitle</option>
                        } --}}
                    </select>
                    @break
                @case (3)
                    <select class="form-control allWidth inputParams" data-ng-style="btn-primary" id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}" style="padding:0 .75rem;">
                        <option value="0" disabled selected>رشته تحصیلی</option>
                        {{-- @foreach (var mjr in slvm.GetMajors().OrderBy(p => p.Title))
                        {
                            <option value="@mjr.NidMajor">@mjr.Title</option>
                        } --}}
                    </select>
                    @break
                @case (4)
                    <select class="form-control allWidth inputParams" data-ng-style="btn-primary" id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}" style="padding:0 .75rem;">
                        <option value="0" disabled selected>گرایش</option>
                        {{-- @foreach (var ore in slvm.GetOrientations().OrderBy(p => p.MajorId))
                        {
                            <option value="@ore.NidOreintation">@ore.Title</option>
                        } --}}
                    </select>
                    @break
                @case (5)
                    <select class="form-control allWidth inputParams" data-ng-style="btn-primary" id="{{ $tmpparam->FieldName }}" name="{{ $tmpparam->FieldName }}" style="padding:0 .75rem;">
                        <option value="0" disabled selected>وضعیت خدمتی</option>
                        {{-- @foreach (var typ in slvm.GetMillitaryStatuses().OrderBy(p => p.SettingTitle))
                        {
                            <option value="@typ.SettingValue">@typ.SettingTitle</option>
                        } --}}
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
