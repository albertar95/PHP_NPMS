<div class="form-group row">
    <div class="col-sm-6 mb-3 mb-sm-0">
        <select class="form-control allWidth" data-ng-style="btn-primary" id="sltField" name="FieldId" placeholder="جستجو بر اساس" onchange="FieldChange()" style="padding:0 .75rem;">
            <option value="0" disabled selected>جستجو بر اساس</option>
            @foreach ($inputs as $inp)
                <option value="{{ $inp->FieldId }}" data-tokens="{{ $inp->PersianName }}">{{ $inp->PersianName }}</option>
            @endforeach
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
    @foreach ($inputs as $inp)
        <div class="col-sm-4">
            <div class="row" style="display:flex;">
                <input type="checkbox" style="width:1rem;margin:unset !important;" id="{{ $inp->FieldName }}" name="{{ $inp->FieldId }}" class="form-control" alt="in" />
                <label for="{{ $inp->FieldName }}" style="margin:.45rem .45rem 0 0">{{ $inp->PersianName }}</label>
            </div>
        </div>
    @endforeach
</div>
<div class="form-group row" style="text-align:right;">
    <div class="col-sm-3" style="padding:.5rem;">
        <label>خروجی ها : </label>
    </div>
</div>
<div class="form-group row" style="text-align:right;" id="OutputDiv">
    @foreach ($outputs as $outy)
        <div class="col-sm-4">
            <div class="row" style="display:flex;">
                <input type="checkbox" style="width:1rem;margin:unset !important;" id="{{ $outy->FieldName }}" name="{{ $outy->FieldId }}" class="form-control" alt="out" checked />
                <label for="{{ $outy->FieldName }}" style="margin:.45rem .45rem 0 0">{{ $outy->PersianName }}</label>
            </div>
        </div>
    @endforeach
</div>

