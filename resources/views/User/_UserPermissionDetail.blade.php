@model NPMS_WebUI.ViewModels.ManagePermissionViewModel

<form class="user">
    <div class="form-group row" style="text-align:right;">
        <div class="col-sm-2" style="padding:.5rem;">
            <label>نام : </label>
        </div>
        <div class="col-sm-4">
            <label class="form-control">@Model.User.FirstName</label>
        </div>
        <div class="col-sm-2" style="padding:.5rem;">
            <label>نام خانوادگی : </label>
        </div>
        <div class="col-sm-4">
            <label class="form-control">@Model.User.LastName</label>
        </div>
    </div>
    <div class="form-group row" style="text-align:right;">
        <div class="col-sm-2" style="padding:.5rem;">
            <label>نام کاربری : </label>
        </div>
        <div class="col-sm-4">
            <label class="form-control">@Model.User.Username</label>
        </div>
        <div class="col-sm-2" style="padding:.5rem;">
            <label>دسترسی کاربر : </label>
        </div>
        <div class="col-sm-4">
            @if (Model.User.IsAdmin)
            {
                <label class="form-control">کاربر ادمین</label>
            }
            else
            {
                <label class="form-control">کاربر عادی</label>
            }
        </div>
    </div>
    <div class="form-group row" style="text-align:right;">
        <div class="col-sm-3" style="padding:.5rem;">
            <label>دسترسی ها : </label>
        </div>
    </div>
    {{ $counter = $UserPermissions->Count/3; }}
    @for ($i = 0; $i <= $counter; $i++)
    {
        <div class="form-group row" style="text-align:right;">
            @foreach ($UserPermissions->Skip($i * 3)->Take(3) as $per)
            {
                <div class="col-sm-4">
                    <label class="form-control">@NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Id == per.ResourceId).FirstOrDefault().PersianTitle</label>
                </div>
            }
        </div>
    }
    <hr>
</form>

