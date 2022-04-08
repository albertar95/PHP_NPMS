<style>
    label {
        overflow: hidden;
    }

</style>
<form class="user">
    <div class="form-group row" style="text-align:right;">
        <div class="col-sm-6" style="padding:.5rem;">
            @if (!empty($Scholar->ProfilePicture))
                <div class="frame">
                    <img src="{{ sprintf('/storage/images/%s', $Scholar->ProfilePicture) }}"
                        style="width:100%;height:10rem;" />
                </div>
            @else
                <label>نمایه : </label>
            @endforelse

        </div>
        <div class="col-sm-2" style="padding:.5rem;">
            <label>مشخصات محقق : </label>
        </div>
        <div class="col-sm-4">
            <label class="form-control">{{ $Scholar->FirstName }} {{ $Scholar->LastName }}</label>
        </div>
    </div>
    <div class="form-group row" style="text-align:right;">
        <div class="col-sm-2" style="padding:.5rem;">
            <label>نام پدر : </label>
        </div>
        <div class="col-sm-4">
            <label class="form-control">{{ $Scholar->FatherName }}</label>
        </div>
        <div class="col-sm-2" style="padding:.5rem;">
            <label>تاریخ تولد : </label>
        </div>
        <div class="col-sm-4">
            <label class="form-control">{{ $Scholar->BirthDate }}</label>
        </div>
    </div>
    <div class="form-group row" style="text-align:right;">
        <div class="col-sm-2" style="padding:.5rem;">
            <label>کد ملی : </label>
        </div>
        <div class="col-sm-4">
            <label class="form-control">{{ $Scholar->NationalCode }}</label>
        </div>
        <div class="col-sm-2" style="padding:.5rem;">
            <label>شماره همراه : </label>
        </div>
        <div class="col-sm-4">
            <label class="form-control">{{ $Scholar->Mobile }}</label>
        </div>
    </div>
    <div class="form-group row" style="text-align:right;">
        <div class="col-sm-2" style="padding:.5rem;">
            <label>مقطع تحصیلی : </label>
        </div>
        <div class="col-sm-4">
            <label class="form-control">{{ $Scholar->GradeTitle }}</label>
        </div>
        <div class="col-sm-2" style="padding:.5rem;">
            <label>وضعیت خدمتی : </label>
        </div>
        <div class="col-sm-4">
            <label class="form-control">{{ $Scholar->MillitaryStatusTitle }}</label>
        </div>
    </div>
    <div class="form-group row" style="text-align:right;">
        <div class="col-sm-2" style="padding:.5rem;">
            <label>رشته تحصیلی : </label>
        </div>
        <div class="col-sm-4">
            <label class="form-control">{{ $Scholar->Major->Title }}</label>
        </div>
        <div class="col-sm-2" style="padding:.5rem;">
            <label>گرایش : </label>
        </div>
        <div class="col-sm-4">
            <label class="form-control">{{ $Scholar->Oreintation->Title }}</label>
        </div>
    </div>
    <div class="form-group row" style="text-align:right;">
        <div class="col-sm-2" style="padding:.5rem;">
            <label>محل تحصیل : </label>
        </div>
        <div class="col-sm-4">
            <label class="form-control">{{ $Scholar->CollegeTitle }}</label>
        </div>
        <div class="col-sm-2" style="padding:.5rem;">
            <label>نوع همکاری : </label>
        </div>
        <div class="col-sm-4">
            <label class="form-control">{{ $Scholar->CollaborationTypeTitle }}</label>
        </div>
    </div>
    <div class="form-group row" style="text-align:right;">
        <div class="col-sm-2" style="padding:.5rem;">
            <label>تعداد طرح ها : </label>
        </div>
        <div class="col-sm-4">
            <label class="form-control">{{ $Scholar->Projects->count() }}</label>
        </div>
        <div class="col-sm-2" style="padding:.5rem;">
            <label>طرح ها : </label>
        </div>
        <div class="col-sm-4" style="display:table-column">
            @foreach ($Scholar->Projects as $proj)
                <label class="form-control">{{ $proj->Subject }}</label>
            @endforeach
        </div>
    </div>
    <div class="form-group row" style="text-align:right;">
        <div class="col-sm-2" style="padding:.5rem;">
            <label>فایل های ضمیمه : </label>
        </div>
        <div class="col-sm-4" style="display:table-column">
            @foreach ($datafiles as $file)
                <a href="{{ URL($file->FilePath) }}" target="_blank"
                    style="margin: 5px;">{{ $file->FileName }}</a>
            @endforeach
        </div>
        <div class="col-sm-2" style="padding:.5rem;">
        </div>
        <div class="col-sm-4">
        </div>
    </div>
    </div>
    <hr>
</form>
