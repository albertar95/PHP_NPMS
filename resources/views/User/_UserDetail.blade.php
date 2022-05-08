<style>
label
{
    overflow: hidden;
}
</style>
<form class="user">
    <div class="form-group row" style="text-align:right;">
              <div class="col-sm-6" style="padding:.5rem;">
                @if (!empty($Users->ProfilePicture))
                  <div class="frame">
                          <img src="/storage/images/{{ $Users->ProfilePicture }}" style="width:100%;height:10rem;" />
                  </div>
                  @else
                  <label>نمایه : </label>
                  @endforelse
            </div>
            <div class="col-sm-2" style="padding:.5rem;">
                <label>نام کاربری : </label>
            </div>
            <div class="col-sm-4">
                <label class="form-control">{{ $Users->Username }}</label>
            </div>
        </div>
    <div class="form-group row" style="text-align:right;">
        <div class="col-sm-2" style="padding:.5rem;">
            <label>نام : </label>
        </div>
        <div class="col-sm-4">
            <label class="form-control">{{ $Users->FirstName }}</label>
        </div>
        <div class="col-sm-2" style="padding:.5rem;">
            <label>نام خانوادگی : </label>
        </div>
        <div class="col-sm-4">
            <label class="form-control">{{ $Users->LastName }}</label>
        </div>
    </div>
    <div class="form-group row" style="text-align:right;">
        <div class="col-sm-2" style="padding:.5rem;">
            <label>تاریخ ایجاد کاربر : </label>
        </div>
        <div class="col-sm-4">
            <label class="form-control" dir="ltr" style="text-align: right;">{{ $Users->CreateDate }}</label>
        </div>
        <div class="col-sm-2" style="padding:.5rem;">
            <label>تاریخ آخرین ورود به سیستم : </label>
        </div>
        <div class="col-sm-4">
            @if (!empty($Users->LastLoginDate))
                <label class="form-control" dir="ltr" style="text-align: right;">{{ $Users->LastLoginDate }}</label>
            @else
            <label class="form-control"></label>
            @endforelse
        </div>
    </div>
    <div class="form-group row" style="text-align:right;">
        <div class="col-sm-2" style="padding:.5rem;">
            <label>نوع کاربر : </label>
        </div>
        <div class="col-sm-4">
            <label class="form-control">{{ $Users->RoleTitle }}</label>
        </div>
        <div class="col-sm-2" style="padding:.5rem;">
            <label>تعداد کلمه عبور اشتباه وارد شده : </label>
        </div>
        <div class="col-sm-4">
            <label class="form-control">{{ $Users->IncorrectPasswordCount }}</label>
        </div>
    </div>
    <div class="form-group row" style="text-align:right;">
        <div class="col-sm-2" style="padding:.5rem;">
            <label>وضعیت کاربر : </label>
        </div>
        <div class="col-sm-4">
            @if ($Users->IsDisabled)
                <label class="form-control">غیر فعال</label>
            @elseif ($Users->IsLockedOut)
                <label class="form-control">کاربر تعلیق شده</label>
            @elseif (!$Users->IsDisabled)
                <label class="form-control">فعال</label>
            @endforelse
        </div>
    </div>
</form>

