@extends('Layouts.app')

@section('Content')

    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-md-12 col-sm-12 mb-6">
            <div class="card shadow border-left-success" style="margin-bottom:1rem;">
                <!-- Card Header - Accordion -->
                <a href="#collapsePersonalInfo" style="text-align:right;" class="d-block card-header py-3 collapsed"
                    data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapsePersonalInfo">
                    <h6 class="m-0 font-weight-bold text-primary">اطلاعات شخصی</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse" style="padding:.75rem;" id="collapsePersonalInfo">
                    <div class="card-body">
                        <div class="form-group row" style="text-align:right;">
                            <div class="col-sm-6" style="padding:.5rem;">
                                @if (!empty($Users->ProfilePicture))
                                    <div class="frame">
                                        <img src="/storage/images/{{ $Users->ProfilePicture }}"
                                            style="width:100%;height:10rem;" />
                                    </div>
                                @else
                                    <label>نمایه : </label>
                                @endforelse
                            </div>
                            <div class="col-sm-2" style="padding:.5rem;">
                                <label>نام کاربری : </label>
                            </div>
                            <div class="col-sm-4">
                                <label style="height: auto;" class="form-control">{{ $Users->Username }}</label>
                            </div>
                        </div>
                        <div class="form-group row" style="text-align:right;">
                            <div class="col-sm-2" style="padding:.5rem;">
                                <label>نام : </label>
                            </div>
                            <div class="col-sm-4">
                                <label style="height: auto;" class="form-control">{{ $Users->FirstName }}</label>
                            </div>
                            <div class="col-sm-2" style="padding:.5rem;">
                                <label>نام خانوادگی : </label>
                            </div>
                            <div class="col-sm-4">
                                <label style="height: auto;" class="form-control">{{ $Users->LastName }}</label>
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
                                <label class="form-control" dir="ltr" style="text-align: right;height: auto;">{{ $Users->CreateDate }}</label>
                            </div>
                            <div class="col-sm-2" style="padding:.5rem;">
                                <label>تاریخ آخرین ورود به سیستم : </label>
                            </div>
                            <div class="col-sm-4">
                                @if (!empty($Users->LastLoginDate))
                                    <label
                                        class="form-control" dir="ltr" style="text-align: right;height: auto;">{{ $Users->LastLoginDate }}</label>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row" style="text-align:right;">
                            <div class="col-sm-2" style="padding:.5rem;">
                                <label>نقش کاربر : </label>
                            </div>
                            <div class="col-sm-4">
                                <label style="height: auto;" class="form-control">{{ $Users->RoleTitle }}</label>
                            </div>
                            <div class="col-sm-2" style="padding:.5rem;">
                                <label>تعداد کلمه عبور اشتباه وارد شده : </label>
                            </div>
                            <div class="col-sm-4">
                                <label style="height: auto;"
                                    class="form-control">{{ $Users->IncorrectPasswordCount }}</label>
                            </div>
                        </div>
                        <div class="form-group row" style="text-align:right;">
                            <div class="col-sm-2" style="padding:.5rem;">
                                <label>وضعیت کاربر : </label>
                            </div>
                            <div class="col-sm-4">
                                @if ($Users->IsDisabled)
                                    <label style="height: auto;" class="form-control">غیر فعال</label>
                                @elseif ($Users->IsLockedOut)
                                    <label style="height: auto;" class="form-control">کاربر تعلیق شده</label>
                                @elseif (!$Users->IsDisabled)
                                    <label style="height: auto;" class="form-control">فعال</label>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-md-12 col-sm-12 mb-6">
            <div class="card shadow border-left-danger" style="margin-bottom:1rem;">
                <!-- Card Header - Accordion -->
                <a href="#collapseSecurity" style="text-align:right;" class="d-block card-header py-3 collapsed"
                    data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseSecurity">
                    <h6 class="m-0 font-weight-bold text-primary">امنیت</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse" style="padding:.75rem;" id="collapseSecurity">
                    <div class="card-body">
                        <div class="col-sm-6 col-lg-6" style="margin-bottom: 2rem;">
                            <a class="btn btn-outline-primary btn-block"
                                href="{{ sprintf('%s/%s', URL::to('/changepassword'), auth()->user()->NidUser) }} }}"><i
                                    class="fa fa-lock"></i> تغییر کلمه عبور</a>
                        </div>
                        @if (!is_null($logs))
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">گزارش ورود کاربر</h1>
                            </div>
                            <div class="table-responsive" dir="ltr">
                                <table class="table table-bordered" id="dataTable1"
                                    style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>تاریخ</th>
                                            <th>زمان</th>
                                            <th>نام کاربری</th>
                                            <th>توضیحات</th>
                                            <th>ای پی</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($logins as $lg)
                                            <tr>
                                                <td>{{ $lg->LogDate ?? '' }}</td>
                                                <td>{{ $lg->LogTime ?? '' }}</td>
                                                <td>{{ $lg->Username ?? '' }}</td>
                                                <td>{{ $lg->Description ?? '' }}</td>
                                                <td>{{ $lg->IP ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-md-12 col-sm-12 mb-6">
            <div class="card shadow border-left-primary" style="margin-bottom:1rem;">
                <!-- Card Header - Accordion -->
                <a href="#collapseUserLog" style="text-align:right;" class="d-block card-header py-3 collapsed"
                    data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseUserLog">
                    <h6 class="m-0 font-weight-bold text-primary">گزارش کاربری</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse" style="padding:.75rem;" id="collapseUserLog">
                    <div class="card-body">
                        @if (!is_null($logs))

                            <div class="table-responsive" dir="ltr">
                                <table class="table table-bordered" id="userlogdataTable"
                                    style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>تاریخ</th>
                                            <th>زمان</th>
                                            <th>نام کاربری</th>
                                            <th>نوع فعالیت</th>
                                            <th>توضیحات</th>
                                            <th>ای پی</th>
                                            <th>درجه اهمیت</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($logs as $lg)
                                            <tr>
                                                <td>{{ $lg->PersianLogDate ?? '' }}</td>
                                                <td>{{ $lg->LogTime ?? '' }}</td>
                                                <td>{{ $lg->Username ?? '' }}</td>
                                                <td>{{ $lg->ActionName ?? '' }}</td>
                                                <td>{{ $lg->Description ?? '' }}</td>
                                                <td>{{ $lg->IP ?? '' }}</td>
                                                @switch($lg->ImportanceLevel)
                                                    @case(1)
                                                        <td>عادی</td>
                                                    @break

                                                    @case(2)
                                                        <td>مهم</td>
                                                    @break

                                                    @case(3)
                                                        <td>خیلی مهم</td>
                                                    @break

                                                    @default
                                                        <td></td>
                                                @endswitch
                                                {{-- <td>{{ $lg->ImportanceLevel ?? '' }}</td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-md-12 col-sm-12 mb-6">
            <div class="card shadow border-left-warning" style="margin-bottom:1rem;">
                <!-- Card Header - Accordion -->
                <a href="#collapsePermissions" style="text-align:right;" class="d-block card-header py-3 collapsed"
                    data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapsePermissions">
                    <h6 class="m-0 font-weight-bold text-primary">دسترسی ها</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse" style="padding:.75rem;" id="collapsePermissions">
                    <div class="card-body">
                        <div class="table-responsive" dir="ltr">
                            <table class="table table-bordered" id="permdataTable" cellspacing="0"
                                style="width:100%;direction:rtl;text-align:center;">
                                <thead>
                                    <tr>
                                        <th>نام نقش / کاربر</th>
                                        <th>نام موجودیت</th>
                                        <th>دسترسی ایجاد</th>
                                        <th>دسترسی ویرایش</th>
                                        <th>دسترسی حذف</th>
                                        <th>دسترسی جزییات</th>
                                        <th>دسترسی محرمانه</th>
                                        <th>دسترسی لیست</th>
                                        <th>دسترسی چاپ</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>نام نقش / کاربر</th>
                                        <th>نام موجودیت</th>
                                        <th>دسترسی ایجاد</th>
                                        <th>دسترسی ویرایش</th>
                                        <th>دسترسی حذف</th>
                                        <th>دسترسی جزییات</th>
                                        <th>دسترسی محرمانه</th>
                                        <th>دسترسی لیست</th>
                                        <th>دسترسی چاپ</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($Permissions as $perm)
                                        <tr>
                                            <td>{{ $perm->RoleTitle }}</td>
                                            @if ($perm->EntityId == 1)
                                                <td>محقق</td>
                                            @elseif($perm->EntityId == 2)
                                                <td>پروژه</td>
                                            @elseif($perm->EntityId == 3)
                                                <td>کاربر</td>
                                            @elseif($perm->EntityId == 4)
                                                <td>گزارش</td>
                                            @elseif($perm->EntityId == 5)
                                                <td>پیام</td>
                                            @elseif($perm->EntityId == 6)
                                                <td>اطلاعات پایه</td>
                                            @endforelse
                                            @if ($perm->Create)
                                                <td>دارد</td>
                                            @else
                                                <td>ندارد</td>
                                            @endforelse
                                            @if ($perm->Edit)
                                                <td>دارد</td>
                                            @else
                                                <td>ندارد</td>
                                            @endforelse
                                            @if ($perm->Delete)
                                                <td>دارد</td>
                                            @else
                                                <td>ندارد</td>
                                            @endforelse
                                            @if ($perm->Detail)
                                                <td>دارد</td>
                                            @else
                                                <td>ندارد</td>
                                            @endforelse
                                            @if ($perm->Confident)
                                                <td>دارد</td>
                                            @else
                                                <td>ندارد</td>
                                            @endforelse
                                            @if ($perm->List)
                                                <td>دارد</td>
                                            @else
                                                <td>ندارد</td>
                                            @endforelse
                                            @if ($perm->Print)
                                                <td>دارد</td>
                                            @else
                                                <td>ندارد</td>
                                            @endforelse
                                        </tr>
                                    @endforeach
                                    @foreach ($userPermissions as $perm2)
                                        <tr>
                                            <td>{{ $Users->Username }}</td>
                                            @if ($perm2->EntityId == 1)
                                                <td>محقق</td>
                                            @elseif($perm2->EntityId == 2)
                                                <td>پروژه</td>
                                            @elseif($perm2->EntityId == 3)
                                                <td>کاربر</td>
                                            @elseif($perm2->EntityId == 4)
                                                <td>گزارش</td>
                                            @elseif($perm2->EntityId == 5)
                                                <td>پیام</td>
                                            @elseif($perm2->EntityId == 6)
                                                <td>اطلاعات پایه</td>
                                            @endforelse
                                            @if ($perm2->Create)
                                                <td>دارد</td>
                                            @else
                                                <td>ندارد</td>
                                            @endforelse
                                            @if ($perm2->Edit)
                                                <td>دارد</td>
                                            @else
                                                <td>ندارد</td>
                                            @endforelse
                                            @if ($perm2->Delete)
                                                <td>دارد</td>
                                            @else
                                                <td>ندارد</td>
                                            @endforelse
                                            @if ($perm2->Detail)
                                                <td>دارد</td>
                                            @else
                                                <td>ندارد</td>
                                            @endforelse
                                            @if ($perm2->Confident)
                                                <td>دارد</td>
                                            @else
                                                <td>ندارد</td>
                                            @endforelse
                                            @if ($perm2->List)
                                                <td>دارد</td>
                                            @else
                                                <td>ندارد</td>
                                            @endforelse
                                            @if ($perm2->Print)
                                                <td>دارد</td>
                                            @else
                                                <td>ندارد</td>
                                            @endforelse
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @section('styles')
        <link href="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
        <title>سامانه مدیریت تحقیقات - پروفایل</title>
        <style>
            label {
                overflow: hidden;
            }

        </style>
    @endsection
    @section('scripts')
        <script src="{{ URL('Content/vendor/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ URL('Content/js/demo/datatables-demo.js') }}"></script>
        <script type="text/javascript">
            $(function() {
                $('#userlogdataTable').DataTable({
                    "order": [
                        [0, "desc"],
                        [1, "desc"]
                    ],
                });
                $('#permdataTable').DataTable();
            });
        </script>
    @endsection

@endsection
