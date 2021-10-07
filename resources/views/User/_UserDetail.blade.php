<form class="user">
    <div class="form-group row" style="text-align:right;">
              <div class="col-sm-6" style="padding:.5rem;">
                  <div class="frame">
                      @if (!is_null($ProfilePicture))
                          {{ $imgSrc = string.sprintf("data:image/jpg;base64,%s", $ProfilePicture); }}
                          <img src="{{ $imgSrc }}" style="width:100%;height:10rem;" />
                      @endif
                      @else
                        <img src="" style="width:100%;height:10rem;" alt="بدون نمایه" />
                      @endforelse
                  </div>
            </div>
            <div class="col-sm-2" style="padding:.5rem;">
                <label>نام کاربری : </label>
            </div>
            <div class="col-sm-4">
                <label class="form-control">@Model.Username</label>
            </div>
        </div>
    <div class="form-group row" style="text-align:right;">
        <div class="col-sm-2" style="padding:.5rem;">
            <label>نام : </label>
        </div>
        <div class="col-sm-4">
            <label class="form-control">@Model.FirstName</label>
        </div>
        <div class="col-sm-2" style="padding:.5rem;">
            <label>نام خانوادگی : </label>
        </div>
        <div class="col-sm-4">
            <label class="form-control">@Model.LastName</label>
        </div>
    </div>
    <div class="form-group row" style="text-align:right;">
        {{-- @{
            System.Globalization.PersianCalendar pc = new System.Globalization.PersianCalendar();
            string Create = $"{pc.GetYear(Model.CreateDate)}/{pc.GetMonth(Model.CreateDate)}/{pc.GetDayOfMonth(Model.CreateDate)}";
            string Login = $"{pc.GetYear(Model.LastLoginDate ?? DateTime.Now)}/{pc.GetMonth(Model.LastLoginDate ?? DateTime.Now)}/{pc.GetDayOfMonth(Model.LastLoginDate ?? DateTime.Now)}";
            } --}}
        <div class="col-sm-2" style="padding:.5rem;">
            <label>تاریخ ایجاد کاربر : </label>
        </div>
        <div class="col-sm-4">
            <label class="form-control">@Create</label>
        </div>
        <div class="col-sm-2" style="padding:.5rem;">
            <label>تاریخ آخرین ورود به سیستم : </label>
        </div>
        <div class="col-sm-4">
            @if (!is_null($LastLoginDate))
            {
                <label class="form-control">{{ $Login }}</label>
            }
        </div>
    </div>
    <div class="form-group row" style="text-align:right;">
        <div class="col-sm-2" style="padding:.5rem;">
            <label>نوع کاربر : </label>
        </div>
        <div class="col-sm-4">
            @if ($IsAdmin)
                <label class="form-control">کاربر ادمین</label>
            @endif
            @else
                <label class="form-control">کاربر عادی</label>
            @endforelse
        </div>
        <div class="col-sm-2" style="padding:.5rem;">
            <label>تعداد کلمه عبور اشتباه وارد شده : </label>
        </div>
        <div class="col-sm-4">
            <label class="form-control">{{ $IncorrectPasswordCount }}</label>
        </div>
    </div>
    <div class="form-group row" style="text-align:right;">
        <div class="col-sm-2" style="padding:.5rem;">
            <label>وضعیت کاربر : </label>
        </div>
        <div class="col-sm-4">
            @if ($IsDisabled)
                <label class="form-control">غیر فعال</label>
            @endif
            @elseif ($IsLockedOut)
                <label class="form-control">کاربر تعلیق شده</label>
            @elseif (!$IsDisabled)
                <label class="form-control">فعال</label>
            @endforelse
        </div>
    </div>
</form>

