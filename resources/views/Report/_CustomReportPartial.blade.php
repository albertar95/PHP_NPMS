@model int

<div class="form-group row">
    <div class="col-sm-6 mb-3 mb-sm-0">
        <select class="form-control allWidth" data-ng-style="btn-primary" id="sltField" name="FieldId" onchange="FieldChange()" style="padding:0 .75rem;">
            <option value="0" disabled selected>جستجو بر اساس</option>
            {{-- @foreach (var inp in NPMS_WebUI.ViewModels.SharedLayoutViewModel.ReportParametersInfos.Where(p => p.TypeId == Model && p.ParameterType == 0))
            {
                <option value="@inp.FieldId">{{ $inp->PersianName }}</option>
            } --}}
        </select>
    </div>
    <div class="col-sm-6">
    </div>
</div>
<div class="form-group row" style="text-align:right;">
    <div class="col-sm-3" style="padding:.5rem;">
        <label>ورودی ها : </label>
    </div>
</div>
<div class="form-group row" style="text-align:right;" id="InputDiv">
    {{-- @foreach (var inp in NPMS_WebUI.ViewModels.SharedLayoutViewModel.ReportParametersInfos.Where(p => p.TypeId == Model && p.ParameterType == 0))
    {
        <div class="col-sm-4">
            <div class="row" style="display:flex;">
                <input type="checkbox" style="width:1rem;margin:unset !important;" id="@inp.FieldName" name="@inp.FieldId" class="form-control" alt="in" />
                <label for="@inp.FieldName" style="margin:.45rem .45rem 0 0">@inp.PersianName</label>
            </div>
        </div>
    } --}}
</div>
<div class="form-group row" style="text-align:right;">
    <div class="col-sm-3" style="padding:.5rem;">
        <label>خروجی ها : </label>
    </div>
</div>
<div class="form-group row" style="text-align:right;" id="OutputDiv">
    {{-- @foreach (var inp in NPMS_WebUI.ViewModels.SharedLayoutViewModel.ReportParametersInfos.Where(p => p.TypeId == Model && p.ParameterType == 1))
    {
        <div class="col-sm-4">
            <div class="row" style="display:flex;">
                <input type="checkbox" style="width:1rem;margin:unset !important;" id="@inp.FieldName" name="@inp.FieldId" class="form-control" alt="out" checked />
                <label for="@inp.FieldName" style="margin:.45rem .45rem 0 0">@inp.PersianName</label>
            </div>
        </div>
    } --}}
</div>

